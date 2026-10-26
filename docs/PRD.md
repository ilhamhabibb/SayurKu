# PRD: Kategori, Produk, dan Admin SayurSegar

## Latar Belakang

SayurSegar sudah memiliki katalog produk dan checkout WhatsApp, tetapi kategori masih berupa teks bebas dan halaman admin belum mendukung pengelolaan kategori. Website perlu terasa lengkap: pengunjung bisa menjelajah produk per kategori, sementara admin bisa mengelola katalog dengan nyaman.

## Target Pengguna

- Pembeli rumahan yang ingin mencari sayur, buah, bumbu, dan sembako dengan cepat.
- Admin toko yang mengelola produk dan kategori dari browser desktop maupun mobile.

## Fitur

### Must-have (MVP)

- Tabel kategori dengan relasi ke produk.
- CRUD kategori di admin.
- CRUD produk dengan pilihan kategori.
- Dashboard admin berisi ringkasan katalog.
- Pencarian dan filter kategori pada daftar produk admin.
- Section kategori dan filter kategori di homepage.
- Data contoh 4 kategori dan 16 produk.
- Tampilan admin responsif dengan sidebar.

### Nice-to-have (versi berikutnya)

- Pengelolaan stok.
- Riwayat pesanan.
- Multi-admin dengan role.

## Di Luar Cakupan

- Payment gateway.
- Database pesanan.
- Manajemen stok.
- Bundling aset frontend untuk production.

## Batasan

- Aplikasi CodeIgniter 4 dengan SQLite lokal.
- Tetap memakai Tailwind CDN dan Phosphor Icons.
- Keranjang dan checkout WhatsApp yang sudah ada harus tetap berfungsi.

## Kriteria Sukses

- Homepage menampilkan kategori dan produk yang bisa difilter.
- Admin dapat menambah, mengubah, dan menghapus produk serta kategori.
- Kategori yang masih dipakai tidak bisa dihapus.
- Tampilan admin nyaman dipakai di desktop dan mobile.
- Tidak ada error PHP atau console error pada alur utama.
