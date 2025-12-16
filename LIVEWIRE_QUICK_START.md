# Quick Start: Implementasi Livewire

Panduan cepat untuk mengimplementasikan Livewire di aplikasi SPK Online Courses.

## 🚀 Langkah Instalasi

### 1. Install Livewire

```bash
composer require livewire/livewire
```

### 2. Publish Config (Optional)

```bash
php artisan livewire:publish --config
```

### 3. Verifikasi Instalasi

Layout sudah diupdate dengan `@livewireStyles` dan `@livewireScripts`. Pastikan file `resources/views/components/layout.blade.php` sudah benar.

## 📝 Cara Menggunakan Komponen Livewire

### Opsi 1: Langsung sebagai Route (Recommended)

Di `routes/web.php`, ganti route perhitungan:

```php
use App\Livewire\PerhitunganSaw;

// Ganti route ini:
// Route::get('/perhitungan', [CourseController::class, 'perhitungan'])->middleware('auth')->name('perhitungan');

// Dengan ini:
Route::get('/perhitungan', PerhitunganSaw::class)->middleware('auth')->name('perhitungan');
```

### Opsi 2: Melalui View

Gunakan view `perhitungan-livewire.blade.php` yang sudah dibuat:

```php
Route::get('/perhitungan', function () {
    return view('perhitungan-livewire', [
        'title' => 'Perhitungan SAW'
    ]);
})->middleware('auth')->name('perhitungan');
```

## ✨ Fitur yang Tersedia

### 1. **Real-time Total Bobot**
- Total bobot otomatis terupdate saat user mengetik
- Menggunakan `wire:model.live` untuk update real-time

### 2. **Preview Results**
- Tombol "Preview Results" untuk melihat hasil tanpa save
- Tidak perlu submit form untuk preview

### 3. **Calculate & Save**
- Tombol "Calculate & Save SAW" untuk save ke database
- Loading state otomatis saat calculating

### 4. **Error Handling**
- Validasi real-time
- Error message ditampilkan tanpa refresh

## 🔄 Perbandingan Fitur

| Fitur | Traditional | Livewire |
|-------|------------|----------|
| Update Total Bobot | Manual JavaScript | Otomatis (`wire:model.live`) |
| Preview Results | Tidak ada | Ada (tanpa save) |
| Loading State | Manual | Otomatis (`wire:loading`) |
| Error Handling | Redirect dengan error | Real-time di halaman |
| Form State | Hilang saat error | Tetap terjaga |

## 🧪 Testing

1. Install Livewire: `composer require livewire/livewire`
2. Update route di `web.php`
3. Test fitur:
   - Input bobot → lihat total update otomatis
   - Klik "Preview Results" → lihat hasil tanpa save
   - Klik "Calculate & Save SAW" → save ke database

## 📚 File yang Dibuat

1. `app/Livewire/PerhitunganSaw.php` - Komponen Livewire
2. `resources/views/livewire/perhitungan-saw.blade.php` - View komponen
3. `resources/views/perhitungan-livewire.blade.php` - Wrapper view (opsional)
4. `LIVEWIRE_IMPLEMENTATION.md` - Dokumentasi lengkap
5. `routes/livewire-example.php` - Contoh routes

## ⚠️ Catatan

- Pastikan Livewire sudah terinstall sebelum menggunakan
- Layout sudah diupdate dengan Livewire directives
- Komponen menggunakan middleware `auth` (via route)
- Database structure tetap sama, tidak perlu migration

## 🎯 Next Steps

1. Install Livewire
2. Update route untuk menggunakan komponen
3. Test fitur-fitur baru
4. (Optional) Migrate fitur lain ke Livewire:
   - Course Form (create/edit)
   - Course List dengan search
   - Result Display

## 💡 Tips

- Gunakan `wire:model.live` untuk update real-time
- Gunakan `wire:loading` untuk loading states
- Gunakan `wire:target` untuk loading state spesifik
- Test di development dulu sebelum production

