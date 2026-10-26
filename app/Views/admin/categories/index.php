<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h2 class="font-display text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Kategori Produk</h2>
        <p class="mt-2 text-sm text-slate-500">Kelompokkan produk agar pembeli lebih mudah menemukan kebutuhan.</p>
    </div>
    <a href="/admin/categories/new" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
        <i class="ph ph-plus"></i> Tambah Kategori
    </a>
</div>

<?php if ($categories === []): ?>
<div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">
    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"><i class="ph ph-tag text-2xl"></i></span>
    <p class="mt-4 text-sm font-bold text-slate-700">Belum ada kategori</p>
    <p class="mt-1 text-xs text-slate-500">Buat kategori pertama agar produk lebih terorganisir.</p>
    <a href="/admin/categories/new" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">
        <i class="ph ph-plus"></i> Tambah Kategori
    </a>
</div>
<?php else: ?>
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
    <?php foreach ($categories as $category): ?>
    <?php $count = (int) $category['product_count']; ?>
    <div class="flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md">
        <div class="flex items-start gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <i class="ph ph-tag text-xl"></i>
            </span>
            <div class="min-w-0 flex-1">
                <h3 class="font-display truncate text-base font-bold text-slate-900"><?= esc($category['name']) ?></h3>
                <p class="mt-0.5 truncate text-xs font-medium text-slate-400">/<?= esc($category['slug']) ?></p>
            </div>
            <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600"><?= $count ?> produk</span>
        </div>

        <p class="mt-4 line-clamp-2 min-h-[2.5rem] text-sm leading-relaxed text-slate-500"><?= esc($category['description'] ?: 'Belum ada deskripsi kategori.') ?></p>

        <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
            <a href="/admin/categories/<?= (int) $category['id'] ?>/edit" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600">
                <i class="ph ph-pencil-simple"></i> Edit
            </a>
            <?php if ($count > 0): ?>
            <button type="button" disabled title="Kategori masih dipakai produk" class="inline-flex flex-1 cursor-not-allowed items-center justify-center gap-1.5 rounded-lg border border-slate-100 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-400">
                <i class="ph ph-lock-simple"></i> Terpakai
            </button>
            <?php else: ?>
            <form action="/admin/categories/<?= (int) $category['id'] ?>/delete" method="post" data-confirm="Hapus kategori ini?" class="flex-1">
                <?= csrf_field() ?>
                <button type="submit" class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-red-300 hover:text-red-600">
                    <i class="ph ph-trash"></i> Hapus
                </button>
            </form>
            <?php endif ?>
        </div>
    </div>
    <?php endforeach ?>
</div>
<?php endif ?>
<?= $this->endSection() ?>
