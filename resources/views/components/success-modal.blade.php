<div x-data="{ open: @entangle('showSuccessModal').defer }" x-init="$watch('open', value => {
    if (value) {
        setTimeout(() => open = false, 2000);
    }
})" x-show="open" x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display: none;">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm text-center">
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            </svg>
            <h3 class="mb-2 text-xl font-bold text-gray-800">
                {{ $title ?? 'Berhasil!' }}
            </h3>
            <p class="text-gray-700 mb-4">
                {{ $slot }}
            </p>
            <button @click="open = false"
                class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold shadow hover:bg-indigo-700 transition">
                Oke
            </button>
        </div>
    </div>
</div>
