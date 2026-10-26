# TRD: Kategori, Produk, dan Admin SayurSegar

## Stack Teknis

- Bahasa/Framework: PHP 8.2 + CodeIgniter 4.7
- Database: SQLite (`writable/database.db`)
- Tampilan: Tailwind CDN, Phosphor Icons, Plus Jakarta Sans + Inter
- Testing: PHPUnit 10 + CodeIgniter Test

## Arsitektur Tingkat Tinggi

Browser -> CodeIgniter Controller -> CatalogService -> Model -> SQLite

Controller menangani request/response. `CatalogService` menangani aturan bisnis katalog. Model hanya berbicara ke database. Upload gambar tetap ditangani `App\Libraries\ProductImage`.

## Skema Database

### Tabel: categories

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | integer | primary key |
| name | varchar(100) | nama kategori |
| slug | varchar(120) | unik, dipakai filter URL |
| description | text | deskripsi singkat |
| image_url | varchar(500) | URL gambar opsional |
| sort_order | integer | urutan tampil |
| created_at | datetime | timestamp |
| updated_at | datetime | timestamp |

### Tabel: products (perubahan)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| category_id | integer | relasi ke categories.id, nullable |

Kolom `category` lama dipertahankan sementara untuk backfill, tetapi tidak lagi dipakai aplikasi.

Relasi: satu kategori memiliki banyak produk. Penghapusan kategori diblokir di level aplikasi jika masih memiliki produk.

## Daftar Endpoint/Rute

| Method | Path | Fungsi | Auth |
|--------|------|--------|------|
| GET | / | Homepage + filter kategori | Tidak |
| GET | /admin/login | Form login | Tidak |
| POST | /admin/login | Proses login | Tidak |
| POST | /admin/logout | Logout | Ya |
| GET | /admin | Dashboard | Ya |
| GET | /admin/products | Daftar produk + pencarian/filter | Ya |
| GET | /admin/products/new | Form tambah produk | Ya |
| POST | /admin/products | Simpan produk | Ya |
| GET | /admin/products/{id}/edit | Form edit produk | Ya |
| POST | /admin/products/{id} | Update produk | Ya |
| POST | /admin/products/{id}/delete | Hapus produk | Ya |
| GET | /admin/categories | Daftar kategori | Ya |
| GET | /admin/categories/new | Form tambah kategori | Ya |
| POST | /admin/categories | Simpan kategori | Ya |
| GET | /admin/categories/{id}/edit | Form edit kategori | Ya |
| POST | /admin/categories/{id} | Update kategori | Ya |
| POST | /admin/categories/{id}/delete | Hapus kategori | Ya |

## Dependency Pihak Ketiga

- Tailwind CDN: styling cepat tanpa build step.
- Phosphor Icons: ikon konsisten.
- Google Fonts: Plus Jakarta Sans dan Inter.

## Rencana Deployment

- Arahkan document root ke `public/`.
- Pastikan `writable/` dan `public/uploads/` dapat ditulis.
- Jalankan `php spark migrate` dan seeder.
- Atur `app.baseURL`, `WA_NUMBER`, dan `WA_DISPLAY` di `.env`.
- Untuk production, pertimbangkan bundling aset dan mengganti CDN dengan file lokal.

## Keamanan

- Auth admin memakai session CI4, bukan cookie status yang bisa dipalsukan.
- CSRF filter aktif untuk semua POST.
- Aksi hapus memakai POST.
- Validasi input dan escape output.
- Upload gambar dibatasi MIME dan ukuran.

## Keputusan yang Masih Perlu Dikonfirmasi User

- Referensi visual admin final (plan memakai gaya hijau yang konsisten dengan homepage).
- Apakah kolom `category` lama perlu dihapus permanen pada iterasi berikutnya.
