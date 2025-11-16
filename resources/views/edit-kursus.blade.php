<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Simple Banner --}}
    <div class="mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Edit Courses</h2>
                    <p class="text-indigo-100 text-sm mt-0.5">Update online course data for more accurate recommendation results</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <form action="{{ route('all-data.update', $course->id) }}" method="POST" class="p-6" x-data="{ submitting: false }" @submit="submitting = true">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 border border-gray-200 rounded-lg p-5 mt-2 hover:border-indigo-300 hover:shadow-md transition-all">
                    <label for="nama_kursus" class="text-sm font-semibold text-gray-700">Course Name <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_kursus" name="nama_kursus"
                        value="{{ old('nama_kursus', $course->nama_kursus) }}"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('nama_kursus') border-red-500 @enderror"
                        placeholder="Course Name">
                    @error('nama_kursus')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                    <label for="biaya" class="text-sm font-semibold text-gray-700">Cost (K) <span class="text-red-500">*</span></label>
                    <input type="number" id="biaya" name="biaya" value="{{ old('biaya', $course->biaya) }}"
                        min="0"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('biaya') border-red-500 @enderror"
                        placeholder="Course Cost">
                    @error('biaya')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                    <label for="rating" class="text-sm font-semibold text-gray-700">Rating <span class="text-red-500">*</span></label>
                    <input type="number" name="rating" id="rating" step="0.1" min="0" max="5"
                        value="{{ old('rating', $course->rating) }}"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('rating') border-red-500 @enderror"
                        placeholder="Rating 0-5">
                    @error('rating')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                    <label for="durasi" class="text-sm font-semibold text-gray-700">Duration (hours) <span class="text-red-500">*</span></label>
                    <input type="number" name="durasi" id="durasi" min="0"
                        value="{{ old('durasi', $course->durasi) }}"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('durasi') border-red-500 @enderror"
                        placeholder="Durasi">
                    @error('durasi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                    <label for="fleksibilitas" class="text-sm font-semibold text-gray-700">Flexibility <span class="text-red-500">*</span></label>
                    <select name="fleksibilitas" id="fleksibilitas"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('fleksibilitas') border-red-500 @enderror">
                        <option value="">Select Flexibility</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}"
                                {{ old('fleksibilitas', $course->fleksibilitas) == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                    @error('fleksibilitas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all">
                    <label for="sertifikat" class="text-sm font-semibold text-gray-700">Certificate <span class="text-red-500">*</span></label>
                    <select name="sertifikat" id="sertifikat"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('sertifikat') border-red-500 @enderror">
                        <option value="">Select Certificate</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}"
                                {{ old('sertifikat', $course->sertifikat) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('sertifikat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 hover:shadow-md transition-all md:col-span-2">
                    <label for="update_terakhir" class="text-sm font-semibold text-gray-700">Last Update <span class="text-red-500">*</span></label>
                    <select name="update_terakhir" id="update_terakhir"
                        class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('update_terakhir') border-red-500 @enderror">
                        <option value="">Select Last Update</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}"
                                {{ old('update_terakhir', $course->update_terakhir) == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                    @error('update_terakhir')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex flex-col sm:flex-row gap-4">
                <button type="submit"
                    :disabled="submitting"
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    aria-label="Simpan perubahan data kursus">
                    <span class="flex items-center justify-center gap-2">
                        <svg x-show="!submitting" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <svg x-show="submitting" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="submitting ? 'Saving...' : 'Save'"></span>
                    </span>
                </button>
                <a href="{{ route('all-data') }}"
                    class="w-full sm:w-auto px-6 py-4 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-center"
                    aria-label="Cancel and return to courses data">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layout>
