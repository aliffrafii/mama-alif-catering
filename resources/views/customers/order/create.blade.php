<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Form Pemesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            @php
                $addonPricesView = ['bakso' => 5000, 'dimsum' => 6000, 'eskrim' => 4500];
                $categoryLabels = [1 => 'box', 2 => 'porsi', 3 => 'paket'];
                $categoryIcons = [1 => '🍱', 2 => '🍛', 3 => '🎋'];
            @endphp

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700 mb-4">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('order.store') }}" class="space-y-4">
                @csrf

                {{-- Ringkasan pesanan dari keranjang --}}
                <div class="rounded-2xl bg-base-100 shadow p-5 space-y-3">
                    <p class="font-bold text-sm">Pesanan Kamu</p>
                    @foreach ($items as $item)
                        @php
                            $sm = $item->selected_menus ?? [];
                            $unitP = $item->product->price;
                            if ($item->product->category_id == 2) {
                                foreach ($sm['gubukan'] ?? [] as $g) {
                                    $unitP += $addonPricesView[$g] ?? 0;
                                }
                            }
                            $satuan = $categoryLabels[$item->product->category_id] ?? 'item';
                            $icon = $categoryIcons[$item->product->category_id] ?? '🍽️';
                        @endphp
                        <div class="border border-base-200 rounded-xl p-3 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span>{{ $icon }}</span>
                                    <span class="font-semibold text-sm">{{ $item->product->name }}</span>
                                    <span class="opacity-50 text-xs">× {{ $item->quantity }} {{ $satuan }}</span>
                                </div>
                                <span class="font-bold text-sm">Rp
                                    {{ number_format($unitP * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                            @if (!empty($sm))
                                <div class="pl-6 space-y-0.5">
                                    @if (!empty($sm['menu_utama']))
                                        <p class="text-xs opacity-50">🍽️
                                            {{ ucwords(str_replace('_', ' ', $sm['menu_utama'])) }}</p>
                                    @endif
                                    @if (!empty($sm['isian']))
                                        <p class="text-xs opacity-50">🥘
                                            {{ collect($sm['isian'])->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ') }}
                                        </p>
                                    @endif
                                    @if (!empty($sm['gubukan']))
                                        <p class="text-xs opacity-50">🍜 Gubukan:
                                            {{ collect($sm['gubukan'])->map(fn($v) => ucwords($v))->implode(', ') }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="border-t border-base-200 pt-3 flex justify-between font-bold text-base">
                        <span>Estimasi Total</span>
                        <span id="estimasi_total">Rp
                            {{ number_format(
                                $items->sum(function ($i) use ($addonPricesView) {
                                    $u = $i->product->price;
                                    if ($i->product->category_id == 2) {
                                        foreach ($i->selected_menus['gubukan'] ?? [] as $g) {
                                            $u += $addonPricesView[$g] ?? 0;
                                        }
                                    }
                                    return $u * $i->quantity;
                                }),
                                0,
                                ',',
                                '.',
                            ) }}
                        </span>
                    </div>
                    <a href="{{ route('cart.index') }}" class="text-xs text-blue-500 hover:underline">← Edit
                        keranjang</a>
                </div>

                {{-- Detail Acara --}}
                <div class="rounded-2xl bg-base-100 shadow p-5 space-y-4">
                    <p class="font-bold text-sm">Detail Acara</p>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold">Nama Acara</label>
                        <input type="text" name="nama_acara" value="{{ old('nama_acara') }}"
                            placeholder="cth: Pernikahan Budi & Sari"
                            class="input input-bordered w-full @error('nama_acara') input-error @enderror" required>
                        @error('nama_acara')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                            class="input input-bordered w-full @error('phone') input-error @enderror" required>
                        @error('phone')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" value="{{ old('tanggal_acara') }}"
                            min="{{ now()->addDays(3)->format('Y-m-d') }}"
                            class="input input-bordered w-full @error('tanggal_acara') input-error @enderror" required>
                        <p class="text-xs opacity-40">Minimal 3 hari dari hari ini
                            ({{ now()->addDays(3)->translatedFormat('d F Y') }}).</p>
                        @error('tanggal_acara')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan_select"
                            class="select select-bordered w-full @error('kecamatan') select-error @enderror" required>
                            <option value="">-- Pilih Kecamatan --</option>

                            <optgroup label="🏙️ Jakarta Pusat">
                                <option value="Gambir|8" @selected(old('kecamatan') == 'Gambir|8')>Gambir</option>
                                <option value="Tanah Abang|9" @selected(old('kecamatan') == 'Tanah Abang|9')>Tanah Abang</option>
                                <option value="Menteng|10" @selected(old('kecamatan') == 'Menteng|10')>Menteng</option>
                                <option value="Senen|9" @selected(old('kecamatan') == 'Senen|9')>Senen</option>
                                <option value="Cempaka Putih|11" @selected(old('kecamatan') == 'Cempaka Putih|11')>Cempaka Putih</option>
                                <option value="Johar Baru|9" @selected(old('kecamatan') == 'Johar Baru|9')>Johar Baru</option>
                                <option value="Kemayoran|10" @selected(old('kecamatan') == 'Kemayoran|10')>Kemayoran</option>
                                <option value="Sawah Besar|9" @selected(old('kecamatan') == 'Sawah Besar|9')>Sawah Besar</option>
                            </optgroup>

                            <optgroup label="🏙️ Jakarta Utara">
                                <option value="Penjaringan|14" @selected(old('kecamatan') == 'Penjaringan|14')>Penjaringan</option>
                                <option value="Pademangan|12" @selected(old('kecamatan') == 'Pademangan|12')>Pademangan</option>
                                <option value="Tanjung Priok|11" @selected(old('kecamatan') == 'Tanjung Priok|11')>Tanjung Priok</option>
                                <option value="Koja|10" @selected(old('kecamatan') == 'Koja|10')>Koja</option>
                                <option value="Kelapa Gading|12" @selected(old('kecamatan') == 'Kelapa Gading|12')>Kelapa Gading</option>
                                <option value="Cilincing|8" @selected(old('kecamatan') == 'Cilincing|8')>Cilincing</option>
                            </optgroup>

                            <optgroup label="🏙️ Jakarta Barat">
                                <option value="Tambora|13" @selected(old('kecamatan') == 'Tambora|13')>Tambora</option>
                                <option value="Taman Sari|13" @selected(old('kecamatan') == 'Taman Sari|13')>Taman Sari</option>
                                <option value="Grogol Petamburan|15" @selected(old('kecamatan') == 'Grogol Petamburan|15')>Grogol Petamburan
                                </option>
                                <option value="Palmerah|14" @selected(old('kecamatan') == 'Palmerah|14')>Palmerah</option>
                                <option value="Kebon Jeruk|17" @selected(old('kecamatan') == 'Kebon Jeruk|17')>Kebon Jeruk</option>
                                <option value="Kembangan|19" @selected(old('kecamatan') == 'Kembangan|19')>Kembangan</option>
                                <option value="Cengkareng|16" @selected(old('kecamatan') == 'Cengkareng|16')>Cengkareng</option>
                                <option value="Kalideres|20" @selected(old('kecamatan') == 'Kalideres|20')>Kalideres</option>
                            </optgroup>

                            <optgroup label="🏙️ Jakarta Selatan">
                                <option value="Tebet|16" @selected(old('kecamatan') == 'Tebet|16')>Tebet</option>
                                <option value="Setiabudi|14" @selected(old('kecamatan') == 'Setiabudi|14')>Setiabudi</option>
                                <option value="Mampang Prapatan|16" @selected(old('kecamatan') == 'Mampang Prapatan|16')>Mampang Prapatan
                                </option>
                                <option value="Pancoran|15" @selected(old('kecamatan') == 'Pancoran|15')>Pancoran</option>
                                <option value="Kebayoran Baru|17" @selected(old('kecamatan') == 'Kebayoran Baru|17')>Kebayoran Baru</option>
                                <option value="Kebayoran Lama|19" @selected(old('kecamatan') == 'Kebayoran Lama|19')>Kebayoran Lama</option>
                                <option value="Pesanggrahan|21" @selected(old('kecamatan') == 'Pesanggrahan|21')>Pesanggrahan</option>
                                <option value="Cilandak|20" @selected(old('kecamatan') == 'Cilandak|20')>Cilandak</option>
                                <option value="Pasar Minggu|18" @selected(old('kecamatan') == 'Pasar Minggu|18')>Pasar Minggu</option>
                                <option value="Jagakarsa|21" @selected(old('kecamatan') == 'Jagakarsa|21')>Jagakarsa</option>
                            </optgroup>

                            <optgroup label="🏙️ Jakarta Timur">
                                <option value="Matraman|13" @selected(old('kecamatan') == 'Matraman|13')>Matraman</option>
                                <option value="Pulo Gadung|12" @selected(old('kecamatan') == 'Pulo Gadung|12')>Pulo Gadung</option>
                                <option value="Jatinegara|13" @selected(old('kecamatan') == 'Jatinegara|13')>Jatinegara</option>
                                <option value="Kramat Jati|14" @selected(old('kecamatan') == 'Kramat Jati|14')>Kramat Jati</option>
                                <option value="Pasar Rebo|17" @selected(old('kecamatan') == 'Pasar Rebo|17')>Pasar Rebo</option>
                                <option value="Ciracas|18" @selected(old('kecamatan') == 'Ciracas|18')>Ciracas</option>
                                <option value="Cipayung|19" @selected(old('kecamatan') == 'Cipayung|19')>Cipayung</option>
                                <option value="Makasar|15" @selected(old('kecamatan') == 'Makasar|15')>Makasar</option>
                                <option value="Duren Sawit|14" @selected(old('kecamatan') == 'Duren Sawit|14')>Duren Sawit</option>
                                <option value="Cakung|10" @selected(old('kecamatan') == 'Cakung|10')>Cakung</option>
                            </optgroup>

                            <optgroup label="🟦 Bekasi Kota">
                                <option value="Bekasi Utara|4" @selected(old('kecamatan') == 'Bekasi Utara|4')>Bekasi Utara</option>
                                <option value="Bekasi Selatan|6" @selected(old('kecamatan') == 'Bekasi Selatan|6')>Bekasi Selatan</option>
                                <option value="Bekasi Barat|5" @selected(old('kecamatan') == 'Bekasi Barat|5')>Bekasi Barat</option>
                                <option value="Bekasi Timur|5" @selected(old('kecamatan') == 'Bekasi Timur|5')>Bekasi Timur</option>
                                <option value="Medan Satria|5" @selected(old('kecamatan') == 'Medan Satria|5')>Medan Satria</option>
                                <option value="Bantargebang|8" @selected(old('kecamatan') == 'Bantargebang|8')>Bantargebang</option>
                                <option value="Mustika Jaya|9" @selected(old('kecamatan') == 'Mustika Jaya|9')>Mustika Jaya</option>
                                <option value="Pondok Gede|7" @selected(old('kecamatan') == 'Pondok Gede|7')>Pondok Gede</option>
                                <option value="Jatiasih|8" @selected(old('kecamatan') == 'Jatiasih|8')>Jatiasih</option>
                                <option value="Rawa Lumbu|6" @selected(old('kecamatan') == 'Rawa Lumbu|6')>Rawa Lumbu</option>
                                <option value="Jatisampurna|10" @selected(old('kecamatan') == 'Jatisampurna|10')>Jatisampurna</option>
                                <option value="Pondok Melati|9" @selected(old('kecamatan') == 'Pondok Melati|9')>Pondok Melati</option>
                            </optgroup>

                            <optgroup label="🟦 Bekasi Kabupaten">
                                <option value="Babelan|2" @selected(old('kecamatan') == 'Babelan|2')>Babelan (Gratis/Terdekat)
                                </option>
                                <option value="Tarumajaya|4" @selected(old('kecamatan') == 'Tarumajaya|4')>Tarumajaya</option>
                                <option value="Tambun Utara|6" @selected(old('kecamatan') == 'Tambun Utara|6')>Tambun Utara</option>
                                <option value="Tambun Selatan|7" @selected(old('kecamatan') == 'Tambun Selatan|7')>Tambun Selatan</option>
                                <option value="Cibitung|9" @selected(old('kecamatan') == 'Cibitung|9')>Cibitung</option>
                                <option value="Cikarang Utara|12" @selected(old('kecamatan') == 'Cikarang Utara|12')>Cikarang Utara</option>
                                <option value="Cikarang Barat|13" @selected(old('kecamatan') == 'Cikarang Barat|13')>Cikarang Barat</option>
                                <option value="Cikarang Selatan|15" @selected(old('kecamatan') == 'Cikarang Selatan|15')>Cikarang Selatan
                                </option>
                                <option value="Cikarang Timur|14" @selected(old('kecamatan') == 'Cikarang Timur|14')>Cikarang Timur</option>
                                <option value="Cikarang Pusat|13" @selected(old('kecamatan') == 'Cikarang Pusat|13')>Cikarang Pusat</option>
                                <option value="Karawang (perbatasan)|20" @selected(old('kecamatan') == 'Karawang (perbatasan)|20')>Karawang
                                    (perbatasan)</option>
                            </optgroup>
                        </select>
                        @error('kecamatan')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Info Ongkir --}}
                    <div id="ongkir_info" class="hidden">
                        <div class="rounded-xl overflow-hidden border border-blue-200">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-2 flex items-center gap-2">
                                <span class="text-white text-sm">🚚</span>
                                <span class="text-white text-sm font-semibold">Estimasi Ongkos Kirim</span>
                            </div>
                            <div class="bg-blue-50 px-4 py-3 space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-blue-700" id="ongkir_detail">-</span>
                                    <span class="text-lg font-bold text-blue-800" id="ongkir_nominal">Rp 0</span>
                                </div>
                                <p class="text-xs text-blue-400">📍 Dihitung dari Babelan, Bekasi · Rp 5.000/km</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">

                    {{-- Estimasi Total Live --}}
                    <div id="estimasi_total_box"
                        class="hidden rounded-xl bg-base-200 px-4 py-3 flex justify-between items-center">
                        <span class="text-sm font-semibold">Estimasi Total Bayar</span>
                        <span class="font-bold text-base text-primary" id="estimasi_total_live">Rp 0</span>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Tulis alamat lengkap lokasi acara (jalan, nomor, RT/RW)..."
                            class="textarea textarea-bordered w-full @error('alamat') textarea-error @enderror" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold">Catatan <span
                                class="font-normal opacity-40">(opsional)</span></label>
                        <textarea name="catatan" rows="2" placeholder="Permintaan khusus, alergi makanan, dll..."
                            class="textarea textarea-bordered w-full">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <div class="space-y-2">
                    <button type="submit"
                        class="btn w-full bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-2xl">
                        Konfirmasi Pesanan
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline w-full rounded-2xl">← Kembali ke
                        Keranjang</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const TARIF_PER_KM = 5000;
        const baseTotal =
            {{ $items->sum(function ($i) use ($addonPricesView) {
                $u = $i->product->price;
                if ($i->product->category_id == 2) {
                    foreach ($i->selected_menus['gubukan'] ?? [] as $g) {
                        $u += $addonPricesView[$g] ?? 0;
                    }
                }
                return $u * $i->quantity;
            }) }};

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('kecamatan_select');
            const ongkirInfo = document.getElementById('ongkir_info');
            const ongkirNominal = document.getElementById('ongkir_nominal');
            const ongkirDetail = document.getElementById('ongkir_detail');
            const shippingInput = document.getElementById('shipping_cost_input');
            const totalBox = document.getElementById('estimasi_total_box');
            const totalLive = document.getElementById('estimasi_total_live');
            const estimasiSpan = document.getElementById('estimasi_total');

            // Jika ada old value (setelah validasi gagal), trigger perubahan
            if (select.value) {
                select.dispatchEvent(new Event('change'));
            }

            select.addEventListener('change', function() {
                const val = this.value;

                if (!val) {
                    ongkirInfo.classList.add('hidden');
                    totalBox.classList.add('hidden');
                    shippingInput.value = 0;
                    if (estimasiSpan) estimasiSpan.textContent = 'Rp ' + baseTotal.toLocaleString('id-ID');
                    return;
                }

                const [nama, jarak] = val.split('|');
                const km = parseInt(jarak);
                const ongkir = km * TARIF_PER_KM;
                const total = baseTotal + ongkir;

                ongkirDetail.textContent = `${nama} · ${km} km dari Babelan`;
                ongkirNominal.textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
                shippingInput.value = ongkir;
                totalLive.textContent = 'Rp ' + total.toLocaleString('id-ID');

                if (estimasiSpan) estimasiSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');

                ongkirInfo.classList.remove('hidden');
                totalBox.classList.remove('hidden');
            });
        });
    </script>
</x-app-layout>
