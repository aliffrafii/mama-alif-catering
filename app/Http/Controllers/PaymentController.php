<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    private function setupMidtrans(): void
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    private function syncStatusFromMidtrans(Order $order): void
    {
        if (!$order->midtrans_order_id) return;
        if (in_array($order->status, ['confirmed', 'completed', 'cancelled'])) return;

        try {
            $this->setupMidtrans();

            // Transaction::status() mengembalikan stdClass — akses pakai ->property
            /** @var \stdClass $result */
            $result = Transaction::status($order->midtrans_order_id);

            $txStatus = $result->transaction_status ?? null;
            $fraud    = $result->fraud_status ?? null;

            Log::info('MIDTRANS STATUS CHECK', [
                'order'              => $order->order_number,
                'midtrans_order_id'  => $order->midtrans_order_id,
                'transaction_status' => $txStatus,
                'fraud_status'       => $fraud,
            ]);

            if (
                $txStatus === 'settlement' ||
                ($txStatus === 'capture' && $fraud === 'accept')
            ) {
                $order->update([
                    'status'         => 'confirmed',
                    'transaction_id' => $result->transaction_id ?? null,
                    'payment_type'   => $result->payment_type   ?? null,
                ]);
            } elseif (in_array($txStatus, ['cancel', 'deny', 'expire'])) {
                // Biarkan pending supaya user bisa retry
                Log::info('MIDTRANS: transaksi ' . $txStatus . ' untuk ' . $order->order_number);
            }
        } catch (\Exception $e) {
            // Gagal cek = diam, jangan ubah status
            Log::warning('MIDTRANS STATUS CHECK FAILED: ' . $e->getMessage());
        }
    }

    // =========================================================
    // Callback server-to-server dari Midtrans
    // =========================================================
    public function callback(Request $request)
    {
        Log::info('MIDTRANS CALLBACK', $request->all());

        $order = Order::where('order_number', $request->order_id)
            ->orWhere('midtrans_order_id', $request->order_id)
            ->first();

        if (!$order) {
            Log::warning('CALLBACK: order not found', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $txStatus = $request->transaction_status;
        $fraud    = $request->fraud_status;

        if (
            $txStatus === 'settlement' ||
            ($txStatus === 'capture' && $fraud === 'accept')
        ) {
            $order->update([
                'status'         => 'confirmed',
                'transaction_id' => $request->transaction_id,
                'payment_type'   => $request->payment_type,
            ]);
        }

        return response()->json(['success' => true]);
    }

    // =========================================================
    // Finish: user redirect balik dari Midtrans setelah bayar
    // (dipakai untuk finish, unfinish, DAN error callback)
    // =========================================================
    public function finish(Request $request)
    {
        $midtransOrderId = $request->query('order_id');

        $order = null;

        if ($midtransOrderId) {
            $order = Order::where('midtrans_order_id', $midtransOrderId)
                ->orWhere('order_number', $midtransOrderId)
                ->where('user_id', Auth::id())
                ->first();
        }

        if (!$order) {
            $order = Order::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->first();
        }

        if ($order) {
            $this->syncStatusFromMidtrans($order);
            $order->refresh();

            if ($order->status === 'confirmed') {
                return redirect()->route('payment.success', $order->id_order);
            }
        }

        return redirect()->route('orders.index')
            ->with('info', 'Silakan cek status pembayaran di halaman pesanan.');
    }

    // =========================================================
    // Retry: user klik "Bayar Sekarang" pada order pending
    // Selalu generate snap token BARU supaya tidak pernah expired
    // =========================================================
    public function retry(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        // Cek dulu ke Midtrans — mungkin sudah lunas tapi callback belum masuk
        $this->syncStatusFromMidtrans($order);
        $order->refresh();

        if (in_array($order->status, ['confirmed', 'completed'])) {
            return redirect()->route('payment.success', $order->id_order);
        }

        $this->setupMidtrans();

        // Selalu generate order_id & snap token baru (tidak reuse token lama)
        $newMidtransOrderId = $order->order_number . '-R' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $newMidtransOrderId,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
            'callbacks' => [
                'finish'   => route('payment.finish'),
                'unfinish' => route('payment.finish'),
                'error'    => route('payment.finish'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update([
            'snap_token'        => $snapToken,
            'midtrans_order_id' => $newMidtransOrderId,
        ]);

        return redirect()->route('payment.show', $order->id_order);
    }
}
