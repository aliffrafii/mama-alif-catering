<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            {{ $isAdmin ? 'Pesanan Terbaru' : 'Pesanan Terbaru Anda' }}
        </h2>
        <a href="{{ route('orders.index') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
            Lihat Semua
        </a>
    </div>

    @if (count($orders) > 0)
        @if ($isAdmin)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="border-l-4 border-orange-500 pl-4 py-2 hover:bg-gray-50 rounded transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">{{ $order['order_number'] }}</p>
                                <p class="text-sm text-gray-600">{{ $order['user']['name'] ?? 'Customer' }}</p>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-medium @switch($order['status'])
                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                @case('confirmed') bg-blue-100 text-blue-800 @break
                                @case('processing') bg-purple-100 text-purple-800 @break
                                @case('ready') bg-green-100 text-green-800 @break
                                @case('completed') bg-green-100 text-green-800 @break
                                @default bg-red-100 text-red-800
                            @endswitch">
                                {{ ucfirst($order['status']) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Rp {{ number_format($order['total_price'], 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">No. Pesanan</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Tanggal</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Total</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $order['order_number'] }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium text-orange-500">Rp
                                    {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium @switch($order['status'])
                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                        @case('confirmed') bg-blue-100 text-blue-800 @break
                                        @case('processing') bg-purple-100 text-purple-800 @break
                                        @case('ready') bg-green-100 text-green-800 @break
                                        @case('completed') bg-green-100 text-green-800 @break
                                        @default bg-red-100 text-red-800
                                    @endswitch">
                                        {{ ucfirst($order['status']) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('orders.show', $order['id']) }}"
                                        class="text-orange-500 hover:text-orange-600 font-medium">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 mb-4">
                {{ $isAdmin ? 'Belum ada pesanan' : 'Belum ada pesanan. Mulai pesan makanan favorit Anda sekarang!' }}
            </p>
            @if (!$isAdmin)
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                    Belanja Sekarang
                </a>
            @endif
        </div>
    @endif
</div>
