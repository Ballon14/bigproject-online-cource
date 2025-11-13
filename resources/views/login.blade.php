<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6">Login</h1>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->has('auth'))
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first('auth') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="you@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2 text-gray-600">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-500">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Sign In
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Don't have an account?
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">Register</a>
            @endif
        </p>
    </div>
</body>

</html>
