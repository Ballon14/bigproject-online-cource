<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar kiri -->
        <x-navbar />
        <!-- Konten utama kanan (header + main content) -->
        <div class="flex-1 flex flex-col">
            <x-header />
            <main class="mx-auto w-full max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
