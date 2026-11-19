<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Beri Rating</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-base-100 shadow p-6 space-y-5">

                {{-- Info order --}}
                <div class="rounded-xl bg-base-200 px-4 py-3 space-y-1">
                    <p class="font-bold text-sm">{{ $order->order_number }}</p>
                    <p class="text-xs opacity-50">{{ $order->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <form method="POST" action="{{ route('order.rating.store', $order) }}" class="space-y-5">
                    @csrf

                    {{-- Bintang --}}
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Rating</label>
                        <div class="flex gap-2" id="star-container">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})"
                                    class="star-btn text-4xl text-gray-300 hover:text-amber-400 transition"
                                    data-value="{{ $i }}">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                        <p class="text-xs text-red-500 hidden" id="rating-error">Pilih rating terlebih dahulu.</p>
                    </div>

                    {{-- Ulasan --}}
                    <div class="space-y-1">
                        <label class="text-sm font-semibold">
                            Ulasan
                            <span class="font-normal opacity-40">(opsional)</span>
                        </label>
                        <textarea name="review" rows="4" placeholder="Ceritakan pengalaman Anda memesan di Mama Alif Catering..."
                            class="textarea textarea-bordered w-full">{{ old('review') }}</textarea>
                        @error('review')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <button type="submit" id="submit-rating"
                            class="btn w-full bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-2xl">
                            Kirim Rating
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline w-full rounded-2xl">
                            ← Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let selectedRating = 0;

        function setRating(value) {
            selectedRating = value;
            document.getElementById('rating-input').value = value;
            document.getElementById('rating-error').classList.add('hidden');
            document.querySelectorAll('.star-btn').forEach(btn => {
                btn.classList.toggle('text-amber-400', parseInt(btn.dataset.value) <= value);
                btn.classList.toggle('text-gray-300', parseInt(btn.dataset.value) > value);
            });
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            if (!selectedRating) {
                e.preventDefault();
                document.getElementById('rating-error').classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
