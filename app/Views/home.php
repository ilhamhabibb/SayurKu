<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SayurSegar - Kebutuhan Dapur Harian</title>
<link rel="stylesheet" href="/assets/css/app.css">
<link rel="stylesheet" href="/assets/fonts/fonts.css">
<link rel="stylesheet" href="/assets/phosphor/regular/style.css">
<link rel="stylesheet" href="/assets/phosphor/fill/style.css">
<style>
    body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
    .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
    .hero-pattern { background-image: radial-gradient(rgba(22, 163, 74, 0.16) 1px, transparent 1px); background-size: 24px 24px; }
</style>
</head>
<body class="bg-slate-50 text-slate-800">

<?php
$heroProduct = $products[0] ?? null;
$categoryIcons = [
    'sayuran' => 'ph-plant',
    'buah' => 'ph-orange-slice',
    'bumbu-rempah' => 'ph-pepper',
    'sembako' => 'ph-basket',
];
?>

<nav class="fixed top-0 z-40 w-full border-b border-slate-200/80 bg-white/90 backdrop-blur">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<div class="flex h-16 items-center justify-between">
<a href="/" class="flex items-center gap-2">
<span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm shadow-emerald-200"><i class="ph-fill ph-leaf text-xl"></i></span>
<span class="font-display text-xl font-extrabold tracking-tight text-slate-900">Sayur<span class="text-emerald-600">Segar</span></span>
</a>
<div class="hidden items-center gap-8 md:flex">
<a href="#kategori" class="text-sm font-semibold text-slate-500 transition hover:text-emerald-600">Kategori</a>
<a href="#produk" class="text-sm font-semibold text-slate-500 transition hover:text-emerald-600">Produk</a>
<a href="#checkout" class="text-sm font-semibold text-slate-500 transition hover:text-emerald-600">Checkout</a>
<a href="#tentang" class="text-sm font-semibold text-slate-500 transition hover:text-emerald-600">Tentang</a>
</div>
<button onclick="toggleCart(true)" class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-emerald-300 hover:text-emerald-600" aria-label="Buka keranjang">
<i class="ph ph-shopping-cart text-xl"></i>
<span id="cart-badge" class="absolute -right-1.5 -top-1.5 inline-flex h-5 min-w-5 scale-0 items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white transition-transform">0</span>
</button>
</div>
</div>
</div>
</nav>

<section class="hero-pattern relative overflow-hidden bg-emerald-50/70 pb-14 pt-24 lg:pb-24 lg:pt-32">
<div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-white px-3 py-1.5 text-xs font-bold text-emerald-700 shadow-sm">
<span class="h-2 w-2 rounded-full bg-emerald-500"></span> Panen segar hari ini
</span>
<h1 class="font-display mt-5 text-4xl font-extrabold leading-[1.1] tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">Bahan masak segar, <span class="text-emerald-600">langsung ke dapur Anda.</span></h1>
<p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">Sayuran, buah, bumbu, dan sembako pilihan dari petani lokal. Dipesan pagi, diantar dengan rapi.</p>
<div class="mt-8 flex flex-wrap items-center gap-3">
<a href="#produk" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-700">Belanja Sekarang <i class="ph ph-arrow-right"></i></a>
<a href="#kategori" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-white px-6 py-3.5 text-sm font-bold text-emerald-700 transition hover:border-emerald-300">Lihat Kategori</a>
</div>
<div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-xs font-semibold text-slate-500">
<span class="inline-flex items-center gap-1.5"><i class="ph-fill ph-check-circle text-emerald-500"></i> Produk segar</span>
<span class="inline-flex items-center gap-1.5"><i class="ph-fill ph-check-circle text-emerald-500"></i> Harga jelas</span>
<span class="inline-flex items-center gap-1.5"><i class="ph-fill ph-check-circle text-emerald-500"></i> Pesan via WhatsApp</span>
</div>
</div>

