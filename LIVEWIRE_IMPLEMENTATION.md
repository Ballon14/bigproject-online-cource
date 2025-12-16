# Implementasi dengan Livewire

Dokumen ini menjelaskan bagaimana mengimplementasikan aplikasi SPK Online Courses menggunakan **Livewire** untuk meningkatkan interaktivitas dan pengalaman pengguna.

## 🎯 Keuntungan Menggunakan Livewire

### 1. **Real-time Interactivity**

-   Update UI tanpa refresh halaman
-   Perhitungan SAW dapat ditampilkan secara real-time saat user mengubah bobot
-   Validasi form yang lebih responsif

### 2. **Kurang JavaScript**

-   Tidak perlu menulis JavaScript manual untuk interaksi
-   Livewire menangani AJAX requests secara otomatis
-   Tetap bisa menggunakan Alpine.js untuk interaksi kompleks

### 3. **Server-side Logic**

-   Logika perhitungan SAW tetap di PHP (server-side)
-   Lebih aman karena validasi dan perhitungan di server
-   Mudah di-debug dan di-maintain

### 4. **Better UX**

-   Loading states yang lebih baik
-   Error handling yang lebih smooth
-   Tidak perlu redirect setelah submit form

## 📦 Instalasi Livewire

### 1. Install Package

```bash
composer require livewire/livewire
```

### 2. Publish Assets (Optional)

```bash
php artisan livewire:publish --config
```

### 3. Include Livewire di Layout

Tambahkan di `resources/views/components/layout.blade.php` sebelum closing `</body>`:

```blade
@livewireStyles
@livewireScripts
```

## 🏗️ Struktur Komponen Livewire

Setelah instalasi, struktur akan menjadi:

```
app/
├── Livewire/
│   ├── PerhitunganSaw.php          # Komponen untuk halaman perhitungan
│   ├── CourseForm.php              # Form input/edit kursus
│   ├── CourseList.php              # List kursus dengan pagination
│   └── ResultDisplay.php           # Tampilan hasil ranking
resources/
└── views/
    └── livewire/
        ├── perhitungan-saw.blade.php
        ├── course-form.blade.php
        ├── course-list.blade.php
        └── result-display.blade.php
```

## 🔄 Perbandingan: Traditional vs Livewire

### Traditional Approach (Saat Ini)

```php
// Controller
public function storePerhitungan(Request $request) {
    // Validasi
    // Perhitungan
    // Simpan ke database
    return redirect()->route('perhitungan')->with('success', '...');
}
```

```blade
<!-- View -->
<form action="{{ route('perhitungan.store') }}" method="POST">
    @csrf
    <!-- Input fields -->
    <button type="submit">Calculate</button>
</form>
```

**Masalah:**

-   Harus refresh halaman
-   Kehilangan state input saat ada error
-   Tidak bisa preview hasil sebelum submit

### Livewire Approach

```php
// Livewire Component
class PerhitunganSaw extends Component {
    public $biaya = 20;
    public $rating = 25;
    // ... properties lainnya

    public function calculate() {
        // Validasi dan perhitungan
        // Update properties
    }

    public function render() {
        return view('livewire.perhitungan-saw');
    }
}
```

```blade
<!-- Livewire View -->
<div>
    <input type="number" wire:model="biaya">
    <button wire:click="calculate">Calculate</button>
    <!-- Results update automatically -->
</div>
```

**Keuntungan:**

-   ✅ Tidak perlu refresh
-   ✅ State tetap terjaga
-   ✅ Bisa preview real-time
-   ✅ Loading states otomatis

## 📝 Contoh Implementasi: Komponen Perhitungan SAW

Lihat file `app/Livewire/PerhitunganSaw.php` dan `resources/views/livewire/perhitungan-saw.blade.php` untuk implementasi lengkap.

## 🚀 Fitur yang Bisa Diimplementasikan dengan Livewire

### 1. **Real-time Calculation Preview**

-   User mengubah bobot → langsung lihat preview hasil
-   Tidak perlu klik tombol "Calculate" untuk preview

### 2. **Dynamic Form Validation**

-   Validasi langsung saat user mengetik
-   Error message muncul tanpa submit

### 3. **Auto-save Draft**

-   Simpan draft perhitungan otomatis
-   User bisa kembali ke draft yang belum selesai

### 4. **Interactive Matrix Display**

-   Update matrix normalization secara real-time
-   Highlight perubahan saat bobot berubah

### 5. **Search & Filter Courses**

-   Filter kursus di halaman perhitungan
-   Search tanpa refresh

## 🔧 Migration Strategy

### Phase 1: Install & Setup

1. Install Livewire
2. Setup layout dengan Livewire directives
3. Test dengan komponen sederhana

### Phase 2: Migrate Calculation Page

1. Buat komponen `PerhitunganSaw`
2. Migrate logic dari controller
3. Update route untuk menggunakan Livewire component

### Phase 3: Migrate Other Pages

1. Course form (create/edit)
2. Course list dengan search & filter
3. Result display page

### Phase 4: Enhancements

1. Real-time preview
2. Auto-save
3. Better loading states

## 📚 Resources

-   [Livewire Documentation](https://livewire.laravel.com/docs)
-   [Livewire GitHub](https://github.com/livewire/livewire)
-   [Laravel Livewire Tutorial](https://laravel-livewire.com/docs/quickstart)

## ⚠️ Catatan Penting

1. **Compatibility**: Livewire 3.x memerlukan Laravel 10+
2. **Performance**: Livewire menggunakan AJAX, pastikan server bisa handle request yang lebih banyak
3. **JavaScript**: Livewire sudah include Alpine.js, tidak perlu install terpisah
4. **Testing**: Test dengan baik karena interaksi lebih kompleks

## 🎓 Next Steps

1. Install Livewire: `composer require livewire/livewire`
2. Review contoh implementasi di folder `app/Livewire/`
3. Mulai dengan migrasi halaman perhitungan SAW
4. Test secara bertahap sebelum migrate semua fitur
