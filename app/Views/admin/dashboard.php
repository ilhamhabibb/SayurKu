<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
$user = session()->get('admin_user');
$maxCategoryCount = 0;
foreach ($categories as $category) {
    $maxCategoryCount = max($maxCategoryCount, (int) $category['product_count']);
}
?>

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-sm font-medium text-emerald-600">Halo, <?= esc($user['username'] ?? 'Admin') ?></p>
        <h2 class="font-display mt-1 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Ringkasan Katalog</h2>
        <p class="mt-2 text-sm text-slate-500">Pantau produk dan kategori toko dalam satu tampilan.</p>
    </div>
    <a href="/admin/products/new" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
        <i class="ph ph-plus"></i> Tambah Produk
    </a>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Produk</p>
                <p class="font-display mt-2 text-3xl font-extrabold text-slate-900"><?= number_format((int) $stats['total_products'], 0, ',', '.') ?></p>
            </div>
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <i class="ph ph-package text-xl"></i>
            </span>
        </div>
        <p class="mt-3 text-xs text-slate-400">Produk yang tampil di toko</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Kategori</p>
                <p class="font-display mt-2 text-3xl font-extrabold text-slate-900"><?= number_format((int) $stats['total_categories'], 0, ',', '.') ?></p>
            </div>
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                <i class="ph ph-tag text-xl"></i>
            </span>
        </div>
        <p class="mt-3 text-xs text-slate-400">Kelompok produk aktif</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Tanpa Kategori</p>
                <p class="font-display mt-2 text-3xl font-extrabold text-slate-900"><?= number_format((int) $stats['uncategorized'], 0, ',', '.') ?></p>
            </div>
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <i class="ph ph-warning-circle text-xl"></i>
            </span>
        </div>
        <p class="mt-3 text-xs text-slate-400">Perlu dirapikan</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Rata-rata Harga</p>
                <p class="font-display mt-2 text-xl font-extrabold text-slate-900">Rp <?= number_format((int) $stats['average_price'], 0, ',', '.') ?></p>
            </div>
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-500">
                <i class="ph ph-chart-line-up text-xl"></i>
            </span>
        </div>
        <p class="mt-3 text-xs text-slate-400">Dari seluruh produk</p>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-5">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-3">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <h3 class="font-display text-base font-bold text-slate-900">Produk Terbaru</h3>
                <p class="mt-0.5 text-xs text-slate-400">5 produk yang terakhir ditambahkan</p>
            </div>
            <a href="/admin/products" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Lihat semua</a>
        </div>

        <?php if ($stats['latest_products'] === []): ?>
        <div class="px-5 py-12 text-center">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400"><i class="ph ph-package text-2xl"></i></span>
            <p class="mt-3 text-sm font-semibold text-slate-700">Belum ada produk</p>
            <p class="mt-1 text-xs text-slate-500">Tambahkan produk pertama untuk mulai berjualan.</p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-100">
            <?php foreach ($stats['latest_products'] as $product): ?>
            <div class="flex items-center gap-3 px-5 py-3.5">
                <img src="<?= esc(product_image_url($product['image_url'] ?? null)) ?>" alt="<?= esc($product['name']) ?>" loading="lazy"
                     class="h-11 w-11 shrink-0 rounded-xl border border-slate-200 bg-slate-50 object-cover">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900"><?= esc($product['name']) ?></p>
                    <p class="mt-0.5 text-xs text-slate-400"><?= esc($product['category_name'] ?? 'Tanpa kategori') ?> &middot; <?= esc($product['unit'] ?: 'tanpa satuan') ?></p>
                </div>
                <p class="shrink-0 text-sm font-bold text-slate-900">Rp <?= number_format((int) $product['price'], 0, ',', '.') ?></p>
            </div>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    </div>

    <div class="space-y-6 xl:col-span-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h3 class="font-display text-base font-bold text-slate-900">Sebaran Kategori</h3>
                    <p class="mt-0.5 text-xs text-slate-400">Jumlah produk per kategori</p>
                </div>
                <a href="/admin/categories" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Kelola</a>
            </div>

            <?php if ($categories === []): ?>
            <p class="rounded-xl bg-slate-50 px-3 py-4 text-center text-xs text-slate-500">Belum ada kategori.</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($categories as $category): ?>
                <?php $count = (int) $category['product_count']; $percent = $maxCategoryCount > 0 ? max(4, (int) round($count / $maxCategoryCount * 100)) : 4; ?>
                <div>
                    <div class="mb-1.5 flex items-center justify-between text-xs">
                        <span class="font-semibold text-slate-700"><?= esc($category['name']) ?></span>
                        <span class="font-bold text-slate-500"><?= $count ?> produk</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-emerald-500" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="font-display text-base font-bold text-slate-900">Aksi Cepat</h3>
            <div class="mt-4 grid grid-cols-1 gap-2">
                <a href="/admin/products/new" class="flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3 text-sm font-semibold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700">
                    <i class="ph ph-plus-circle text-lg"></i> Tambah produk baru
                    <i class="ph ph-arrow-right ml-auto text-slate-400"></i>
                </a>
                <a href="/admin/categories/new" class="flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3 text-sm font-semibold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700">
                    <i class="ph ph-folder-plus text-lg"></i> Buat kategori
                    <i class="ph ph-arrow-right ml-auto text-slate-400"></i>
                </a>
                <a href="/" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3 text-sm font-semibold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700">
                    <i class="ph ph-storefront text-lg"></i> Buka halaman toko
                    <i class="ph ph-arrow-up-right ml-auto text-slate-400"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
