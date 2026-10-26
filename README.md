# SayurSegar

SayurSegar adalah aplikasi toko sayur dan kebutuhan dapur berbasis web. Pengunjung dapat melihat katalog produk, memfilter produk berdasarkan kategori, memasukkan produk ke keranjang, lalu mengirim pesanan melalui WhatsApp. Admin toko dapat mengelola produk dan kategori melalui panel admin.

Aplikasi dibangun dengan **PHP 8.2 + CodeIgniter 4.7**, menggunakan **SQLite** sebagai database, serta **Tailwind CSS**, **Phosphor Icons**, dan font lokal untuk tampilan.

---

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi](#teknologi)
- [Struktur Proyek](#struktur-proyek)
- [Persyaratan](#persyaratan)
- [Instalasi](#instalasi)
- [Konfigurasi `.env`](#konfigurasi-env)
- [Cara Menggunakan](#cara-menggunakan)
- [Data Contoh](#data-contoh)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Lisensi](#lisensi)

---

## Fitur

### Storefront (halaman toko)

- Hero section dan katalog produk yang responsif.
- Daftar kategori dengan jumlah produk pada setiap kategori.
- Filter produk berdasarkan kategori melalui URL, misalnya `/?kategori=sayuran`.
- Kartu produk menampilkan nama, deskripsi, harga, satuan, dan gambar.
- Keranjang belanja berbasis `localStorage`, sehingga isi keranjang tetap tersimpan di browser.
- Tambah, kurangi, hapus, dan kosongkan keranjang.
- Perhitungan total belanja otomatis.
- Checkout dengan mengirim ringkasan pesanan ke WhatsApp.
- Tampilan responsif untuk desktop dan mobile.

### Panel Admin

- Login admin menggunakan session CodeIgniter.
- Pembatasan percobaan login untuk mengurangi brute force:
  - Maksimal 5 percobaan per 60 detik untuk kombinasi username + IP.
  - Maksimal 20 percobaan per 60 detik per IP.
- Dashboard berisi ringkasan katalog:
  - Total produk.
  - Total kategori.
  - Jumlah produk tanpa kategori.
  - Rata-rata harga produk.
  - Distribusi produk per kategori.
  - Daftar produk terbaru.
- CRUD produk:
  - Tambah, lihat, edit, dan hapus produk.
  - Pencarian berdasarkan nama, deskripsi, atau satuan.
  - Filter berdasarkan kategori.
  - Pagination 10 produk per halaman.
  - Upload foto produk (JPG, PNG, atau WEBP, maksimal 2 MB).
- CRUD kategori:
  - Tambah, lihat, edit, dan hapus kategori.
  - Slug kategori otomatis dibuat dari nama dan harus unik.
  - Kategori yang masih memiliki produk tidak dapat dihapus.
- Sidebar admin yang responsif.

### Keamanan

- CSRF filter aktif untuk seluruh request `POST`.
- Route admin dilindungi filter `adminauth`.
- Session admin diperbarui setelah login berhasil.
- Password admin disimpan sebagai hash (`password_hash`).
- Output halaman di-escape untuk mengurangi risiko XSS.
- Upload gambar divalidasi berdasarkan MIME dan ukuran file.
- Aksi hapus menggunakan metode `POST`, bukan `GET`.

### Batasan saat ini

- Pesanan tidak disimpan ke database; checkout hanya mengarahkan ke WhatsApp.
- Belum ada manajemen stok dan riwayat pesanan.
- Belum ada payment gateway.
- Belum ada multi-admin dengan role berbeda.

---

## Teknologi

| Komponen | Keterangan |
|---|---|
| Bahasa | PHP 8.2+ |
| Framework | CodeIgniter 4.7 |
| Database | SQLite (`writable/database.db`) |
| Styling | Tailwind CSS yang dikompilasi ke `public/assets/css/app.css` |
| Ikon | Phosphor Icons (lokal) |
| Font | Inter dan Plus Jakarta Sans (lokal) |
| Testing | PHPUnit 10.5 |
| Build CSS | Tailwind CLI melalui npm |

---

## Struktur Proyek

```text
sayurku/
├── app/
│   ├── Config/              # Konfigurasi aplikasi, route, database, filter
│   ├── Controllers/         # Controller storefront dan admin
│   │   └── Admin/           # Controller panel admin
│   ├── Database/
│   │   ├── Migrations/      # Skema tabel
│   │   └── Seeds/           # Data contoh
│   ├── Filters/             # Filter autentikasi admin
│   ├── Libraries/           # Library upload gambar produk
│   ├── Models/              # Model product, category, dan user
│   ├── Services/            # Logika bisnis katalog
│   └── Views/               # Template storefront dan admin
├── docs/                    # PRD dan TRD
├── public/                  # Document root web server
│   ├── assets/              # CSS, font, dan ikon
│   └── uploads/             # File gambar produk
├── resources/css/           # Source CSS Tailwind
├── tests/                   # Test PHPUnit
├── writable/                # Cache, log, session, dan database SQLite
├── env                      # Template konfigurasi environment
└── spark                    # CLI CodeIgniter
```

---

## Persyaratan

Pastikan environment memiliki:

- PHP **8.2 atau lebih baru**.
- Ekstensi PHP:
  - `intl`
  - `mbstring`
  - `sqlite3`
  - `json`
  - `curl` (opsional, untuk kebutuhan HTTP request)
- Composer.
- Node.js dan npm (opsional, hanya jika ingin mengubah atau build ulang CSS Tailwind).

Cek versi PHP dan Composer:

```bash
php -v
composer --version
```

---

## Instalasi

### 1. Install dependency PHP

```bash
composer install
```

### 2. Buat file `.env`

```bash
cp env .env
```

Buka `.env`, lalu sesuaikan konfigurasi berikut:

```dotenv
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

ADMIN_USERNAME = 'admin'
ADMIN_PASSWORD = 'ganti-dengan-password-yang-kuat'

WA_NUMBER = '6281234567890'
WA_DISPLAY = '+62 812-3456-7890'
```

Keterangan:

- `app.baseURL` harus sesuai alamat aplikasi.
- `ADMIN_USERNAME` dan `ADMIN_PASSWORD` dipakai saat menjalankan `UserSeed`.
- `WA_NUMBER` adalah nomor WhatsApp tujuan dengan format internasional tanpa tanda `+` atau spasi.
- `WA_DISPLAY` adalah nomor yang ditampilkan di halaman toko.
- Jangan commit file `.env` karena berisi kredensial.

### 3. Siapkan database dan data contoh

Pastikan folder `writable/` dan `public/uploads/` dapat ditulis oleh web server.

Jalankan migrasi:

```bash
php spark migrate
```

Jalankan seeder secara berurutan:

```bash
php spark db:seed CategorySeed
php spark db:seed ProductSeed
php spark db:seed UserSeed
```

`ProductSeed` membutuhkan data kategori, jadi jalankan setelah `CategorySeed`. `UserSeed` membutuhkan `ADMIN_PASSWORD` yang sudah diatur di `.env`.

Secara default aplikasi menggunakan SQLite dan membuat file database di:

```text
writable/database.db
```

### 4. Build CSS (opsional)

Aset CSS sudah tersedia di `public/assets/css/app.css`. Langkah ini hanya diperlukan jika Anda mengubah tampilan atau kelas Tailwind:

```bash
npm install
npm run build:css
```

Untuk mode watch selama pengembangan:

```bash
npm run watch:css
```

### 5. Jalankan aplikasi

```bash
php spark serve
```

Akses:

- Storefront: `http://localhost:8080/`
- Admin: `http://localhost:8080/admin/login`

Login menggunakan `ADMIN_USERNAME` dan `ADMIN_PASSWORD` yang sudah diatur sebelum menjalankan `UserSeed`.

### 6. Deployment produksi

- Arahkan document root web server ke folder `public/`, bukan root proyek.
- Pastikan `writable/` dan `public/uploads/` dapat ditulis.
- Set `CI_ENVIRONMENT = production` pada `.env`.
- Sesuaikan `app.baseURL` dengan domain yang digunakan.
- Jalankan migrasi dan seeder di server.
- Ganti password admin default dengan password yang kuat.

Contoh konfigurasi Nginx:

```nginx
server {
    listen 80;
    server_name sayursegar.example.com;
    root /path/to/sayurku/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## Konfigurasi `.env`

| Variabel | Wajib | Keterangan |
|---|---|---|
| `CI_ENVIRONMENT` | Tidak | Mode aplikasi, misalnya `development` atau `production`. |
| `app.baseURL` | Ya | URL dasar aplikasi. |
| `ADMIN_USERNAME` | Ya* | Username admin yang dibuat oleh `UserSeed`. |
| `ADMIN_PASSWORD` | Ya* | Password admin yang dibuat oleh `UserSeed`. |
| `WA_NUMBER` | Ya | Nomor WhatsApp tujuan checkout, format internasional tanpa `+`. |
| `WA_DISPLAY` | Tidak | Nomor WhatsApp yang ditampilkan di footer. |

\* Wajib saat menjalankan `UserSeed`.

Konfigurasi database default berada di `app/Config/Database.php` dan menggunakan SQLite. Jika ingin mengganti database, sesuaikan konfigurasi tersebut atau tambahkan variabel `database.default.*` pada `.env`.

---

## Cara Menggunakan

### Sebagai pengunjung

1. Buka halaman utama.
2. Pilih kategori untuk memfilter produk.
3. Klik tombol tambah pada produk untuk memasukkannya ke keranjang.
4. Buka keranjang untuk mengubah jumlah atau menghapus produk.
5. Isi nama dan alamat pada form checkout.
6. Klik **Kirim ke WhatsApp** untuk mengirim ringkasan pesanan.

### Sebagai admin

1. Buka `/admin/login`.
2. Masuk menggunakan akun admin.
3. Kelola produk melalui menu **Produk**.
4. Kelola kategori melalui menu **Kategori**.
5. Lihat ringkasan katalog pada menu **Dashboard**.
6. Klik **Keluar** untuk mengakhiri session admin.

---

## Data Contoh

Seeder menyediakan:

- **4 kategori:** Sayuran, Buah, Bumbu & Rempah, Sembako.
- **17 produk contoh** dengan harga, satuan, deskripsi, dan gambar placeholder.

Data ini dapat diubah atau dihapus melalui panel admin.

---

## Testing

Jalankan seluruh test:

```bash
composer test
```

Atau langsung melalui PHPUnit:

```bash
vendor/bin/phpunit
```

Beberapa test yang berhubungan dengan database membutuhkan konfigurasi database test pada `app/Config/Database.php` atau variabel `database.tests.*` di `.env`.

---

## Troubleshooting

### Folder `writable/` tidak dapat ditulis

Gejala: muncul error terkait cache, log, session, atau database.

Solusi:

```bash
chmod -R ug+rwX writable
```

Sesuaikan juga kepemilikan folder dengan user web server jika diperlukan.

### Database belum ada atau tabel tidak ditemukan

Jalankan ulang migrasi dan seeder:

```bash
php spark migrate
php spark db:seed CategorySeed
php spark db:seed ProductSeed
php spark db:seed UserSeed
```

### Halaman tampil tanpa CSS

Pastikan file `public/assets/css/app.css` ada. Jika mengubah Tailwind, build ulang:

```bash
npm run build:css
```

### Upload foto gagal

Periksa:

- Folder `public/uploads/` dapat ditulis.
- Format file adalah JPG, PNG, atau WEBP.
- Ukuran file tidak lebih dari 2 MB.
- Batas `upload_max_filesize` dan `post_max_size` pada PHP mencukupi.

### Login admin gagal

- Pastikan `UserSeed` sudah dijalankan setelah `ADMIN_PASSWORD` diatur.
- Periksa kembali `ADMIN_USERNAME` dan `ADMIN_PASSWORD`.
- Jika terlalu banyak percobaan, tunggu 60 detik sebelum mencoba lagi.

### Link atau aset mengarah ke alamat yang salah

Sesuaikan `app.baseURL` di `.env` dengan alamat aplikasi, misalnya:

```dotenv
app.baseURL = 'http://localhost:8080/'
```

### Error 404 saat membuka aplikasi

Pastikan web server mengarah ke folder `public/`, bukan root proyek. `index.php` berada di dalam folder `public/`.

---

## Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file [LICENSE](LICENSE) untuk informasi lebih lanjut.
