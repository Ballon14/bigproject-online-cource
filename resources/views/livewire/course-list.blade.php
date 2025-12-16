<div class="p-4 md:p-8">
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">All Courses Data</h2>
            <p class="mt-1 text-sm text-gray-500">All course data, you can edit or delete as needed.</p>
        </div>
        <div class="flex gap-3 flex-wrap">
            {{-- Search --}}
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Search courses...">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <a href="{{ route('input-data') }}"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Course
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 rounded bg-green-100 border-l-4 border-green-500 text-green-700">
            <svg class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Desktop Table View --}}
    <div class="hidden lg:block bg-white shadow rounded-xl py-2 px-2 md:px-6 md:py-4 overflow-x-auto">
        <table class="min-w-full border divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('id')" scope="col">
                        # @if ($sortField === 'id')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('nama_kursus')" scope="col">
                        Course Name
                        @if ($sortField === 'nama_kursus')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('biaya')" scope="col">
                        Cost
                        @if ($sortField === 'biaya')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('rating')" scope="col">
                        Rating
                        @if ($sortField === 'rating')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase" scope="col">Duration</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase" scope="col">Flexibility</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase" scope="col">Certificate</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase" scope="col">Last Update</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($courses as $i => $c)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-4 py-3 font-bold text-indigo-600">
                            {{ ($courses->currentPage() - 1) * $courses->perPage() + $i + 1 }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $c->nama_kursus }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($c->biaya, 0, ',', '.') }}K</td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ $c->rating }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $c->durasi }} hrs</td>
                        <td class="px-4 py-3">{{ $c->fleksibilitas }}/5</td>
                        <td class="px-4 py-3">{{ $c->sertifikat }}/5</td>
                        <td class="px-4 py-3">{{ $c->update_terakhir }}/5</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('all-data.edit', $c->id) }}"
                                    class="inline-flex items-center px-3 py-2 text-xs font-bold text-blue-700 bg-blue-100 rounded hover:bg-blue-200 hover:text-indigo-700 transition-colors">
                                    <i class="fa fa-edit mr-1" aria-hidden="true"></i> Edit
                                </a>
                                <button wire:click="delete({{ $c->id }})" wire:confirm="Are you sure you want to delete this course?"
                                    class="inline-flex items-center px-3 py-2 text-xs font-bold text-red-700 bg-red-100 rounded hover:bg-red-200 hover:text-red-800 transition-colors">
                                    <i class="fa fa-trash mr-1" aria-hidden="true"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="font-semibold">No course data found</p>
                                <p class="text-sm mt-1">
                                    @if ($search)
                                        No courses match your search "{{ $search }}"
                                    @else
                                        Please add a new course to get started
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6 px-4">
            {{ $courses->links() }}
        </div>
    </div>

    {{-- Mobile Card View --}}
    <div class="lg:hidden space-y-4">
        @forelse ($courses as $i => $c)
            <div class="bg-white shadow rounded-xl p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2 py-1 rounded">
                                #{{ ($courses->currentPage() - 1) * $courses->perPage() + $i + 1 }}
                            </span>
                            <h4 class="font-semibold text-gray-900 text-base truncate">{{ $c->nama_kursus }}</h4>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div>
                        <span class="text-gray-500 block mb-1">Cost</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($c->biaya, 0, ',', '.') }}K</span>
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
                        <span class="font-semibold text-gray-900">{{ $c->fleksibilitas }}/5</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block mb-1">Certificate</span>
                        <span class="font-semibold text-gray-900">{{ $c->sertifikat }}/5</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block mb-1">Last Update</span>
                        <span class="font-semibold text-gray-900">{{ $c->update_terakhir }}/5</span>
                    </div>
                </div>
                <div class="flex gap-2 pt-3 border-t border-gray-200">
                    <a href="{{ route('all-data.edit', $c->id) }}"
                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-bold text-blue-700 bg-blue-100 rounded hover:bg-blue-200 hover:text-indigo-700 transition-colors">
                        <i class="fa fa-edit mr-1" aria-hidden="true"></i> Edit
                    </a>
                    <button wire:click="delete({{ $c->id }})" wire:confirm="Are you sure you want to delete this course?"
                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-bold text-red-700 bg-red-100 rounded hover:bg-red-200 hover:text-red-800 transition-colors">
                        <i class="fa fa-trash mr-1" aria-hidden="true"></i> Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-xl p-8 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="font-semibold text-gray-700 mb-1">No course data found</p>
                <p class="text-sm text-gray-500 mb-4">
                    @if ($search)
                        No courses match your search "{{ $search }}"
                    @else
                        Please add a new course to get started
                    @endif
                </p>
                @if (!$search)
                    <a href="{{ route('input-data') }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Course
                    </a>
                @endif
            </div>
        @endforelse
        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    </div>
</div>

