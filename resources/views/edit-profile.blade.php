<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div x-data="{
        showConfirmModal: false,
        showCancelModal: false,
        isFormDirty: false,
        initialValues: {},
        init() {
            // Listen for custom event to open modal
            window.addEventListener('open-edit-confirm-modal', () => {
                this.showConfirmModal = true;
            });
    
            // Store initial form values
            this.initialValues = {
                nama: document.getElementById('nama').value,
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value
            };
    
            // Track form changes
            const form = document.getElementById('edit-profile-form');
            form.addEventListener('input', () => {
                this.checkFormChanges();
            });
            form.addEventListener('change', () => {
                this.checkFormChanges();
            });
        },
        checkFormChanges() {
            const currentValues = {
                nama: document.getElementById('nama').value,
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value
            };
    
            this.isFormDirty = JSON.stringify(currentValues) !== JSON.stringify(this.initialValues);
        },
        closeConfirmModal() {
            this.showConfirmModal = false;
        },
        closeCancelModal() {
            this.showCancelModal = false;
        },
        confirmEdit() {
            this.isFormDirty = false; // Reset dirty state before submit
            document.getElementById('edit-profile-form').submit();
        },
        handleSubmit(e) {
            e.preventDefault();
            this.showConfirmModal = true;
        },
        handleCancel(e) {
            if (this.isFormDirty) {
                e.preventDefault();
                this.showCancelModal = true;
            }
        },
        confirmCancel() {
            window.location.href = '{{ route('user.detail') }}';
        }
    }" class="space-y-6">
        <!-- Header -->
        <section class="bg-white shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm uppercase tracking-widest text-indigo-500 font-semibold">Edit Profile</p>
                    <h1 class="text-3xl font-bold text-gray-900 mt-1">Update Your Profile</h1>
                    <p class="text-gray-600 mt-1">Make changes to your account information</p>
                </div>
                <a href="{{ route('user.detail') }}" @click="handleCancel($event)"
                    class="inline-flex justify-center items-center px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold shadow-sm hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </section>

        <!-- Edit Form -->
        <section class="bg-white shadow-sm rounded-2xl p-6">
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                </div>
            @endif

            <form id="edit-profile-form" method="POST" action="{{ route('user.update') }}"
                @submit.prevent="handleSubmit($event)" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition"
                            placeholder="John Doe">
                        @error('nama')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input id="username" type="text" name="username"
                            value="{{ old('username', $user->username) }}" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition"
                            placeholder="johndoe">
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition"
                            placeholder="you@example.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password (Optional)</h3>
                    <p class="text-sm text-gray-600 mb-4">Leave blank if you don't want to change your password</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New
                                Password</label>
                            <input id="password" type="password" name="password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition"
                                placeholder="Leave blank to keep current password">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition"
                                placeholder="Repeat new password">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                        Update Profile
                    </button>
                    <a href="{{ route('user.detail') }}" @click="handleCancel($event)"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold shadow-sm hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </section>

        <!-- Confirmation Modal -->
        <div x-show="showConfirmModal" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click.self="closeConfirmModal()"
            @keydown.escape.window="closeConfirmModal()"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black bg-opacity-50"
            style="display: none;">
            <div x-show="showConfirmModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <!-- Icon -->
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Title & Message -->
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Edit Profile</h3>
                    <p class="text-gray-600">Are you sure you want to save changes to your profile?</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button @click="closeConfirmModal()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                        aria-label="Cancel edit profile">
                        Cancel
                    </button>
                    <button @click="confirmEdit()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                        aria-label="Confirm and save profile changes">
                        Yes, Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Cancel Confirmation Modal -->
        <div x-show="showCancelModal" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click.self="closeCancelModal()"
            @keydown.escape.window="closeCancelModal()"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black bg-opacity-50"
            style="display: none;">
            <div x-show="showCancelModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <!-- Icon -->
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Title & Message -->
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Unsaved Changes</h3>
                    <p class="text-gray-600">You have unsaved changes. Are you sure you want to cancel and leave this page?</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button @click="closeCancelModal()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                        aria-label="Go back to editing">
                        Go Back
                    </button>
                    <button @click="confirmCancel()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors"
                        aria-label="Confirm cancel and discard changes">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
