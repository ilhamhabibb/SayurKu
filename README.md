# SayurSegar

SayurSegar adalah aplikasi toko sayur dan kebutuhan dapur berbasis web. Pengunjung dapat melihat katalog, memfilter produk berdasarkan kategori, menambahkan produk ke keranjang, lalu mengirim ringkasan pesanan melalui WhatsApp. Admin dapat mengelola produk dan kategori melalui panel admin.

Aplikasi dibangun dengan **PHP 8.2+** dan **CodeIgniter 4.7**, menggunakan **SQLite** sebagai database, serta **Tailwind CSS**, **Phosphor Icons**, dan font lokal.

## Fitur

### Storefront

- Katalog produk responsif dengan foto, deskripsi, harga, dan satuan.
- Filter produk berdasarkan kategori melalui URL, misalnya `/?kategori=sayuran`.
- Ringkasan jumlah produk pada setiap kategori.
- Keranjang belanja berbasis `localStorage` (tetap tersimpan setelah halaman dimuat ulang).
- Tambah, kurangi, hapus, dan kosongkan item keranjang.
- Perhitungan total belanja otomatis.
- Checkout dengan mengirim ringkasan pesanan ke WhatsApp.
- Tampilan responsif untuk mobile, tablet, dan desktop.

### Panel admin

- Login admin menggunakan session CodeIgniter.
- Pembatasan percobaan login:
  - Maksimal 5 percobaan per 60 detik untuk kombinasi username + IP.
  - Maksimal 20 percobaan per 60 detik per IP.
- Dashboard berisi total produk, total kategori, jumlah produk tanpa kategori, rata-rata harga, kategori teratas, dan produk terbaru.
- CRUD produk:
  - Tambah, edit, dan hapus produk.
  - Pencarian berdasarkan nama, deskripsi, atau satuan.
  - Filter berdasarkan kategori.
  - Pagination 10 produk per halaman.
  - Upload foto JPG, PNG, atau WEBP dengan ukuran maksimal 2 MB.
- CRUD kategori:
  - Tambah, edit, dan hapus kategori.
  - Slug dibuat otomatis dari nama dan harus unik.
  - Kategori yang masih memiliki produk tidak dapat dihapus.
- Sidebar admin yang responsif.

### Keamanan

- CSRF filter aktif untuk request `POST`.
- Route admin dilindungi filter `adminauth`.
- Session admin diperbarui setelah login berhasil.
- Password admin disimpan sebagai hash (`password_hash`).
- Output halaman di-escape untuk mengurangi risiko XSS.
- Upload gambar divalidasi berdasarkan MIME dan ukuran file.
- Aksi hapus menggunakan `POST`, bukan `GET`.

### Batasan

- Pesanan tidak disimpan ke database; checkout hanya mengarahkan ke WhatsApp.
- Belum ada manajemen stok, riwayat pesanan, pembayaran online, atau multi-admin dengan role berbeda.

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

## Persyaratan

- PHP **8.2 atau lebih baru** dengan ekstensi `intl`, `mbstring`, `sqlite3`, dan `json`.
- Composer.
- Node.js dan npm (opsional, hanya untuk build ulang CSS).

## Instalasi

### 1. Clone dan install dependency

```bash
git clone <url-repository> sayurku
cd sayurku
composer install
```

### 2. Buat file `.env`

```bash
cp env .env
```

Sesuaikan konfigurasi berikut di `.env`:

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
- `WA_NUMBER` adalah nomor WhatsApp tujuan dengan format internasional tanpa `+` atau spasi.
- `WA_DISPLAY` adalah nomor yang ditampilkan di halaman toko.
- Jangan commit `.env` karena berisi kredensial.

### 3. Siapkan database

Pastikan folder `writable/` dan `public/uploads/` dapat ditulis oleh web server.

```bash
php spark migrate
php spark db:seed CategorySeed
php spark db:seed ProductSeed
php spark db:seed UserSeed
```

Seeder harus dijalankan berurutan karena `ProductSeed` membutuhkan kategori dan `UserSeed` membutuhkan `ADMIN_PASSWORD`.

Database SQLite dibuat otomatis di:

```text
writable/database.db
```

File database **tidak disertakan di repository**. Jalankan migrasi dan seeder di setiap environment baru.

### 4. Build CSS (opsional)

Aset CSS sudah tersedia di `public/assets/css/app.css`. Langkah ini hanya diperlukan jika mengubah tampilan atau kelas Tailwind:

```bash
npm install
npm run build:css
```

Untuk mode watch:

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

Login admin menggunakan `ADMIN_USERNAME` dan `ADMIN_PASSWORD` yang diatur di `.env` sebelum menjalankan `UserSeed`.

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

Konfigurasi database berada di `app/Config/Database.php` dan menggunakan SQLite secara default.

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
├── writable/                # Cache, log, session, dan database SQLite lokal
├── env                      # Template konfigurasi environment
└── spark                    # CLI CodeIgniter
```

## Data Contoh

Seeder menyediakan:

- 4 kategori: Sayuran, Buah, Bumbu & Rempah, Sembako.
- 17 produk contoh dengan harga, satuan, deskripsi, dan gambar.

Data dapat diubah atau dihapus melalui panel admin.

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

## Troubleshooting

### Folder `writable/` tidak dapat ditulis

```bash
chmod -R ug+rwX writable
```

Sesuaikan juga kepemilikan folder dengan user web server jika diperlukan.

### Database belum ada atau tabel tidak ditemukan

```bash
php spark migrate
php spark db:seed CategorySeed
php spark db:seed ProductSeed
php spark db:seed UserSeed
```

### Halaman tampil tanpa CSS

Pastikan `public/assets/css/app.css` ada. Jika mengubah Tailwind, build ulang:

```bash
npm run build:css
```

### Upload foto gagal

- Pastikan `public/uploads/` dapat ditulis.
- Format file harus JPG, PNG, atau WEBP.
- Ukuran file maksimal 2 MB.
- Periksa batas `upload_max_filesize` dan `post_max_size` pada PHP.

### Login admin gagal

- Pastikan `UserSeed` sudah dijalankan setelah `ADMIN_PASSWORD` diatur.
- Periksa kembali `ADMIN_USERNAME` dan `ADMIN_PASSWORD` di `.env`.
- Jika terlalu banyak percobaan, tunggu 60 detik.

### Error 404 atau aset tidak ditemukan

Arahkan document root web server ke folder `public/`, bukan root proyek. `index.php` berada di dalam folder `public/`.

Sesuaikan juga `app.baseURL` di `.env` dengan alamat aplikasi.

## Catatan Deployment

- Set `CI_ENVIRONMENT = production` dan sesuaikan `app.baseURL`.
- Arahkan document root ke `public/`.
- Pastikan `writable/` dan `public/uploads/` dapat ditulis.
- Jalankan migrasi dan seeder di server baru.
- Gunakan password admin yang kuat dan unik.
- Aktifkan HTTPS.
- Jangan pernah commit `.env` atau `writable/database.db`.

## Lisensi

MIT. Lihat file [LICENSE](LICENSE).