<div class="relative mx-auto w-full max-w-md lg:max-w-none">
<div class="absolute -left-6 -top-6 h-24 w-24 rounded-full bg-emerald-200/60 blur-2xl"></div>
<div class="relative overflow-hidden rounded-[2rem] border border-white bg-white p-3 shadow-2xl shadow-emerald-900/10">
<img src="<?= esc(product_image_url($heroProduct['image_url'] ?? null)) ?>" alt="<?= esc($heroProduct['name'] ?? 'Produk segar SayurSegar') ?>" class="h-72 w-full rounded-[1.5rem] object-cover sm:h-80">
<div class="absolute bottom-6 left-6 right-6 flex items-center justify-between gap-3 rounded-2xl border border-white/70 bg-white/95 p-3.5 shadow-lg backdrop-blur">
<div class="min-w-0">
<p class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">Pilihan hari ini</p>
<p class="truncate text-sm font-bold text-slate-900"><?= esc($heroProduct['name'] ?? 'Produk segar pilihan') ?></p>
</div>
<?php if ($heroProduct !== null): ?>
<p class="shrink-0 text-sm font-extrabold text-emerald-700">Rp <?= number_format((int) $heroProduct['price'], 0, ',', '.') ?></p>
<?php endif ?>
</div>
</div>
<div class="absolute -right-3 top-8 hidden rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-xl sm:block">
<p class="text-[11px] font-semibold uppercase tracking-widest text-slate-400">Kategori</p>
<p class="font-display text-2xl font-extrabold text-slate-900"><?= count($categories) ?></p>
</div>
</div>
</div>
</section>

<section id="kategori" class="bg-white py-16 lg:py-20">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<div class="mb-10 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
<div>
<p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Jelajahi</p>
<h2 class="font-display mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Belanja sesuai kategori</h2>
<p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">Temukan kebutuhan dapur lebih cepat lewat kategori yang sudah dikelompokkan.</p>
</div>
<a href="/#produk" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700">Semua produk <i class="ph ph-arrow-right"></i></a>
</div>

<?php if ($categories === []): ?>
<div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-12 text-center text-sm text-slate-500">Kategori belum tersedia.</div>
<?php else: ?>
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
<?php foreach ($categories as $category): ?>
<?php $isActive = ($activeSlug ?? null) === $category['slug']; ?>
<a href="/?kategori=<?= esc($category['slug']) ?>#produk" class="group relative flex flex-col rounded-2xl border p-5 transition <?= $isActive ? 'border-emerald-300 bg-emerald-50/60 shadow-sm' : 'border-slate-200 bg-white hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-900/5' ?>">
<div class="flex items-start justify-between">
<span class="flex h-12 w-12 items-center justify-center rounded-2xl <?= $isActive ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-600' ?>">
<i class="ph <?= esc($categoryIcons[$category['slug']] ?? 'ph-tag') ?> text-2xl"></i>
</span>
<span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-500"><?= (int) $category['product_count'] ?> produk</span>
</div>
<h3 class="font-display mt-4 text-lg font-bold text-slate-900"><?= esc($category['name']) ?></h3>
<p class="mt-1 line-clamp-2 text-sm leading-relaxed text-slate-500"><?= esc($category['description'] ?: 'Pilihan produk segar untuk kebutuhan harian.') ?></p>
<span class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">Lihat produk <i class="ph ph-arrow-right transition group-hover:translate-x-0.5"></i></span>
</a>
<?php endforeach ?>
</div>
<?php endif ?>
</div>
</section>

<section id="produk" class="bg-slate-50 py-16 lg:py-20">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
<div>
<p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Katalog</p>
<h2 class="font-display mt-2 text-3xl font-extrabold tracking-tight text-slate-900"><?= $activeCategory !== null ? esc($activeCategory['name']) : 'Produk segar kami' ?></h2>
<p class="mt-2 text-sm leading-relaxed text-slate-500">
<?= $activeCategory !== null ? esc($activeCategory['description'] ?: 'Produk pilihan untuk kebutuhan harian.') : 'Pilih kebutuhan dapur, masukkan ke keranjang, lalu checkout lewat WhatsApp.' ?>
</p>
</div>
<span class="inline-flex w-fit items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-500"><i class="ph ph-package text-emerald-600"></i> <?= count($products) ?> produk</span>
</div>

<div class="mb-8 flex gap-2 overflow-x-auto pb-1">
<a href="/#produk" class="shrink-0 rounded-full border px-4 py-2 text-xs font-bold transition <?= $activeSlug === null ? 'border-emerald-600 bg-emerald-600 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-600' ?>">Semua</a>
<?php foreach ($categories as $category): ?>
<a href="/?kategori=<?= esc($category['slug']) ?>#produk" class="shrink-0 rounded-full border px-4 py-2 text-xs font-bold transition <?= $activeSlug === $category['slug'] ? 'border-emerald-600 bg-emerald-600 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-600' ?>"><?= esc($category['name']) ?></a>
<?php endforeach ?>
</div>

