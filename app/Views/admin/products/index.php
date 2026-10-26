<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
$hasFilter = $search !== '' || $categoryId > 0;
$totalProducts = (int) $pager->getTotal();
$currentPage = (int) $pager->getCurrentPage();
$perPage = (int) $pager->getPerPage();
$rangeStart = $totalProducts === 0 ? 0 : (($currentPage - 1) * $perPage) + 1;
$rangeEnd = min($totalProducts, $currentPage * $perPage);
?>

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h2 class="font-display text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Daftar Produk</h2>
        <p class="mt-2 text-sm text-slate-500">Kelola nama, harga, kategori, dan foto produk toko.</p>
    </div>
    <a href="/admin/products/new" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
        <i class="ph ph-plus"></i> Tambah Produk
    </a>
</div>

<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
    <form action="/admin/products" method="get" class="flex flex-col gap-3 lg:flex-row lg:items-center">
        <div class="relative flex-1">
            <i class="ph ph-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
            <input type="search" name="q" value="<?= esc($search) ?>" placeholder="Cari nama produk, deskripsi, atau satuan..."
                   class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
            <select name="kategori" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                <option value="0">Semua kategori</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                <?php endforeach ?>
            </select>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">
                <i class="ph ph-funnel"></i> Filter
            </button>
            <?php if ($hasFilter): ?>
            <a href="/admin/products" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-500 transition hover:border-slate-300 hover:text-slate-700">Reset</a>
            <?php endif ?>
        </div>
    </form>
</div>

<div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
        <div>
            <h3 class="font-display text-base font-bold text-slate-900">Katalog Produk</h3>
            <p class="mt-0.5 text-xs text-slate-400">Menampilkan <?= $rangeStart ?>-<?= $rangeEnd ?> dari <?= $totalProducts ?> produk</p>
        </div>
        <?php if ($hasFilter): ?>
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Filter aktif</span>
        <?php endif ?>
    </div>

    <?php if ($products === []): ?>
    <div class="px-5 py-16 text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"><i class="ph ph-package text-2xl"></i></span>
        <p class="mt-4 text-sm font-bold text-slate-700"><?= $hasFilter ? 'Produk tidak ditemukan' : 'Belum ada produk' ?></p>
        <p class="mt-1 text-xs text-slate-500"><?= $hasFilter ? 'Coba kata kunci atau kategori lain.' : 'Tambahkan produk pertama untuk mulai mengisi katalog.' ?></p>
        <?php if ($hasFilter): ?>
        <a href="/admin/products" class="mt-4 inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-emerald-300 hover:text-emerald-600">Tampilkan semua</a>
        <?php endif ?>
    </div>
    <?php else: ?>

    <div class="hidden overflow-x-auto md:block">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="px-5 py-3">Produk</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Harga</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($products as $product): ?>
                <tr class="transition hover:bg-slate-50/60">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="<?= esc(product_image_url($product['image_url'] ?? null)) ?>" alt="<?= esc($product['name']) ?>" loading="lazy"
                                 class="h-12 w-12 shrink-0 rounded-xl border border-slate-200 bg-slate-50 object-cover">
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-900"><?= esc($product['name']) ?></p>
                                <p class="mt-0.5 truncate text-xs text-slate-400"><?= esc($product['unit'] ?: 'Tanpa satuan') ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <?php if (! empty($product['category_name'])): ?>
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"><?= esc($product['category_name']) ?></span>
                        <?php else: ?>
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Tanpa kategori</span>
                        <?php endif ?>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-slate-900">Rp <?= number_format((int) $product['price'], 0, ',', '.') ?></td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-2">
                            <a href="/admin/products/<?= (int) $product['id'] ?>/edit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600">
                                <i class="ph ph-pencil-simple"></i> Edit
                            </a>
                            <form action="/admin/products/<?= (int) $product['id'] ?>/delete" method="post" data-confirm="Hapus produk ini?">
                                <?= csrf_field() ?>
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-red-300 hover:text-red-600">
                                    <i class="ph ph-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="divide-y divide-slate-100 md:hidden">
        <?php foreach ($products as $product): ?>
        <div class="p-4">
            <div class="flex gap-3">
                <img src="<?= esc(product_image_url($product['image_url'] ?? null)) ?>" alt="<?= esc($product['name']) ?>" loading="lazy"
                     class="h-16 w-16 shrink-0 rounded-xl border border-slate-200 bg-slate-50 object-cover">
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold text-slate-900"><?= esc($product['name']) ?></p>
                    <p class="mt-0.5 text-xs text-slate-400"><?= esc($product['unit'] ?: 'Tanpa satuan') ?></p>
                    <p class="mt-1 font-bold text-slate-900">Rp <?= number_format((int) $product['price'], 0, ',', '.') ?></p>
                    <?php if (! empty($product['category_name'])): ?>
                    <span class="mt-1.5 inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700"><?= esc($product['category_name']) ?></span>
                    <?php else: ?>
                    <span class="mt-1.5 inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700">Tanpa kategori</span>
                    <?php endif ?>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <a href="/admin/products/<?= (int) $product['id'] ?>/edit" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600">
                    <i class="ph ph-pencil-simple"></i> Edit
                </a>
                <form action="/admin/products/<?= (int) $product['id'] ?>/delete" method="post" data-confirm="Hapus produk ini?" class="flex-1">
                    <?= csrf_field() ?>
                    <button type="submit" class="flex w-full items-center justify-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600">
                        <i class="ph ph-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach ?>
    </div>

    <?php endif ?>
</div>

<?= $pager->links('default', 'tailwind') ?>
<?= $this->endSection() ?>
