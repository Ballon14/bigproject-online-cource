<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-200/50">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        {{-- Top Bar: Breadcrumb & Quick Info --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-gray-100">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs md:text-sm" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-1.5 text-gray-500 hover:text-indigo-600 transition-all duration-200 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Home</span>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-300" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-800 font-semibold flex items-center gap-1.5">
                    @php
                        $routeName = request()->route()->getName();
                        $pageNames = [
                            'dashboard' => 'Dashboard',
                            'input-data' => 'Input Data',
                            'all-data' => 'Data Courses',
                            'all-data.edit' => 'Edit Courses',
                            'perhitungan' => 'Perhitungan SAW',
                            'result' => 'Result',
                            'user.detail' => 'User Detail',
                            'user.edit' => 'Edit Profile',
                        ];
                        $currentPage = $pageNames[$routeName] ?? ucfirst(str_replace(['-', '.'], ' ', $routeName));
                    @endphp
                    <span class="inline-flex items-center justify-center w-1.5 h-1.5 rounded-full bg-indigo-600 shadow-sm"></span>
                    {{ $currentPage }}
                </span>
            </nav>

            {{-- Right Side: Date & Time (Real-time with GMT+7) --}}
            <div class="flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-indigo-100 shadow-sm">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span id="currentDate" class="text-sm font-semibold text-gray-700">
                        {{ now()->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}
                    </span>
                </div>
                <div class="h-4 w-px bg-indigo-200"></div>
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span id="currentTime" class="text-sm font-semibold text-gray-700 tabular-nums">
                        {{ now()->timezone('Asia/Jakarta')->format('H:i:s') }}
                    </span>
                    <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">WIB</span>
                </div>
            </div>
        </div>

        {{-- Main Header: Title Section --}}
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                {{-- Animated Indicator Dot --}}
                <div class="relative flex-shrink-0">
                    <div class="absolute inset-0 rounded-full bg-indigo-400 animate-ping opacity-75"></div>
                    <div class="relative h-3 w-3 rounded-full bg-gradient-to-br from-indigo-600 to-blue-600 shadow-lg">
                    </div>
                </div>

                {{-- Title --}}
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        @if ($slot && $slot != '')
                            {{ $slot }}
                        @else
                            @php
                                $routeName = request()->route()->getName();
                                $pageNames = [
                                    'dashboard' => 'Dashboard',
                                    'input-data' => 'Input Course Data',
                                    'all-data' => 'Data Courses',
                                    'all-data.edit' => 'Edit Courses',
                                    'perhitungan' => 'SAW Calculation',
                                    'result' => 'Ranking Results',
                                    'user.detail' => 'User Detail',
                                    'user.edit' => 'Edit Profile',
                                ];
                                echo $pageNames[$routeName] ?? 'SPK Online Courses';
                            @endphp
                        @endif
                    </h1>
                </div>
            </div>

            {{-- Quick Stats Badge --}}
            <div class="hidden lg:flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-xs font-semibold text-gray-600">System Active</span>
            </div>
        </div>
    </div>

    {{-- Decorative Bottom Border --}}
    <div class="h-1 bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-600 opacity-20"></div>
</header>

{{-- JavaScript for Real-time Clock (GMT+7) --}}
<script>
    function updateClock() {
        const now = new Date();

        // Format date (GMT+7)
        const options = {
            timeZone: 'Asia/Jakarta',
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };
        const dateStr = now.toLocaleDateString('id-ID', options);

        // Format time (GMT+7) with seconds
        const timeOptions = {
            timeZone: 'Asia/Jakarta',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        const timeStr = now.toLocaleTimeString('id-ID', timeOptions);

        // Update DOM elements
        const dateElement = document.getElementById('currentDate');
        const timeElement = document.getElementById('currentTime');

        if (dateElement) dateElement.textContent = dateStr;
        if (timeElement) timeElement.textContent = timeStr;
    }

    // Update immediately on page load
    updateClock();

    // Update every second
    setInterval(updateClock, 1000);
</script>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    /* Smooth transitions for dropdown */
    .group:hover > div {
        pointer-events: auto;
    }

    /* Tabular numbers for consistent time display */
    .tabular-nums {
        font-variant-numeric: tabular-nums;
    }
</style>
