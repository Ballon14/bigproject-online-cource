<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

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

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
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
            <form action="{{ route('perhitungan.store') }}" method="POST" id="bobotForm" x-data="{ submitting: false }"
                @submit="submitting = true">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Cost <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="biaya" value="{{ old('biaya', $bobot['biaya'] ?? 20) }}"
                            min="0" step="0.01" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            oninput="calculateTotal()">
                        <p class="text-xs text-gray-500 mt-1">Cost criteria (lower is better)</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="rating" value="{{ old('rating', $bobot['rating'] ?? 25) }}"
                            min="0" step="0.01" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            oninput="calculateTotal()">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria (higher is better)</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Duration <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="durasi" value="{{ old('durasi', $bobot['durasi'] ?? 15) }}"
                            min="0" step="0.01" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            oninput="calculateTotal()">
                        <p class="text-xs text-gray-500 mt-1">Cost criteria (lower is better)</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Flexibility <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="fleksibilitas"
                            value="{{ old('fleksibilitas', $bobot['fleksibilitas'] ?? 15) }}" min="0"
                            step="0.01" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            oninput="calculateTotal()">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Certificate <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="sertifikat"
                            value="{{ old('sertifikat', $bobot['sertifikat'] ?? 15) }}" min="0" step="0.01"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            oninput="calculateTotal()">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Last Update <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="update_terakhir"
                            value="{{ old('update_terakhir', $bobot['update_terakhir'] ?? 10) }}" min="0"
                            step="0.01" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            oninput="calculateTotal()">
                        <p class="text-xs text-gray-500 mt-1">Benefit criteria</p>
                    </div>
                </div>
                <div class="mt-4 p-4 bg-gray-50 rounded-lg mb-4">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Total Bobot:</span>
                        <span id="totalBobot" class="text-xl font-bold text-indigo-600">0</span>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" :disabled="submitting"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        aria-label="Calculate SAW">
                        <span class="flex items-center justify-center gap-2">
                            <svg x-show="!submitting" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <svg x-show="submitting" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="submitting ? 'Calculating...' : 'Calculate SAW'"></span>
                        </span>
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-center"
                        aria-label="Cancel and return to dashboard">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <script>
            function calculateTotal() {
                const inputs = document.querySelectorAll('#bobotForm input[type="number"]');
                let total = 0;
                inputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                document.getElementById('totalBobot').textContent = total.toFixed(2);
            }
            // Calculate on page load
            calculateTotal();
        </script>

        @if (isset($results) && count($results) > 0)
            {{-- Criteria Weights Used --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Criteria Weights Used (W)
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Cost</div>
                        <div class="text-2xl font-bold text-red-600">{{ number_format($bobot['biaya'], 2) }}%</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Rating</div>
                        <div class="text-2xl font-bold text-yellow-600">{{ number_format($bobot['rating'], 2) }}%
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Duration</div>
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($bobot['durasi'], 2) }}%</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Flexibility</div>
                        <div class="text-2xl font-bold text-green-600">
                            {{ number_format($bobot['fleksibilitas'], 2) }}%
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Certificate</div>
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($bobot['sertifikat'], 2) }}%
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-600 mb-1">Last Update</div>
                        <div class="text-2xl font-bold text-orange-600">
                            {{ number_format($bobot['update_terakhir'], 2) }}%
                        </div>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Total Weight:</span>
                        <span
                            class="text-xl font-bold text-indigo-600">{{ number_format(array_sum($bobot), 2) }}%</span>
                    </div>
                </div>
            </div>

            {{-- Initial Decision Matrix --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Initial Decision Matrix (X)
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200" role="table"
                        aria-label="Initial Decision Matrix Table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700"
                                    scope="col">No</th>
                                <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700"
                                    scope="col">Course
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Cost
                                    (K)
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Rating
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Duration
                                    (hrs)</th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">
                                    Flexibility</th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">
                                    Certificate
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Last Update
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $index => $course)
                                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-3 border border-gray-200 font-semibold">{{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 font-medium">
                                        {{ $course->nama_kursus }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">{{ $course->biaya }}</td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">{{ $course->rating }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">{{ $course->durasi }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $course->fleksibilitas }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">{{ $course->sertifikat }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $course->update_terakhir }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Normalization Matrix --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Normalization Matrix (R)
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200" role="table"
                        aria-label="Normalization Matrix Table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700"
                                    scope="col">No</th>
                                <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700"
                                    scope="col">Course
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Cost
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Rating
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Duration
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">
                                    Flexibility</th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">
                                    Certificate
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Last Update
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $index => $result)
                                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-3 border border-gray-200 font-semibold">{{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 font-medium">
                                        {{ $result['course']->nama_kursus }}</td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $result['norm_biaya'] }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $result['norm_rating'] }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $result['norm_durasi'] }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $result['norm_fleksibilitas'] }}</td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $result['norm_sertifikat'] }}</td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        {{ $result['norm_update'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SAW Calculation Results & Ranking --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    SAW Calculation Results & Ranking
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200" role="table"
                        aria-label="SAW Calculation Results Table">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                            <tr>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">
                                    Ranking
                                </th>
                                <th class="px-4 py-3 text-left border border-gray-200 font-bold text-gray-700"
                                    scope="col">Course
                                    Name
                                </th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">SAW
                                    Score
                                    (Vi)</th>
                                <th class="px-4 py-3 text-center border border-gray-200 font-bold text-gray-700"
                                    scope="col">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $index => $result)
                                <tr
                                    class="hover:bg-indigo-50 transition-colors {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-4 text-center border border-gray-200">
                                        @if ($index < 3)
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-white
                                        {{ $index == 0 ? 'bg-yellow-500' : ($index == 1 ? 'bg-gray-400' : 'bg-orange-500') }}">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            <span class="font-bold text-gray-700">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 border border-gray-200 font-semibold text-gray-900">
                                        {{ $result['course']->nama_kursus }}</td>
                                    <td class="px-4 py-4 text-center border border-gray-200">
                                        <span
                                            class="text-xl font-bold text-indigo-600">{{ number_format($result['nilai_saw'], 4) }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-center border border-gray-200">
                                        <a href="{{ route('result') }}"
                                            class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                            View Details →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Formula Information --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 mb-6">
                <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    SAW Formula Information
                </h4>
                <div class="text-sm text-gray-700 space-y-2">
                    <p><strong>1. Normalization:</strong></p>
                    <ul class="ml-6 list-disc space-y-1">
                        <li><strong>Benefit:</strong> Rij = Xij / Max(Xij)</li>
                        <li><strong>Cost:</strong> Rij = Min(Xij) / Xij</li>
                    </ul>
                    <p class="mt-3"><strong>2. SAW Score Calculation:</strong></p>
                    <p class="ml-6">Vi = Σ (Rij × Wj)</p>
                    <p class="mt-3 text-xs text-gray-600">Note: Xij = alternative value, Rij = normalized value,
                        Wj =
                        criteria weight</p>
                </div>
            </div>

            {{-- Button Actions --}}
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('result') }}"
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center transition-all"
                    aria-label="View detailed ranking results">
                    View Detailed Ranking Results →
                </a>
                <a href="{{ route('dashboard') }}"
                    class="w-full sm:w-auto px-6 py-4 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-center"
                    aria-label="Back to dashboard">
                    Back to Dashboard
                </a>
            </div>
        @endif
    </div>
</x-layout>
