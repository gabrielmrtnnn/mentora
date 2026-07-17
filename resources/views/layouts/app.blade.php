<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="app-locale" content="{{ app()->getLocale() }}">
        <title>Mentora</title>

        <script>
            // Dipakai widget JS (mis. timer study room) buat nerjemahin teks yang
            // di-generate/di-update lewat JS, bukan cuma render Blade pertama kali.
            // Sumbernya sama persis dengan lang/en.json biar gak dobel maintain.
            window.__LOCALE__ = @json(app()->getLocale());
            window.__I18N__ = @json(app()->getLocale() === 'en' ? json_decode(file_get_contents(lang_path('en.json')), true) : []);
            window.trans = function (text) {
                return (window.__I18N__ && window.__I18N__[text]) || text;
            };
        </script>

        <script src="https://meet.jit.si/external_api.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>

    <body class="bg-background min-h-screen">
        <div class="flex h-screen">

            @include('partials.sidebar')

            <div id="sidebarBackdrop"
                class="hidden fixed inset-0 bg-black/40 z-[65] lg:hidden"></div>

            <button id="sidebarOpenBtn"
                type="button"
                aria-label="{{ __('Buka menu') }}"
                class="lg:hidden fixed top-4 left-4 z-[75] p-2.5 bg-white rounded-xl shadow-md text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>

            <div id="mainContent"
                class="flex-1 flex flex-col h-full ml-0 lg:ml-20 transition-all duration-300">
                <main class="flex-1 flex flex-col min-h-0 px-6 md:px-10 pb-6 md:pb-10 pt-20 lg:pt-10">
                    @yield('content')
                </main>
            </div>

        </div>


        <div id="focusOverlayRoot"></div>
        @if(request()->routeIs('study-room*'))
            @include('study-room.solo.focus-overlay')
        @endif

        <script>
        document.addEventListener('DOMContentLoaded', () => {

            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');
            const banner = document.getElementById('topBanner');
            const backdrop = document.getElementById('sidebarBackdrop');
            const openBtn = document.getElementById('sidebarOpenBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            const texts = document.querySelectorAll('.sidebar-text');
            const profileTexts = document.querySelectorAll('.profile-text');

            const wrapper = document.getElementById('profileWrapper');
            const button = document.getElementById('profileButton');
            const dropdown = document.getElementById('dropdownMenu');

            if (wrapper && button && dropdown) {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                wrapper.addEventListener('mouseleave', () => {
                    dropdown.classList.add('hidden');
                });
            }

            function expandSidebar() {

                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');

                main.classList.remove('lg:ml-20');
                main.classList.add('lg:ml-64');

                if(banner){
                    banner.classList.remove('lg:ml-20');
                    banner.classList.add('lg:ml-64');
                }

                texts.forEach(el => {
                    el.classList.remove('opacity-0', 'max-w-0');
                    el.classList.add('max-w-[200px]');
                });
                profileTexts.forEach(el => {
                    el.classList.remove('opacity-0', 'max-w-0');
                    el.classList.add('max-w-[200px]');
                });
            }

            function collapseSidebar() {

                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');

                main.classList.remove('lg:ml-64');
                main.classList.add('lg:ml-20');

                if(banner){
                    banner.classList.remove('lg:ml-64');
                    banner.classList.add('lg:ml-20');
                }

                texts.forEach(el => {
                    el.classList.add('opacity-0', 'max-w-0');
                    el.classList.remove('max-w-[200px]');
                });
                profileTexts.forEach(el => {
                    el.classList.add('opacity-0', 'max-w-0');
                    el.classList.remove('max-w-[200px]');
                });
            }

            sidebar.addEventListener('mouseenter', expandSidebar);

            sidebar.addEventListener('mouseleave', collapseSidebar);

            // --- MOBILE DRAWER ---
            function openMobileSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                expandSidebar();

                if (backdrop) {
                    backdrop.classList.remove('hidden');
                }
                document.body.classList.add('overflow-hidden');
            }

            function closeMobileSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                collapseSidebar();

                if (backdrop) {
                    backdrop.classList.add('hidden');
                }
                document.body.classList.remove('overflow-hidden');
            }

            if (openBtn) openBtn.addEventListener('click', openMobileSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeMobileSidebar);
            if (backdrop) backdrop.addEventListener('click', closeMobileSidebar);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeMobileSidebar();
            });

        });
        </script>

        @auth
            @if (!request()->routeIs('chat.*'))
                <div class="fixed bottom-6 right-6 z-50">
                    <a href="{{ route('chat.index') }}"
                       class="relative w-16 h-16 rounded-full bg-primary text-white shadow-xl
                              hover:scale-110 transition flex items-center justify-center">
                        <img src="{{ asset('icons/chat.svg') }}"
                             class="w-8 h-8"
                             alt="Chat">
                             
                        <div id="globalUnreadBadge" 
                             class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[11px] font-bold min-w-[24px] h-6 px-1 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                            0
                        </div>
                    </a>
                </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const globalBadge = document.getElementById('globalUnreadBadge');
                    if (!globalBadge) return;

                    async function checkGlobalUnread() {
                        try {
                            const response = await fetch("{{ route('chat.sidebar') }}", {
                                headers: { "Accept": "application/json" }
                            });

                            if (!response.ok) return;

                            const data = await response.json();
                            
                            // Menjumlahkan semua atribut 'unread' dari JSON response
                            const totalUnread = data.reduce((sum, chat) => sum + chat.unread, 0);

                            if (totalUnread > 0) {
                                // Tampilkan badge (maksimal tampil '99+')
                                globalBadge.innerText = totalUnread > 99 ? '99+' : totalUnread;
                                globalBadge.classList.remove('hidden');
                            } else {
                                // Sembunyikan badge jika 0
                                globalBadge.classList.add('hidden');
                            }
                        } catch (error) {
                            console.error("Gagal mengambil data unread global:", error);
                        }
                    }

                    // Jalankan pertama kali saat halaman dimuat
                    checkGlobalUnread();
                    
                    // Polling setiap 3 detik
                    setInterval(checkGlobalUnread, 3000); 
                });
            </script>
            @endif
        @endauth

        @stack('scripts')
    </body>
</html>