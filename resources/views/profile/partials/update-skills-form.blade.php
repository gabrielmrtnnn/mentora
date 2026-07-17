<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Keahlian Mengajar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Pilih materi yang dapat kamu ajarkan kepada student.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-skills') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-4">
            <label class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" name="tps" value="1" 
                       class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
                       {{ auth()->user()->tutor?->tps ? 'checked' : '' }}>
                <div>
                    <h3 class="font-medium text-gray-900">
                        🧠 TPS
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ __('Tes Potensi Skolastik') }}
                    </p>
                </div>
            </label>

            <label class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" name="literasi" value="1" 
                       class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
                       {{ auth()->user()->tutor?->literasi ? 'checked' : '' }}>
                <div>
                    <h3 class="font-medium text-gray-900">
                        📖 Literasi
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ __('Membaca dan memahami bacaan') }}
                    </p>
                </div>
            </label>

            <label class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" name="numerasi" value="1" 
                       class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
                       {{ auth()->user()->tutor?->numerasi ? 'checked' : '' }}>
                <div>
                    <h3 class="font-medium text-gray-900">
                        🔢 Numerasi
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ __('Matematika dan penalaran kuantitatif') }}
                    </p>
                </div>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'skills-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>