<?php if ($products === []): ?>
<div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
<span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"><i class="ph ph-package text-2xl"></i></span>
<p class="mt-4 text-sm font-bold text-slate-700">Belum ada produk di kategori ini</p>
<p class="mt-1 text-xs text-slate-500">Coba pilih kategori lain atau lihat semua produk.</p>
<a href="/#produk" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">Lihat Semua</a>
</div>
<?php else: ?>
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
<?php foreach ($products as $product): ?>
<article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-900/5">
<div class="relative overflow-hidden">
<img src="<?= esc(product_image_url($product['image_url'] ?? null)) ?>" alt="<?= esc($product['name']) ?>" loading="lazy" onerror="this.onerror=null;this.src='<?= esc(base_url('uploads/placeholder.svg')) ?>'" class="h-48 w-full object-cover transition duration-500 group-hover:scale-105">
<span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-bold text-emerald-700 shadow-sm backdrop-blur"><?= esc($product['category_name'] ?? 'Tanpa kategori') ?></span>
</div>
<div class="flex flex-1 flex-col p-4">
<h3 class="font-display text-base font-bold leading-snug text-slate-900"><?= esc($product['name']) ?></h3>
<p class="mt-1 line-clamp-2 min-h-[2.5rem] text-xs leading-relaxed text-slate-500"><?= esc($product['description'] ?: 'Produk segar pilihan untuk kebutuhan dapur.') ?></p>
<p class="mt-2 text-xs font-medium text-slate-400"><?= esc($product['unit'] ?: 'Tanpa satuan') ?></p>
<div class="mt-auto flex items-center justify-between gap-3 pt-4">
<span class="text-lg font-extrabold text-emerald-700">Rp <?= number_format((int) $product['price'], 0, ',', '.') ?></span>
<button type="button" onclick="addToCart(<?= (int) $product['id'] ?>)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 transition hover:bg-emerald-600 hover:text-white" aria-label="Tambah <?= esc($product['name']) ?> ke keranjang">
<i class="ph ph-plus text-lg"></i>
</button>
</div>
</div>
</article>
<?php endforeach ?>
</div>
<?php endif ?>
</div>
</section>

<section id="checkout" class="bg-white py-16 lg:py-20">
<div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-5 lg:gap-16 lg:px-8">
<div class="lg:col-span-2">
<p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Checkout</p>
<h2 class="font-display mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Pesan tanpa ribet.</h2>
<p class="mt-3 text-sm leading-relaxed text-slate-500">Isi nama dan alamat, lalu kirim pesanan. Kami akan mengonfirmasi lewat WhatsApp.</p>

<div class="mt-8 space-y-3">
<div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"><i class="ph ph-shopping-cart text-xl"></i></span>
<div><p class="text-sm font-bold text-slate-900">1. Pilih produk</p><p class="mt-0.5 text-xs text-slate-500">Masukkan produk ke keranjang dari katalog.</p></div>
</div>
<div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"><i class="ph ph-whatsapp-logo text-xl"></i></span>
<div><p class="text-sm font-bold text-slate-900">2. Kirim pesanan</p><p class="mt-0.5 text-xs text-slate-500">Pesanan diteruskan ke WhatsApp admin.</p></div>
</div>
<div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"><i class="ph ph-plant text-xl"></i></span>
<div><p class="text-sm font-bold text-slate-900">3. Kami siapkan</p><p class="mt-0.5 text-xs text-slate-500">Produk disiapkan segar sesuai pesanan.</p></div>
</div>
</div>
</div>

