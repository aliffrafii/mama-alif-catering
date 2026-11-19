<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Kelola Pelanggan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="alert bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl p-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">Total {{ $customers->total() }} pelanggan</p>
            </div>

            <div class="rounded-2xl bg-base-100 shadow overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jumlah Pesanan</th>
                            <th>Total Belanja</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="font-semibold">{{ $customer->name }}</td>
                                <td class="text-sm opacity-70">{{ $customer->email }}</td>
                                <td>{{ $customer->orders_count }}</td>
                                <td>Rp {{ number_format($customer->orders_sum_total_price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.customers.show', $customer) }}"
                                            class="text-blue-500 hover:underline text-sm">Detail</a>
                                        <a href="{{ route('admin.customers.edit', $customer) }}"
                                            class="text-yellow-500 hover:underline text-sm">Edit</a>
                                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}"
                                            onsubmit="return confirm('Hapus pelanggan {{ $customer->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $customers->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
