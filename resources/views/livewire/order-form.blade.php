<div class="max-w-xl mx-auto space-y-4">

    {{-- STEP: FORM --}}
    @if ($step === 'form')

        {{-- Paket dipilih --}}
        <div class="rounded-2xl bg-base-100 shadow p-5 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide opacity-50 font-semibold mb-0.5">Paket dipilih</p>
                <p class="font-bold text-lg">{{ $nama_paket }}</p>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold">Rp {{ number_format($hargaMap[$paket] ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs opacity-50">per porsi</p>
            </div>
        </div>

        {{-- Form --}}
        <div class="rounded-2xl bg-base-100 shadow p-5 space-y-4">
            <p class="font-bold text-sm">Detail Acara</p>

            <div class="space-y-1">
                <label class="text-sm font-semibold">Nama Acara</label>
                <input type="text" wire:model="nama_acara" placeholder="cth: Pernikahan Budi & Sari"
                    class="input input-bordered w-full">
                @error('nama_acara')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-semibold">Tanggal Acara</label>
                <input type="date" wire:model="tanggal_acara" min="{{ now()->addDays(3)->format('Y-m-d') }}"
                    class="input input-bordered w-full">
                <p class="text-xs opacity-40">Minimal 3 hari dari hari ini
                    ({{ now()->addDays(3)->translatedFormat('d F Y') }}).</p>
                @error('tanggal_acara')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-semibold">Jumlah Porsi</label>
                <input type="number" wire:model.live="jumlah_porsi" min="50" class="input input-bordered w-full">
                <p class="text-xs opacity-40">Minimal 50 porsi.</p>
                @error('jumlah_porsi')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-semibold">No. WhatsApp</label>
                <input type="text" wire:model="phone" placeholder="cth: 08123456789"
                    class="input input-bordered w-full">
                @error('phone')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-semibold">Alamat Acara</label>
                <textarea wire:model="alamat" rows="3" placeholder="Tulis alamat lengkap lokasi acara..."
                    class="textarea textarea-bordered w-full"></textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-semibold">Catatan <span
                        class="font-normal opacity-40">(opsional)</span></label>
                <textarea wire:model="catatan" rows="2" placeholder="Permintaan khusus, alergi makanan, dll..."
                    class="textarea textarea-bordered w-full"></textarea>
            </div>
        </div>

        {{-- Add-on Gubukan --}}
        <div class="rounded-2xl bg-base-100 shadow p-5 space-y-3">
            <div>
                <p class="font-bold text-sm">Add-on Gubukan <span class="font-normal opacity-40">(opsional)</span></p>
                <p class="text-xs opacity-40 mt-0.5">Dihitung per porsi sesuai jumlah tamu.</p>
            </div>
            @foreach ([['value' => 'bakso', 'label' => 'Bakso', 'harga' => 5000, 'icon' => '🍜', 'desc' => 'Stand bakso lengkap'], ['value' => 'dimsum', 'label' => 'Dimsum', 'harga' => 6000, 'icon' => '🥟', 'desc' => 'Stand dimsum uap & goreng'], ['value' => 'eskrim', 'label' => 'Es Krim', 'harga' => 4500, 'icon' => '🍦', 'desc' => 'Stand es krim aneka rasa']] as $addon)
                <label
                    class="flex items-center gap-3 cursor-pointer rounded-xl border border-base-200 px-4 py-3 hover:bg-base-50 transition {{ in_array($addon['value'], $gubukan) ? 'border-violet-400 bg-violet-50' : '' }}">
                    <input type="checkbox" wire:model.live="gubukan" value="{{ $addon['value'] }}"
                        class="checkbox checkbox-sm">
                    <span class="text-xl">{{ $addon['icon'] }}</span>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ $addon['label'] }}</p>
                        <p class="text-xs opacity-50">{{ $addon['desc'] }}</p>
                    </div>
                    <span class="text-sm font-bold" style="color:#534AB7">
                        + Rp {{ number_format($addon['harga'], 0, ',', '.') }} / porsi
                    </span>
                </label>
            @endforeach
        </div>

        {{-- Ringkasan Harga --}}
        <div class="rounded-2xl bg-base-100 shadow p-5 space-y-2 text-sm">
            <p class="font-bold text-sm mb-3">Ringkasan Harga</p>
            <div class="flex justify-between">
                <span class="opacity-60">Harga paket ({{ number_format($jumlah_porsi, 0, ',', '.') }} porsi)</span>
                <span class="font-semibold">Rp {{ number_format($hargaPaket, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="opacity-60">Add-on gubukan</span>
                <span class="font-semibold">Rp {{ number_format($hargaAddon, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between opacity-40 text-xs">
                <span>Biaya pengiriman</span>
                <span>Belum termasuk</span>
            </div>
            <div class="border-t border-base-200 pt-3 flex justify-between font-bold text-base">
                <span>Estimasi Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <button wire:click="submitOrder" wire:loading.attr="disabled"
            class="btn w-full bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-2xl">
            <span wire:loading.remove wire:target="submitOrder">Lanjut ke Pembayaran →</span>
            <span wire:loading wire:target="submitOrder">Memproses...</span>
        </button>
        <a href="{{ route('menu.prasmanan') }}" class="btn btn-outline w-full rounded-2xl">
            ← Kembali ke Menu
        </a>

        {{-- STEP: PAYMENT --}}
    @elseif ($step === 'payment')
        {{-- Ringkasan --}}
        <div class="rounded-2xl bg-base-100 shadow p-5 space-y-2 text-sm">
            <p class="font-bold text-sm mb-3">Ringkasan Pesanan</p>
            <div class="flex justify-between"><span class="opacity-60">Paket</span><span
                    class="font-semibold">{{ $nama_paket }}</span></div>
            <div class="flex justify-between"><span class="opacity-60">Nama
                    Acara</span><span>{{ $nama_acara }}</span></div>
            <div class="flex justify-between"><span
                    class="opacity-60">Tanggal</span><span>{{ \Carbon\Carbon::parse($tanggal_acara)->translatedFormat('d F Y') }}</span>
            </div>
            <div class="flex justify-between"><span class="opacity-60">Jumlah
                    Porsi</span><span>{{ number_format($jumlah_porsi, 0, ',', '.') }} porsi</span></div>
            @if (!empty($gubukan))
                <div class="flex justify-between"><span
                        class="opacity-60">Gubukan</span><span>{{ implode(', ', array_map('ucfirst', $gubukan)) }}</span>
                </div>
            @endif
            <div class="border-t border-base-200 pt-3 flex justify-between font-bold text-base">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <p class="text-xs opacity-40">* Belum termasuk biaya pengiriman</p>
        </div>

        {{-- Metode Pembayaran --}}
        <div class="rounded-2xl bg-base-100 shadow p-5 space-y-3">
            <p class="font-bold text-sm">Pilih Metode Pembayaran</p>

            <label
                class="flex items-center gap-4 cursor-pointer rounded-xl border px-4 py-4 transition {{ $metode === 'transfer' ? 'border-blue-400 bg-blue-50' : 'border-base-200' }}">
                <input type="radio" wire:model.live="metode" value="transfer" class="radio radio-sm">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-sm">Transfer Bank</p>
                    <p class="text-xs opacity-50">BCA / Mandiri / BNI</p>
                </div>
            </label>

            @if ($metode === 'transfer')
                <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 space-y-2 text-sm">
                    <p class="font-semibold text-blue-800 mb-2">Informasi Rekening</p>
                    @foreach ([['bank' => 'BCA', 'no' => '1234567890', 'nama' => 'Mama Alif'], ['bank' => 'Mandiri', 'no' => '0987654321', 'nama' => 'Mama Alif'], ['bank' => 'BNI', 'no' => '1122334455', 'nama' => 'Mama Alif']] as $rek)
                        <div
                            class="flex items-center justify-between bg-white rounded-lg px-3 py-2 border border-blue-100">
                            <div>
                                <p class="font-bold text-blue-900 text-xs">{{ $rek['bank'] }}</p>
                                <p class="text-blue-700 font-mono tracking-wide">{{ $rek['no'] }}</p>
                                <p class="text-xs text-blue-500">a.n {{ $rek['nama'] }}</p>
                            </div>
                            <button type="button"
                                onclick="navigator.clipboard.writeText('{{ $rek['no'] }}').then(()=>alert('Disalin!'))"
                                class="btn btn-xs border-blue-300 text-blue-600">Salin</button>
                        </div>
                    @endforeach
                    <p class="text-xs text-blue-600 opacity-70 mt-2">Setelah transfer, konfirmasi via WhatsApp dengan
                        bukti transfer.</p>
                </div>
            @endif

            <label
                class="flex items-center gap-4 cursor-pointer rounded-xl border px-4 py-4 transition {{ $metode === 'qris' ? 'border-purple-400 bg-purple-50' : 'border-base-200' }}">
                <input type="radio" wire:model.live="metode" value="qris" class="radio radio-sm">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-sm">QRIS</p>
                    <p class="text-xs opacity-50">GoPay, OVO, Dana, ShopeePay, m-banking</p>
                </div>
            </label>

            @if ($metode === 'qris')
                <div class="rounded-xl bg-purple-50 border border-purple-200 p-4 space-y-3 text-sm">
                    <p class="font-semibold text-purple-800">Scan QRIS</p>
                    <div class="flex flex-col items-center gap-2">
                        {{-- Ganti dengan <img src="{{ asset('brand/qris.png') }}"> jika punya file QRIS --}}
                        <div
                            class="w-48 h-48 bg-white border-2 border-purple-200 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-300 mx-auto"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                <p class="text-xs text-purple-400 mt-1">Mama Alif Catering</p>
                            </div>
                        </div>
                        <p class="text-xs text-purple-600 text-center opacity-70">Scan menggunakan aplikasi apapun yang
                            mendukung QRIS.</p>
                    </div>
                    <p class="text-xs text-purple-600 opacity-70">Setelah bayar, konfirmasi via WhatsApp dengan
                        screenshot bukti bayar.</p>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <a href="https://wa.me/6285719595219?text={{ urlencode('Halo, saya sudah melakukan pembayaran. Nama acara: ' . $nama_acara . ', Paket: ' . $nama_paket . ', Total: Rp ' . number_format($total, 0, ',', '.') . '. Mohon konfirmasi pesanan saya.') }}"
            target="_blank" class="btn w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white border-none rounded-2xl">
            Konfirmasi via WhatsApp
        </a>
        <button wire:click="confirmPayment"
            class="btn w-full bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-2xl">
            Saya Sudah Bayar
        </button>

        {{-- STEP: SUCCESS --}}
    @elseif ($step === 'success')
        <div class="rounded-2xl bg-base-100 shadow p-8 text-center space-y-4">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Pesanan Diterima!</h2>
                <p class="text-sm opacity-60 mt-1">Kami akan segera memproses pesanan Anda dan menghubungi via WhatsApp
                    untuk konfirmasi.</p>
            </div>
            <div class="bg-base-200 rounded-xl p-4 text-sm space-y-1 text-left">
                <div class="flex justify-between"><span class="opacity-60">Paket</span><span
                        class="font-semibold">{{ $nama_paket }}</span></div>
                <div class="flex justify-between"><span class="opacity-60">Total</span><span class="font-bold">Rp
                        {{ number_format($total, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="opacity-60">Status</span><span
                        class="badge badge-warning badge-sm">Menunggu Konfirmasi</span></div>
            </div>
            <a href="{{ route('customer.dashboard') }}"
                class="btn w-full bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-2xl">
                Kembali ke Dashboard
            </a>
        </div>

    @endif

</div>
