<div class="p-4 md:p-6 pt-0">
    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Total Kursus Card --}}
        <div class="bg-purple-500 text-white rounded-lg shadow p-6 flex flex-col justify-between">
            <div class="flex items-center mb-2">
                <span class="inline-block mr-3"><svg xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8 bg-white/20 rounded-full p-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5h6a2 2 0 012 2v2a2 2 0 002 2h6m-6 4h6a2 2 0 002 2v2a2 2 0 01-2 2h-6a2 2 0 01-2-2v-2a2 2 0 00-2-2H3">
                        </path>
                    </svg></span>
                <div>
                    <div class="font-bold text-lg leading-tight">Total Courses</div>
                    <div class="text-3xl font-extrabold">{{ $totalCourses }}</div>
                </div>
            </div>
            <div class="opacity-70 text-xs">Total number of active courses</div>
        </div>
        {{-- Rata-Rata Rating Card --}}
        <div class="bg-orange-400 text-white rounded-lg shadow p-6 flex flex-col justify-between">
            <div class="flex items-center mb-2">
                <span class="inline-block mr-3"><svg xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8 bg-white/20 rounded-full p-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                    </svg></span>
                <div>
                    <div class="font-bold text-lg leading-tight">Average Rating</div>
                    <div class="text-3xl font-extrabold">{{ number_format($courses->avg('rating'), 2) }}</div>
                </div>
            </div>
            <div class="opacity-70 text-xs">All courses totaled & divided by number of courses</div>
        </div>
    </div>
    {{-- Statistik Box Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs font-bold text-gray-700 uppercase mb-1">Cost</div>
            <div class="text-sm text-gray-600">Minimum:
                <b>Rp{{ number_format($stat['biaya_min'], 0, ',', '.') }}K</b>
            </div>
            <div class="text-sm text-gray-600">Maximum:
                <b>Rp{{ number_format($stat['biaya_max'], 0, ',', '.') }}K</b>
            </div>
            <div class="text-sm text-gray-600">Average:
                <b>Rp{{ number_format($stat['biaya_avg'], 1, ',', '.') }}K</b>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs font-bold text-gray-700 uppercase mb-1">Rating</div>
            <div class="text-sm text-gray-600">Minimum: <b>{{ $stat['rating_min'] }}</b></div>
            <div class="text-sm text-gray-600">Maximum: <b>{{ $stat['rating_max'] }}</b></div>
            <div class="text-sm text-gray-600">Average: <b>{{ $stat['rating_avg'] }}</b></div>
            <div class="text-sm text-gray-600 mt-2">Popular courses (>=4.5): <b>{{ $stat['kursus_populer'] }}</b>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs font-bold text-gray-700 uppercase mb-1">Duration</div>
            <div class="text-sm text-gray-600">Total: <b>{{ $stat['durasi_total'] }} hrs</b></div>
            <div class="text-sm text-gray-600">Average: <b>{{ $stat['durasi_avg'] }} hrs</b></div>
        </div>
    </div>
    {{-- Chart Area + Summary Box Proper --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-4 col-span-1 md:col-span-2 flex flex-col justify-between">
            <div class="mb-3">
                <h3 class="text-lg font-bold text-blue-700 uppercase tracking-wide mb-1">Course Cost Chart</h3>
                <div class="text-sm text-gray-500 mb-2">Comparison of various course costs (in thousands of rupiah)
                </div>
            </div>
            <div class="relative w-full" style="min-height: 300px; max-height: 500px;">
                <canvas id="biayaChart" class="w-full" style="max-height: 100%;"></canvas>
            </div>
        </div>
        <div
            class="bg-blue-600 text-white rounded-lg shadow p-4 w-full md:w-full flex flex-col justify-between min-h-[200px]">
            <div class="text-2xl font-bold mb-4">Popular Courses Info</div>
            <ul class="space-y-2 text-base">
                @foreach ($courses->sortByDesc('rating')->take(12) as $c)
                    <li class="flex justify-between border-b border-white/20 pb-1">
                        <span>{{ $c->nama_kursus }}</span><span class="font-semibold">{{ $c->rating }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    {{-- Tabel Modern Responsif --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Course List</h3>
            <p class="text-sm text-gray-500 mt-1">All courses available in the system</p>
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Course Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Cost</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Rating</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Duration</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Flexibility</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Certificate</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Last Update</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($courses as $i => $c)
                        <tr
                            class="hover:bg-indigo-50 transition-colors duration-150 {{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-700">{{ $i + 1 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $c->nama_kursus }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-700">Rp
                                    {{ number_format($c->biaya, 0, ',', '.') }}K</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ $c->rating }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $c->durasi }} hrs</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[60px]">
                                        <div class="bg-green-500 h-2 rounded-full"
                                            style="width: {{ ($c->fleksibilitas / 5) * 100 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">{{ $c->fleksibilitas }}/5</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $c->sertifikat >= 4 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $c->sertifikat }}/5
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                    {{ $c->update_terakhir }}/5
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="lg:hidden divide-y divide-gray-200">
            @foreach ($courses as $i => $c)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2 py-1 rounded">#{{ $i + 1 }}</span>
                                <h4 class="text-base font-bold text-gray-900">{{ $c->nama_kursus }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-500 block mb-1">Cost</span>
                            <span class="font-semibold text-gray-900">Rp
                                {{ number_format($c->biaya, 0, ',', '.') }}K</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Rating</span>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ $c->rating }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Duration</span>
                            <span class="font-semibold text-gray-900">{{ $c->durasi }} hrs</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Flexibility</span>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[60px]">
                                    <div class="bg-green-500 h-2 rounded-full"
                                        style="width: {{ ($c->fleksibilitas / 5) * 100 }}%"></div>
                                </div>
                                <span class="text-xs text-gray-600">{{ $c->fleksibilitas }}/5</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Certificate</span>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $c->sertifikat >= 4 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $c->sertifikat }}/5
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Last Update</span>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                {{ $c->update_terakhir }}/5
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Chart.js CDN dan Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('biayaChart');
        if (!ctx) return;
        
        const biayaData = @json($courses->pluck('biaya'));
        const labelData = @json($courses->pluck('nama_kursus'));
        if (window.chartJsInstance) window.chartJsInstance.destroy();
        window.chartJsInstance = new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelData,
                datasets: [{
                    label: 'Biaya Kursus (ribu rupiah)',
                    data: biayaData,
                    backgroundColor: 'rgba(59, 130, 246, 0.75)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    maxBarThickness: 48
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: window.innerWidth < 768 ? 1.5 : 2,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return 'Rp ' + ctx.raw + 'K';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cost (thousand Rupiah)',
                            color: '#555',
                            font: {
                                size: window.innerWidth < 768 ? 12 : 14,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: '#eee'
                        },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Course Name',
                            color: '#555',
                            font: {
                                size: window.innerWidth < 768 ? 12 : 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            maxRotation: window.innerWidth < 768 ? 45 : 60,
                            minRotation: window.innerWidth < 768 ? 45 : 30,
                            font: {
                                size: window.innerWidth < 768 ? 9 : 11
                            }
                        },
                        grid: {
                            color: '#fafafa'
                        }
                    }
                }
            }
        });
    });
</script>

