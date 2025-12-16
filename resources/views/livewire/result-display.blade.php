<div class="p-4 md:p-6 pt-0">
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    @if ($calculation && count($results) > 0)
        {{-- Criteria Weights --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Criteria Weights Used
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="border border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-sm text-gray-600 mb-1">Cost</div>
                    <div class="text-2xl font-bold text-red-600">{{ number_format($bobot['biaya'] ?? 0, 2) }}%</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-sm text-gray-600 mb-1">Rating</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ number_format($bobot['rating'] ?? 0, 2) }}%</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-sm text-gray-600 mb-1">Duration</div>
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($bobot['durasi'] ?? 0, 2) }}%</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-sm text-gray-600 mb-1">Flexibility</div>
                    <div class="text-2xl font-bold text-green-600">{{ number_format($bobot['fleksibilitas'] ?? 0, 2) }}%</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-sm text-gray-600 mb-1">Certificate</div>
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($bobot['sertifikat'] ?? 0, 2) }}%</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-sm text-gray-600 mb-1">Last Update</div>
                    <div class="text-2xl font-bold text-orange-600">{{ number_format($bobot['update_terakhir'] ?? 0, 2) }}%</div>
                </div>
            </div>
        </div>

        {{-- Hasil Ranking --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                Course Ranking
            </h3>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                        <tr>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Ranking</th>
                            <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700">Course Name</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">SAW Score (Vi)</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Cost</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Rating</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr class="hover:bg-indigo-50 transition-colors {{ $result->ranking % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 text-center border border-gray-200">
                                    @if ($result->ranking <= 3)
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-white
                                            {{ $result->ranking == 1 ? 'bg-yellow-500' : ($result->ranking == 2 ? 'bg-gray-400' : 'bg-orange-500') }}">
                                            {{ $result->ranking }}
                                        </span>
                                    @else
                                        <span class="font-bold text-gray-700">{{ $result->ranking }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 border border-gray-200 font-semibold text-gray-900">
                                    {{ $result->course->nama_kursus }}
                                </td>
                                <td class="px-4 py-4 text-center border border-gray-200">
                                    <span class="text-xl font-bold text-indigo-600">{{ number_format($result->nilai_saw, 4) }}</span>
                                </td>
                                <td class="px-4 py-4 text-center border border-gray-200">
                                    {{ number_format($result->course->biaya, 0) }}K
                                </td>
                                <td class="px-4 py-4 text-center border border-gray-200">
                                    {{ number_format($result->course->rating, 1) }}
                                </td>
                                <td class="px-4 py-4 text-center border border-gray-200">
                                    {{ $result->course->durasi }} hrs
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:hidden space-y-4">
                @foreach ($results as $result)
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow {{ $result->ranking % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3 flex-1">
                                @if ($result->ranking <= 3)
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-white
                                        {{ $result->ranking == 1 ? 'bg-yellow-500' : ($result->ranking == 2 ? 'bg-gray-400' : 'bg-orange-500') }}">
                                        {{ $result->ranking }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-gray-700 bg-gray-200">
                                        {{ $result->ranking }}
                                    </span>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-base truncate">
                                        {{ $result->course->nama_kursus }}</h4>
                                    <p class="text-sm text-indigo-600 font-bold mt-1">SAW Score:
                                        {{ number_format($result->nilai_saw, 4) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500 block mb-1">Cost</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->course->biaya, 0) }}K</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block mb-1">Rating</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->course->rating, 1) }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-500 block mb-1">Duration</span>
                                <span class="font-semibold text-gray-900">{{ $result->course->durasi }} hrs</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Normalization Matrix Details --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Normalization Matrix Details
            </h3>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700">No</th>
                            <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700">Course</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Cost</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Rating</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Duration</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Flexibility</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Certificate</th>
                            <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr class="{{ $result->ranking % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3 border border-gray-200 font-semibold">{{ $result->ranking }}</td>
                                <td class="px-4 py-3 border border-gray-200 font-medium">{{ $result->course->nama_kursus }}</td>
                                <td class="px-4 py-3 border border-gray-200 text-center">{{ number_format($result->norm_biaya, 4) }}</td>
                                <td class="px-4 py-3 border border-gray-200 text-center">{{ number_format($result->norm_rating, 4) }}</td>
                                <td class="px-4 py-3 border border-gray-200 text-center">{{ number_format($result->norm_durasi, 4) }}</td>
                                <td class="px-4 py-3 border border-gray-200 text-center">{{ number_format($result->norm_fleksibilitas, 4) }}</td>
                                <td class="px-4 py-3 border border-gray-200 text-center">{{ number_format($result->norm_sertifikat, 4) }}</td>
                                <td class="px-4 py-3 border border-gray-200 text-center">{{ number_format($result->norm_update, 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:hidden space-y-4">
                @foreach ($results as $result)
                    <div class="border border-gray-200 rounded-lg p-4 {{ $result->ranking % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2 py-1 rounded">#{{ $result->ranking }}</span>
                            <h4 class="font-semibold text-gray-900 text-sm flex-1 truncate">{{ $result->course->nama_kursus }}</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-gray-500 block">Cost</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->norm_biaya, 4) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Rating</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->norm_rating, 4) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Duration</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->norm_durasi, 4) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Flexibility</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->norm_fleksibilitas, 4) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Certificate</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->norm_sertifikat, 4) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Last Update</span>
                                <span class="font-semibold text-gray-900">{{ number_format($result->norm_update, 4) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Button Actions --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('perhitungan') }}"
                class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center transition-all">
                Recalculate SAW
            </a>
            <a href="{{ route('dashboard') }}"
                class="w-full sm:w-auto px-6 py-4 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-center">
                Back to Dashboard
            </a>
        </div>
    @endif
</div>

