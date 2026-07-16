<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">

    @foreach($studyGroups as $group)

        <div
            class="relative group bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[32px] p-6 shadow-lg hover:shadow-blue-200/50 transition-all duration-300 text-white overflow-hidden flex flex-col h-full">

            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all"></div>

            <div class="flex justify-between items-start mb-6 relative z-10">

                <div class="flex flex-col gap-2">

                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase rounded-lg tracking-wider w-fit border border-white/20">

                        {{ $group->subject }}

                    </span>

                </div>

                @if(Auth::user()->role === 'admin' || Auth::id() === $group->created_by)

                    <form
                        action="{{ route('study.group.destroy', $group->id) }}"
                        method="POST"
                        class="m-0">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            onclick="return confirm('{{ __('Yakin ingin menghapus room ini?') }}')"
                            class="p-2.5 bg-white/10 text-white/80 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200 border border-white/10 backdrop-blur-sm">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>

                            </svg>

                        </button>

                    </form>

                @endif

            </div>

            <div class="relative z-10 flex-grow">

                <h4 class="text-2xl font-extrabold text-white mb-2 leading-tight break-words">

                    {{ $group->name }}

                </h4>

                <p class="text-sm text-blue-50/80 mb-8 line-clamp-2 leading-relaxed">

                    {{ __('Gabung untuk sesi belajar fokus bareng melalui video call Jitsi.') }}

                </p>

            </div>

            <div class="relative z-10 mt-auto">

                <a
                    href="https://meet.jit.si/{{ $group->slug }}#config.prejoinPageEnabled=false"
                    target="_blank"
                    class="block w-full py-3.5 rounded-2xl bg-white text-blue-600 text-center font-extrabold hover:bg-yellow-300 hover:text-gray-900 transition-all shadow-md active:scale-[0.98]">

                    {{ __('Gabung Grup') }}

                </a>

            </div>

        </div>

    @endforeach

</div>