<x-layout :title="$title">
    <div class="p-4 md:p-6 pt-0">
        {{-- Info Card --}}
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-3 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <h2 class="text-2xl font-bold">Add New Course</h2>
            </div>
            <p class="text-blue-100 text-sm">
                Fill in the form below to add a new course to the SPK Online Courses system.
            </p>
        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Form Input Data Kursus --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <form action="{{ route('courses.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Kursus --}}
                    <div
                        class="md:col-span-2 border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                        <label for="nama_kursus" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Course Name <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-xs text-gray-500">Full name of the course to be added</p>
                            </div>
                        </label>
                        <input type="text" name="nama_kursus" id="nama_kursus" value="{{ old('nama_kursus') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('nama_kursus') border-red-500 @enderror"
                            placeholder="Example: Data Science Pro">
                        @error('nama_kursus')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Biaya --}}
                    <div
                        class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                        <label for="biaya" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Cost (thousand rupiah) <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-xs text-gray-500">Course cost in thousands of rupiah</p>
                            </div>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                            <input type="number" name="biaya" id="biaya" value="{{ old('biaya') }}"
                                min="0" step="1"
                                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('biaya') border-red-500 @enderror"
                                placeholder="1500">
                            <span class="absolute right-4 top-3 text-gray-500">K</span>
                        </div>
                        @error('biaya')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rating --}}
                    <div
                        class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                        <label for="rating" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Rating <span class="text-red-500">*</span>
                                </h3>
                                <p class="text-xs text-gray-500">Course rating (0.0 - 5.0)</p>
                            </div>
                        </label>
                        <input type="number" name="rating" id="rating" value="{{ old('rating') }}" min="0"
                            max="5" step="0.1"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('rating') border-red-500 @enderror"
                            placeholder="4.7">
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Durasi --}}
                    <div
                        class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                        <label for="durasi" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Duration (hours) <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-xs text-gray-500">Course duration in hours</p>
                            </div>
                        </label>
                        <input type="number" name="durasi" id="durasi" value="{{ old('durasi') }}"
                            min="0" step="1"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('durasi') border-red-500 @enderror"
                            placeholder="45">
                        @error('durasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fleksibilitas --}}
                    <div
                        class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                        <label for="fleksibilitas" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Flexibility <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-xs text-gray-500">Flexibility level (1-5)</p>
                            </div>
                        </label>
                        <select name="fleksibilitas" id="fleksibilitas"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('fleksibilitas') border-red-500 @enderror">
                            <option value="">Select Flexibility</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ old('fleksibilitas') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('fleksibilitas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sertifikat --}}
                    <div
                        class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                        <label for="sertifikat" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Certificate <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-xs text-gray-500">Certificate quality (1-5)</p>
                            </div>
                        </label>
                        <select name="sertifikat" id="sertifikat"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('sertifikat') border-red-500 @enderror">
                            <option value="">Select Certificate</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('sertifikat') == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        @error('sertifikat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Update Terakhir --}}
                    <div
                        class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all md:col-span-2">
                        <label for="update_terakhir" class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Last Update <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-xs text-gray-500">Course material update level (1-5)</p>
                            </div>
                        </label>
                        <select name="update_terakhir" id="update_terakhir"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('update_terakhir') border-red-500 @enderror">
                            <option value="">Select Last Update</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ old('update_terakhir') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('update_terakhir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <span class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Save New Course
                        </span>
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="w-full sm:w-auto px-6 py-4 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
