<div class="space-y-4">
    @if (session('success'))
        <div class="alert alert-success shadow">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-extrabold">Manage Customers</h1>
                    <p class="text-sm opacity-70">Cari customer, ubah data, ubah password, dan kelola role.</p>
                </div>

                <div class="flex gap-2">
                    <input type="text" class="input input-bordered w-full sm:w-64" placeholder="Cari nama / email..."
                        wire:model.live="search" />
                    <select class="select select-bordered" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <div class="divider my-3"></div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td class="font-semibold">{{ $c->name }}</td>
                                <td class="opacity-80">{{ $c->email }}</td>
                                <td>
                                    <span class="badge badge-ghost">{{ $c->role }}</span>
                                </td>
                                <td class="text-sm opacity-70">{{ $c->created_at?->format('Y-m-d') }}</td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-primary" wire:click="openEdit({{ $c->id }})">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="alert">
                                        <span>Tidak ada customer ditemukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    @if ($openEdit)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" wire:click="$set('openEdit', false)"></div>

            <div class="relative w-full max-w-lg">
                <div class="card bg-base-100 shadow-2xl">
                    <div class="card-body">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-lg font-extrabold">Edit Customer</h2>
                                <p class="text-sm opacity-70">Ubah data customer dengan aman.</p>
                            </div>
                            <button class="btn btn-sm btn-ghost" wire:click="$set('openEdit', false)">✕</button>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <label class="label"><span class="label-text">Name</span></label>
                                <input class="input input-bordered w-full" wire:model="name" type="text">
                                @error('name')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label"><span class="label-text">Email</span></label>
                                <input class="input input-bordered w-full" wire:model="email" type="email">
                                @error('email')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label"><span class="label-text">Role</span></label>
                                <select class="select select-bordered w-full" wire:model="role">
                                    <option value="customer">customer</option>
                                    <option value="admin">admin</option>
                                </select>
                                @error('role')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label"><span class="label-text">New Password (opsional)</span></label>
                                <input class="input input-bordered w-full" wire:model="newPassword" type="password"
                                    placeholder="min 6 karakter">
                                @error('newPassword')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <button class="btn btn-ghost" wire:click="$set('openEdit', false)">Batal</button>
                            <button class="btn btn-primary" wire:click="save">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
