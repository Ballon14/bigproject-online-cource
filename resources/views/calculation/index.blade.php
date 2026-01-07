<x-layout :title="$title">
    <div class="p-4 md:p-6 pt-0">
        {{-- Header Banner --}}
        <div class="bg-blue-600 text-white rounded-xl shadow-lg px-6 py-8 md:px-12 md:py-10 mb-6">
            <div class="flex items-center gap-4 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold">SAW Calculation (Simple Additive Weighting)</h2>
                    <p class="text-blue-100 text-sm mt-1">Calculate course ranking using SAW method</p>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Form Input Criteria Weights --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Input Criteria Weights (W)
            </h3>
            <p class="text-sm text-gray-600 mb-4">Enter weights for each criteria. Total weights will be normalized to
                100%.</p>

            <form action="{{ route('perhitungan.calculate') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Cost <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="biaya" value="{{ old('biaya', $bobot['biaya'] ?? 20) }}"
                            min="0" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('biaya') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Cost criteria (lower is better)</p>
                        @error('biaya')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="rating" value="{{ old('rating', $bobot['rating'] ?? 25) }}"
                            min="0" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('rating') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria (higher is better)</p>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Duration <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="durasi" value="{{ old('durasi', $bobot['durasi'] ?? 15) }}"
                            min="0" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('durasi') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Cost criteria (lower is better)</p>
                        @error('durasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Flexibility <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="fleksibilitas"
                            value="{{ old('fleksibilitas', $bobot['fleksibilitas'] ?? 15) }}" min="0"
                            step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('fleksibilitas') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria</p>
                        @error('fleksibilitas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Certificate <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="sertifikat"
                            value="{{ old('sertifikat', $bobot['sertifikat'] ?? 15) }}" min="0" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('sertifikat') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria</p>
                        @error('sertifikat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Last Update <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="update_terakhir"
                            value="{{ old('update_terakhir', $bobot['update_terakhir'] ?? 10) }}" min="0"
                            step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('update_terakhir') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria</p>
                        @error('update_terakhir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Calculate & Save SAW
                        </span>
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        @if ($showResults && count($results) > 0)
            {{-- Criteria Weights Used --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Last Calculation Results
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Cost</div>
                        <div class="text-2xl font-bold text-red-600">{{ number_format($bobot['biaya'] ?? 0, 2) }}%
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Rating</div>
                        <div class="text-2xl font-bold text-yellow-600">{{ number_format($bobot['rating'] ?? 0, 2) }}%
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Duration</div>
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($bobot['durasi'] ?? 0, 2) }}%
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Flexibility</div>
                        <div class="text-2xl font-bold text-green-600">
                            {{ number_format($bobot['fleksibilitas'] ?? 0, 2) }}%</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Certificate</div>
                        <div class="text-2xl font-bold text-purple-600">
                            {{ number_format($bobot['sertifikat'] ?? 0, 2) }}%</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Last Update</div>
                        <div class="text-2xl font-bold text-orange-600">
                            {{ number_format($bobot['update_terakhir'] ?? 0, 2) }}%</div>
                    </div>
                </div>
            </div>

            {{-- Quick Results --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Top 5 Courses
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                            <tr>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">
                                    Ranking</th>
                                <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700">Course
                                    Name</th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700">SAW
                                    Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results->take(5) as $result)
                                <tr
                                    class="hover:bg-indigo-50 transition-colors {{ $result->ranking % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
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
                                        <span
                                            class="text-xl font-bold text-indigo-600">{{ number_format($result->nilai_saw, 4) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('result') }}"
                        class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold">
                        View Complete Results →
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
