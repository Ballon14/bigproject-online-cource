<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-600">Halo, {{ auth()->user()->nama ?? auth()->user()->name }} 👋</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-lg bg-white p-8 shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Selamat! Login Berhasil.</h2>
            <p class="text-gray-600 leading-relaxed">
                Kamu sekarang berada di halaman dashboard. Ganti konten halaman ini dengan informasi atau fitur utama
                sesuai kebutuhan aplikasi kamu.
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Profil Pengguna</h3>
                    <p class="text-sm text-gray-600">
                        Email: {{ auth()->user()->email }}<br>
                        Username: {{ auth()->user()->username }}
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Apa selanjutnya?</h3>
                    <p class="text-sm text-gray-600">
                        Tambahkan card atau statistik di sini untuk memberi ringkasan data penting kepada pengguna.
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<div>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
</div>
