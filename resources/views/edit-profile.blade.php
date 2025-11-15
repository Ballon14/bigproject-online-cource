<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="space-y-6">
        <!-- Header -->
        <section class="bg-white shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm uppercase tracking-widest text-indigo-500 font-semibold">Edit Profile</p>
                    <h1 class="text-3xl font-bold text-gray-900 mt-1">Update Your Profile</h1>
                    <p class="text-gray-600 mt-1">Make changes to your account information</p>
                </div>
                <a href="{{ route('user.detail') }}"
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

            <form method="POST" action="{{ route('user.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
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
                    <a href="{{ route('user.detail') }}"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold shadow-sm hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </section>
    </div>
</x-layout>
