@props(['formId' => 'logout-form'])

<div x-data="{
    showLogoutModal: false,
    formId: '{{ $formId }}',
    init() {
        // Listen for custom event to open modal
        window.addEventListener('open-logout-modal', (e) => {
            // If formId is provided in event, use it, otherwise use default
            if (e.detail && e.detail.formId) {
                this.formId = e.detail.formId;
            }
            this.showLogoutModal = true;
        });
    },
    closeLogoutModal() {
        this.showLogoutModal = false;
    },
    confirmLogout() {
        document.getElementById(this.formId).submit();
    }
}" x-show="showLogoutModal" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click.self="closeLogoutModal()" @keydown.escape.window="closeLogoutModal()"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black bg-opacity-50" style="display: none;">
    <div x-show="showLogoutModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <!-- Icon -->
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Title & Message -->
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Logout</h3>
            <p class="text-gray-600">Are you sure you want to logout from your account?</p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button @click="closeLogoutModal()"
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                aria-label="Cancel logout">
                Cancel
            </button>
            <button @click="confirmLogout()"
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                aria-label="Confirm logout">
                Yes, Logout
            </button>
        </div>
    </div>
</div>
