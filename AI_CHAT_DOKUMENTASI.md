# AI Chat Widget - Dokumentasi

## Overview
Chat AI widget adalah komponen reusable yang bisa ditampilkan di berbagai halaman aplikasi. Widget ini tersimpan di kiri bawah layar dan memungkinkan user untuk chat dengan AI assistant.

## Lokasi File
- **Component**: `resources/views/components/ai-chat.blade.php`
- **Saat ini aktif di**: Home page (`resources/views/home.blade.php`)

## Cara Menggunakan

### 1. Tambah ke Halaman Baru
Untuk menambahkan chat AI ke halaman lain, cukup tambahkan satu baris di akhir file view sebelum `@endsection`:

```blade
@include('components.ai-chat')
@endsection
```

### 2. Contoh Implementasi

**Halaman Blog:**
```blade
@extends('layouts.app')

@section('content')
    <!-- Konten blog -->
@endsection

@include('components.ai-chat')
```

**Halaman Shop:**
```blade
@extends('layouts.app')

@section('content')
    <!-- Konten shop -->
@endsection

@include('components.ai-chat')
```

**Halaman Product Detail:**
```blade
@extends('layouts.app')

@section('content')
    <!-- Konten product -->
@endsection

@include('components.ai-chat')
```

## Fitur
- ✓ Icon chat 💬 di kiri bawah (fixed position)
- ✓ Click icon untuk buka/tutup chat box
- ✓ Chat history dalam satu session
- ✓ Responsive di mobile
- ✓ Styling match dengan tema aplikasi (#2c9a94)

## Customization

### Ubah Icon
Edit di `resources/views/components/ai-chat.blade.php` line 2:
```blade
<button class="chat-toggle" id="chatToggle">💬</button>
```

### Ubah Warna
Edit CSS di file yang sama, ubah `#2c9a94` ke warna yang diinginkan

### Ubah Pesan Default
Edit di line 11:
```blade
<p>Halo! Ada yang bisa saya bantu tentang produk atau artikel kami?</p>
```

## Halaman yang Sudah Menggunakan Chat AI
- ✓ Home page

## Halaman yang Bisa Ditambahkan
- [ ] Blog
- [ ] Shop
- [ ] Product Detail
- [ ] Cart
- [ ] Checkout
- [ ] Profile
- [ ] About
- [ ] Contact

## Notes
- Chat widget hanya muncul di halaman yang include component ini
- Setiap halaman memiliki chat history terpisah
- Widget tidak mengganggu interaksi dengan halaman lain