<div class="lg:col-span-3">
<form action="/checkout" method="post" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-8">
<?= csrf_field() ?>
<div class="grid gap-4 sm:grid-cols-2">
<div>
<label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
<input type="text" id="name" name="name" placeholder="Nama penerima" required maxlength="100" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
</div>
<div>
<label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat</label>
<input type="text" id="address" name="address" placeholder="Alamat pengiriman" required maxlength="300" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
</div>
</div>
<div class="mt-4">
<label for="checkout-items" class="mb-1.5 block text-sm font-semibold text-slate-700">Barang yang Dipesan</label>
<textarea id="checkout-items" name="items" placeholder="Tambahkan produk ke keranjang terlebih dahulu" required rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"></textarea>
</div>
<div class="mt-5 flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-4">
<span class="text-sm font-semibold text-slate-500">Total pesanan</span>
<span id="checkout-total" class="font-display text-2xl font-extrabold text-emerald-700">Rp 0</span>
</div>
<input type="hidden" name="total" id="checkout-total-hidden" value="0">
<button type="submit" class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-700">
<i class="ph ph-whatsapp-logo text-lg"></i> Kirim ke WhatsApp
</button>
<p class="mt-3 text-center text-xs text-slate-400">Total akhir dikonfirmasi oleh admin sebelum pengiriman.</p>
</form>
</div>
</div>
</section>

<footer id="tentang" class="bg-slate-900 pb-8 pt-16 text-white">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<div class="grid gap-10 md:grid-cols-3">
<div>
<div class="flex items-center gap-2">
<span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white"><i class="ph-fill ph-leaf text-xl"></i></span>
<span class="font-display text-xl font-extrabold">SayurSegar</span>
</div>
<p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-400">Bahan masakan segar langsung dari petani lokal, dikelola dengan rapi untuk kebutuhan dapur harian.</p>
</div>
<div>
<h4 class="font-display text-sm font-bold uppercase tracking-widest text-slate-300">Tautan</h4>
<ul class="mt-4 space-y-2 text-sm text-slate-400">
<li><a href="/" class="transition hover:text-emerald-400">Beranda</a></li>
<li><a href="#kategori" class="transition hover:text-emerald-400">Kategori</a></li>
<li><a href="#produk" class="transition hover:text-emerald-400">Produk</a></li>
<li><a href="/admin/login" class="transition hover:text-emerald-400">Admin</a></li>
</ul>
</div>
<div>
<h4 class="font-display text-sm font-bold uppercase tracking-widest text-slate-300">Kontak</h4>
<ul class="mt-4 space-y-2 text-sm text-slate-400">
<li class="flex items-center gap-2"><i class="ph ph-whatsapp-logo text-emerald-400"></i> <?= esc(env('WA_DISPLAY', '+62 812 3456 7890')) ?></li>
<li class="flex items-center gap-2"><i class="ph ph-map-pin text-emerald-400"></i> Pengiriman area lokal</li>
</ul>
</div>
</div>
<div class="mt-12 border-t border-slate-800 pt-6 text-center text-xs text-slate-500">&copy; <?= date('Y') ?> SayurSegar. Semua hak dilindungi.</div>
</div>
</footer>

<div id="cart-panel" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm">
<div class="absolute inset-y-0 right-0 flex w-full max-w-md flex-col bg-white shadow-2xl">
<div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
<div>
<h2 class="font-display text-lg font-extrabold text-slate-900">Keranjang</h2>
<p class="text-xs text-slate-400">Produk yang dipilih</p>
</div>
<button type="button" onclick="toggleCart(false)" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:border-slate-300 hover:text-slate-700" aria-label="Tutup keranjang">
<i class="ph ph-x text-lg"></i>
</button>
</div>
<div class="flex-1 overflow-y-auto px-5 py-4">
<ul id="cart-list" class="space-y-3"></ul>
</div>
<div class="border-t border-slate-100 px-5 py-5">
<div class="mb-4 flex items-center justify-between">
<span class="text-sm font-semibold text-slate-500">Total</span>
<span id="cart-total" class="font-display text-2xl font-extrabold text-emerald-700">Rp 0</span>
</div>
<a href="#checkout" onclick="toggleCart(false)" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-700">Lanjut Checkout <i class="ph ph-arrow-right"></i></a>
<button type="button" onclick="clearCart()" class="mt-2 flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-500 transition hover:border-red-200 hover:text-red-600">Kosongkan Keranjang</button>
</div>
</div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-[60] flex flex-col gap-2"></div>

