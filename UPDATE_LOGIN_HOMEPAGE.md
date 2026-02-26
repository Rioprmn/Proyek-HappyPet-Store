# Update: Login Sebagai Halaman Utama

## Perubahan yang Dilakukan

### 1. Routes (`routes/web.php`)
- Halaman utama `/` sekarang menampilkan halaman login
- Semua route belanja (shop, cart, checkout, blog) sekarang memerlukan middleware `auth`
- User yang belum login tidak bisa akses halaman belanja

### 2. Navbar (`resources/views/partials/navbar.blade.php`)
- Menu Shop, Blog, Cart, dan Riwayat Pesanan hanya muncul saat user sudah login
- Menu About dan Contact tetap bisa diakses tanpa login
- Link Login/Register hanya muncul saat belum login

### 3. AuthController (`app/Http/Controllers/AuthController.php`)
- Setelah registrasi, user redirect ke `/shop` (bukan home)
- Setelah login, user redirect ke `/shop` (bukan home)
- Logout tetap redirect ke `/` (halaman login)

## Alur User

### User Baru:
1. Buka website → Halaman login
2. Klik "Daftar" → Form registrasi
3. Isi data dan submit → Otomatis login dan redirect ke shop
4. Bisa belanja

### User Lama:
1. Buka website → Halaman login
2. Masukkan email & password → Login
3. Redirect ke shop
4. Bisa belanja

### Admin:
1. Buka website → Halaman login
2. Masukkan email & password admin → Login
3. Redirect ke admin dashboard
4. Bisa kelola toko

## Fitur Keamanan

✅ User tidak bisa akses `/shop` tanpa login  
✅ User tidak bisa akses `/cart` tanpa login  
✅ User tidak bisa akses `/checkout` tanpa login  
✅ User tidak bisa akses `/my-orders` tanpa login  
✅ Admin area tetap terlindungi dengan middleware `admin`  

## Testing

1. **Test tanpa login:**
   - Buka `/shop` → Seharusnya redirect ke login
   - Buka `/cart` → Seharusnya redirect ke login

2. **Test registrasi:**
   - Klik "Daftar" → Isi form → Submit
   - Seharusnya otomatis login dan ke shop

3. **Test login:**
   - Logout → Klik "Login" → Isi email & password
   - Seharusnya redirect ke shop

4. **Test admin:**
   - Login dengan akun admin
   - Seharusnya redirect ke admin dashboard

---

Sistem sudah siap! User harus login/registrasi dulu sebelum bisa belanja. 🔐
