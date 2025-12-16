{{--
    Contoh view yang menggunakan komponen Livewire
    Ganti route di web.php untuk menggunakan view ini
--}}
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Memanggil komponen Livewire --}}
    @livewire('perhitungan-saw')
</x-layout>