<script>
const PRODUCTS = <?= json_encode($cartProducts, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
const CART_KEY = 'sayurku_cart_v1';
let cart = {};

try {
    const stored = JSON.parse(localStorage.getItem(CART_KEY) || '{}');
    Object.keys(stored).forEach(function (id) {
        if (PRODUCTS[id]) {
            cart[id] = Math.min(99, Math.max(1, Number(stored[id]) || 0));
        }
    });
} catch (error) {
    cart = {};
}

function saveCart() {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function formatRupiah(value) {
    return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

function toggleCart(open) {
    const panel = document.getElementById('cart-panel');
    if (open) {
        panel.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    } else {
        panel.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

function addToCart(id) {
    if (!PRODUCTS[id]) return;
    cart[id] = (cart[id] || 0) + 1;
    saveCart();
    renderCart();
    showToast(PRODUCTS[id].name);
}

function changeQty(id, delta) {
    if (!PRODUCTS[id]) return;
    cart[id] = (cart[id] || 0) + delta;
    if (cart[id] <= 0) delete cart[id];
    saveCart();
    renderCart();
}

function removeItem(id) {
    delete cart[id];
    saveCart();
    renderCart();
}

function clearCart() {
    cart = {};
    saveCart();
    renderCart();
}

function renderCart() {
    const list = document.getElementById('cart-list');
    const badge = document.getElementById('cart-badge');
    const totalEl = document.getElementById('cart-total');
    const count = Object.values(cart).reduce(function (sum, qty) { return sum + Number(qty); }, 0);

    badge.textContent = count;
    badge.classList.toggle('scale-0', count === 0);
    badge.classList.toggle('scale-100', count > 0);

    list.innerHTML = '';
    let total = 0;

    if (count === 0) {
        list.innerHTML = '<li class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-10 text-center"><span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm"><i class="ph ph-shopping-cart text-xl"></i></span><p class="mt-3 text-sm font-bold text-slate-700">Keranjang masih kosong</p><p class="mt-1 text-xs text-slate-500">Tambahkan produk dari katalog.</p></li>';
    } else {
        Object.keys(cart).forEach(function (id) {
            const product = PRODUCTS[id];
            const qty = cart[id];
            total += product.price * qty;

            const li = document.createElement('li');
            li.className = 'flex items-start gap-3 rounded-2xl border border-slate-200 p-3';
            li.innerHTML = '<div class="min-w-0 flex-1"><p class="truncate text-sm font-bold text-slate-900">' + escapeHtml(product.name) + '</p><p class="mt-0.5 text-xs text-slate-400">' + formatRupiah(product.price) + '</p><div class="mt-3 flex items-center gap-2"><button type="button" data-action="minus" data-id="' + id + '" class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:border-emerald-300 hover:text-emerald-600"><i class="ph ph-minus"></i></button><span class="min-w-7 text-center text-sm font-bold text-slate-900">' + qty + '</span><button type="button" data-action="plus" data-id="' + id + '" class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:border-emerald-300 hover:text-emerald-600"><i class="ph ph-plus"></i></button></div></div><div class="text-right"><p class="text-sm font-extrabold text-emerald-700">' + formatRupiah(product.price * qty) + '</p><button type="button" data-action="remove" data-id="' + id + '" class="mt-3 text-xs font-semibold text-slate-400 hover:text-red-500">Hapus</button></div>';
            list.appendChild(li);
        });
    }

    list.querySelectorAll('button[data-action]').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.id;
            if (button.dataset.action === 'plus') changeQty(id, 1);
            if (button.dataset.action === 'minus') changeQty(id, -1);
            if (button.dataset.action === 'remove') removeItem(id);
        });
    });

    totalEl.textContent = formatRupiah(total);
    document.getElementById('checkout-total').textContent = formatRupiah(total);
    document.getElementById('checkout-total-hidden').value = total;
    document.getElementById('checkout-items').value = Object.keys(cart).map(function (id) {
        return PRODUCTS[id].name + ' x' + cart[id];
    }).join(', ');
}

function showToast(name) {
    const toast = document.createElement('div');
    toast.className = 'flex items-start gap-3 rounded-2xl border border-emerald-200 bg-white p-4 shadow-xl';
    toast.innerHTML = '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><i class="ph-fill ph-check-circle text-xl"></i></span><div><p class="text-sm font-bold text-slate-900">Ditambahkan ke keranjang</p><p class="mt-0.5 text-xs text-slate-500">' + escapeHtml(name) + '</p></div>';
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(function () { toast.remove(); }, 2800);
}

document.getElementById('cart-panel').addEventListener('click', function (event) {
    if (event.target === this) toggleCart(false);
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') toggleCart(false);
});

renderCart();
</script>
</body>
</html>
