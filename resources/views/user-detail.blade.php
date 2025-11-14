<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="space-y-6">
        <!-- User Summary -->
        <section class="bg-white shadow-sm rounded-2xl p-6">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <div class="flex-shrink-0">
                    <img class="w-24 h-24 rounded-2xl ring-4 ring-indigo-50"
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->username ?? 'User') }}&background=4F46E5&color=fff&size=256"
                        alt="{{ $user->username ?? 'User' }}">
                </div>
                <div class="flex-1">
                    <p class="text-sm uppercase tracking-widest text-indigo-500 font-semibold">User Detail</p>
                    <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $user->nama ?? $user->username }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-50 text-indigo-600">
                            Username: {{ $user->username }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                            Joined: {{ $user->created_at?->format('d M Y') ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-3 w-full md:w-auto">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex justify-center items-center px-4 py-2.5 rounded-lg bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                        Back to Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex w-full justify-center items-center px-4 py-2.5 rounded-lg border bg-red-500 border-gray-300 text-white font-semibold hover:bg-red-400 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Account Information -->
        <section class="bg-white shadow-sm rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Information</h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->nama ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Username</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->username }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->created_at?->format('d M Y, H:i') ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->updated_at?->diffForHumans() ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700">Active
                    </dd>
                </div>
            </dl>
        </section>

        <!-- Activity/Notes -->
        <section class="bg-white shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Recent Activity</h2>
                <span class="text-sm text-gray-500">Automatically generated</span>
            </div>
            <ul class="space-y-4">
                <li class="flex items-start gap-3">
                    <span class="flex-none mt-1 h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                    <div>
                        <p class="text-gray-900 font-medium">Logged in</p>
                        <p class="text-sm text-gray-500">Your last login was
                            {{ $user->updated_at?->diffForHumans() ?? 'recently' }}.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-none mt-1 h-2.5 w-2.5 rounded-full bg-gray-400"></span>
                    <div>
                        <p class="text-gray-900 font-medium">Profile Created</p>
                        <p class="text-sm text-gray-500">Account registered on
                            {{ $user->created_at?->format('d M Y') ?? '-' }}.</p>
                    </div>
                </li>
            </ul>
        </section>
    </div>
</x-layout>
