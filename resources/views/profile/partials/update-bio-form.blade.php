<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Tentang Saya') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Tuliskan deskripsi singkat tentang dirimu agar student lebih mengenalmu.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-bio') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <textarea
                name="bio"
                rows="6"
                class="block p-4 w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                placeholder="Contoh: Saya merupakan mahasiswa Informatika yang memiliki minat mengajar TPS dan Numerasi..."
            >{{ old('bio', auth()->user()->tutor?->bio) }}</textarea>

            @error('bio')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'bio-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>