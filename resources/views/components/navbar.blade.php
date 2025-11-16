<div class="flex h-screen overflow-hidden">
    <div x-data="{
        open: window.innerWidth >= 768,
        isDesktop: window.innerWidth >= 768,
        showLogoutModal: false,
        init() {
            this.isDesktop = window.innerWidth >= 768;
            this.open = this.isDesktop;
            window.addEventListener('resize', () => {
                this.isDesktop = window.innerWidth >= 768;
                if (this.isDesktop) {
                    this.open = true;
                } else {
                    this.open = false;
                }
            });
        },
        toggle() {
            this.open = !this.open;
        },
        close() {
            if (!this.isDesktop) {
                this.open = false;
            }
        },
        openLogoutModal() {
            window.dispatchEvent(new CustomEvent('open-logout-modal', { detail: { formId: 'logout-form' } }));
        }
    }" class="relative">

        <!-- Mobile Header -->
        <div
            class="md:hidden fixed top-0 left-0 right-0 z-[60] flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-white shadow-md backdrop-blur-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12C5 8.68629 7.68629 6 11 6C14.3137 6 17 8.68629 17 12C17 15.3137 14.3137 18 11 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path d="M19 12C19 15.3137 16.3137 18 13 18C9.68629 18 7 15.3137 7 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-800">SPK Sistem</span>
            </div>
            <button @click="toggle()" aria-controls="sidebar-drawer" :aria-expanded="open.toString()"
                class="p-2 rounded-lg hover:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                aria-label="Toggle sidebar navigation">
                <svg x-show="!open" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Overlay untuk mobile -->
        <div x-show="open" x-cloak x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="close()"
            class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-40">
        </div>

        <!-- Sidebar -->
        <aside id="sidebar-drawer"
            class="fixed inset-y-0 left-0 w-72 bg-white border-r border-gray-200 flex flex-col z-50 transform transition-transform duration-300 ease-in-out shadow-lg"
            :class="{
                'translate-x-0': open || isDesktop,
                '-translate-x-full': !open && !isDesktop
            }"
            x-cloak @keydown.escape.window="close()" role="navigation" aria-label="Main navigation">

            <!-- Logo Header -->
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-white">
                <div class="flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div
                            class="w-11 h-11 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl flex items-center justify-center group-hover:from-indigo-700 group-hover:to-indigo-800 transition-all shadow-md group-hover:shadow-lg">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 12C5 8.68629 7.68629 6 11 6C14.3137 6 17 8.68629 17 12C17 15.3137 14.3137 18 11 18"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M19 12C19 15.3137 16.3137 18 13 18C9.68629 18 7 15.3137 7 12"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="hidden md:block">
                            <span class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors block">SPK Sistem</span>
                            <span class="text-xs text-gray-500">Online Courses</span>
                        </div>
                    </a>
                    <!-- Close button for mobile -->
                    <button @click="close()"
                        class="md:hidden p-2 rounded-lg hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                        aria-label="Close sidebar">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            @php
                $mainNavigation = [
                    [
                        'label' => 'Dashboard',
                        'icon' => 'fas fa-home',
                        'route' => 'dashboard',
                        'badge' => '',
                        'badgeColor' => 'indigo',
                    ],
                    [
                        'label' => 'Input Data',
                        'icon' => 'fas fa-file-alt',
                        'route' => 'input-data',
                        'badge' => '',
                        'badgeColor' => 'indigo',
                    ],
                    [
                        'label' => 'Data Courses',
                        'icon' => 'fas fa-book',
                        'route' => 'all-data',
                        'badge' => '',
                        'badgeColor' => 'indigo',
                    ],
                    [
                        'label' => 'Calculation',
                        'icon' => 'fas fa-calculator',
                        'route' => 'perhitungan',
                        'badge' => '',
                        'badgeColor' => 'indigo',
                    ],
                    [
                        'label' => 'Result',
                        'icon' => 'fas fa-chart-line',
                        'route' => 'result',
                        'badge' => '',
                        'badgeColor' => 'indigo',
                    ],
                    [
                        'label' => 'User Detail',
                        'icon' => 'fas fa-id-card',
                        'route' => 'user.detail',
                    ],
                ];

            @endphp

            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1" aria-label="Primary navigation">
                    @foreach ($mainNavigation as $item)
                        @php
                            $href = isset($item['route']) ? route($item['route']) : $item['url'] ?? '#';
                            $isActive = isset($item['route'])
                                ? request()->routeIs($item['route'])
                                : $item['active'] ?? false;
                        @endphp
                        <x-nav-link :href="$href" :icon="$item['icon']" :badge="$item['badge'] ?? null" :badge-color="$item['badgeColor'] ?? 'gray'"
                            :active="$isActive" @click="close()">
                            {{ $item['label'] }}
                        </x-nav-link>
                    @endforeach
                </nav>

                <!-- User Profile -->
                <div class="mt-auto border-t border-gray-200 p-4 bg-gradient-to-t from-gray-50 to-white">
                    @php
                        $user = Auth::user();
                        $displayName = $user?->username ?? 'User';
                        $displayEmail = $user?->email ?? '@' . ($user?->username ?? 'user');
                    @endphp
                    <a href="{{ route('user.detail') }}" @click="close()"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white hover:shadow-sm transition-all mb-3 group border border-transparent hover:border-gray-200">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=4F46E5&color=fff"
                            alt="{{ $displayName }}"
                            class="w-10 h-10 rounded-full ring-2 ring-white group-hover:ring-indigo-300 transition-all shadow-sm">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-800 truncate group-hover:text-indigo-600 transition-colors">
                                {{ $displayName }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $displayEmail }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="button" @click="openLogoutModal()"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 rounded-xl hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all shadow-md hover:shadow-lg active:scale-[0.98]">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

    </div>
</div>
