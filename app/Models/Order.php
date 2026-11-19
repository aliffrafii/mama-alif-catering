<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $primaryKey = 'id_order';
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_price',
        'notes',
        'delivery_date',
        'delivery_address',
        'phone',
        'rating',
        'review',
        'shipping_cost',
        // Midtrans
        'snap_token',
        'midtrans_order_id',
        'transaction_id',
        'payment_type',
        // Garansi
        'completed_at',
        'warranty_note',
        'warranty_claimed_at',
        'warranty_status',
        'warranty_response',
        'warranty_responded_at',
    ];

    protected $casts = [
        'delivery_date'       => 'datetime',
        'total_price'         => 'integer',
        'completed_at'        => 'datetime',
        'warranty_claimed_at' => 'datetime',
        'warranty_responded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id_user'
        );
    }

    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id',
            'id_order'
        );
    }

    /**
     * Durasi garansi (jam) berdasarkan kategori produk pertama di order.
     * Nasi Box (1) = 3 jam, Prasmanan (2) = 5 jam, Nasi Tumpeng (3) = tanpa garansi.
     */
    public function warrantyHours(): ?int
    {
        $catId = $this->orderItems->first()->product->category_id ?? null;

        return match ($catId) {
            1 => 3,
            2 => 5,
            default => null,
        };
    }

    public function warrantyDeadline(): ?Carbon
    {
        $hours = $this->warrantyHours();

        if (!$hours || !$this->completed_at) {
            return null;
        }

        return $this->completed_at->copy()->addHours($hours);
    }

    public function isWarrantyActive(): bool
    {
        $deadline = $this->warrantyDeadline();

        return $deadline
            && now()->lt($deadline)
            && !$this->warranty_claimed_at;
    }

    public function hasWarrantyExpired(): bool
    {
        $deadline = $this->warrantyDeadline();

        return $deadline && now()->gte($deadline) && !$this->warranty_claimed_at;
    }
    public function warrantyTimeLeftLabel(): ?string
    {
        $deadline = $this->warrantyDeadline();

        if (!$deadline || now()->gte($deadline)) {
            return null;
        }

        $minutesLeft = now()->diffInMinutes($deadline);

        if ($minutesLeft < 60) {
            return "Kurang dari 1 jam lagi";
        }

        $hoursLeft = intdiv($minutesLeft, 60);

        return "Berlaku {$hoursLeft} jam lagi";
    }
    public function warrantyStatusConfig(): array
    {
        return match ($this->warranty_status) {
            'diproses' => ['label' => 'Sedang Diproses', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200'],
            'selesai'  => ['label' => 'Selesai Ditangani', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
            default    => ['label' => 'Menunggu Ditinjau', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'border' => 'border-gray-200'],
        };
    }
}
