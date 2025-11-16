<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Sistem Pendukung Keputusan (SPK) untuk rekomendasi kursus online menggunakan metode SAW (Simple Additive Weighting)">
    <meta name="keywords" content="SPK, SAW, Sistem Pendukung Keputusan, Kursus Online, Rekomendasi Kursus">
    <meta name="author" content="SPK Sistem">
    <meta name="robots" content="index, follow">
    <title>{{ $title }} - SPK Sistem</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar kiri - Fixed -->
        <x-navbar />
        <!-- Konten utama kanan (header + main content) -->
        <div class="flex-1 flex flex-col min-w-0 ml-0 md:ml-72 pt-14 md:pt-0">
            <x-header />
            <main class="flex-1 overflow-y-auto mx-auto w-full max-w-8xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Global Logout Modal -->
    <x-logout-modal formId="logout-form" />
</body>

</html>
