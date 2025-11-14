<div class="flex h-screen overflow-hidden">
    <div x-data="{
        open: window.innerWidth >= 768,
        isDesktop: window.innerWidth >= 768,
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
        }
    }" class="relative">

        <!-- Mobile Header -->
        <div
            class="md:hidden fixed top-0 left-0 right-0 z-50 flex justify-between items-center p-4 border-b border-gray-200 bg-white shadow-sm">
            <div class="text-lg font-bold text-gray-800">SPK Sistem</div>
            <button @click="toggle()" aria-controls="sidebar-drawer" :aria-expanded="open.toString()"
                class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"
                aria-label="Toggle sidebar navigation">
                <svg x-show="!open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
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
            class="fixed md:static inset-y-0 left-0 w-72 bg-white border-r border-gray-200 flex flex-col z-50 transform transition-transform duration-300 ease-in-out shadow-lg md:shadow-none"
            :class="{
                'translate-x-0': open || isDesktop,
                '-translate-x-full': !open && !isDesktop
            }"
            x-cloak @keydown.escape.window="close()" role="navigation" aria-label="Main navigation">

            <!-- Logo Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div
                            class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center group-hover:bg-indigo-700 transition-colors">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 12C5 8.68629 7.68629 6 11 6C14.3137 6 17 8.68629 17 12C17 15.3137 14.3137 18 11 18"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M19 12C19 15.3137 16.3137 18 13 18C9.68629 18 7 15.3137 7 12"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </div>
                        <span
                            class="hidden md:block text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">SPK Sistem</span>
                    </a>
                    <!-- Close button for mobile -->
                    <button @click="close()"
                        class="md:hidden p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"
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
                        'label' => 'Perhitungan',
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
                <div class="mt-auto border-t border-gray-200 p-4 bg-gray-50">
                    @php
                        $user = Auth::user();
                        $displayName = $user?->username ?? 'User';
                        $displayEmail = $user?->email ?? '@' . ($user?->username ?? 'user');
                    @endphp
                    <a href="{{ route('user.detail') }}" @click="close()"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white transition-colors mb-3 group">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=4F46E5&color=fff"
                            alt="{{ $displayName }}"
                            class="w-10 h-10 rounded-full ring-2 ring-white group-hover:ring-indigo-200 transition-all">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-700 truncate group-hover:text-indigo-600 transition-colors">
                                {{ $displayName }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $displayEmail }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm hover:shadow-md">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>
</div>
