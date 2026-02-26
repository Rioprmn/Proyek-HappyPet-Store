# Akun Login untuk Testing

## Cara Membuat Akun (Jalankan Seeder)

```bash
php artisan db:seed
```

Atau jika ingin reset database dulu:

```bash
php artisan migrate:fresh --seed
```

## Akun Admin

**Email:** `admin@happypet.com`  
**Password:** `admin123`

**Akses:**
- Login → Redirect ke Admin Dashboard
- Bisa kelola produk, kategori, pesanan, user, blog, laporan

## Akun User

**Email:** `user@happypet.com`  
**Password:** `user123`

**Akses:**
- Login → Redirect ke Shop
- Bisa belanja, lihat riwayat pesanan

---

## Testing Checklist

### Admin:
- [ ] Login dengan `admin@happypet.com` / `admin123`
- [ ] Redirect ke admin dashboard
- [ ] Bisa akses "Manajemen User"
- [ ] Bisa lihat daftar user
- [ ] Bisa tambah user baru
- [ ] Bisa edit user
- [ ] Bisa hapus user

### User:
- [ ] Login dengan `user@happypet.com` / `user123`
- [ ] Redirect ke shop
- [ ] Bisa lihat produk
- [ ] Bisa tambah ke cart
- [ ] Bisa checkout
- [ ] Bisa lihat riwayat pesanan

### Registrasi Baru:
- [ ] Klik "Daftar"
- [ ] Isi form dengan data baru
- [ ] Submit → Otomatis login
- [ ] Redirect ke shop
- [ ] Admin bisa lihat akun baru di "Manajemen User"

---

Akun sudah siap untuk testing! 🎉
