<?php
$path = trim(uri_string(), '/');
$user = session()->get('admin_user');

$navItems = [
    [
        'label' => 'Dashboard',
        'href' => '/admin',
        'icon' => 'ph-squares-four',
        'active' => $path === 'admin',
    ],
    [
        'label' => 'Produk',
        'href' => '/admin/products',
        'icon' => 'ph-package',
        'active' => str_starts_with($path, 'admin/products'),
    ],
    [
        'label' => 'Kategori',
        'href' => '/admin/categories',
        'icon' => 'ph-tag',
        'active' => str_starts_with($path, 'admin/categories'),
    ],
];
?>
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-200 lg:translate-x-0">

    <div class="flex h-16 items-center justify-between border-b border-slate-100 px-6">
        <a href="/admin" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm shadow-emerald-200">
                <i class="ph-fill ph-leaf text-xl"></i>
            </span>
            <span>
                <span class="font-display block text-base font-extrabold leading-tight text-slate-900">SayurSegar</span>
                <span class="block text-[11px] font-medium uppercase tracking-widest text-emerald-600">Admin Panel</span>
            </span>
        </a>
        <button type="button" onclick="toggleSidebar()" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 lg:hidden" aria-label="Tutup menu">
            <i class="ph ph-x text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">
        <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-widest text-slate-400">Menu Utama</p>
        <?php foreach ($navItems as $item): ?>
        <a href="<?= esc($item['href']) ?>"
           class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition <?= $item['active'] ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg <?= $item['active'] ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-200' : 'bg-slate-100 text-slate-500' ?>">
                <i class="ph <?= esc($item['icon']) ?> text-lg"></i>
            </span>
            <?= esc($item['label']) ?>
        </a>
        <?php endforeach ?>

        <p class="px-3 pb-2 pt-6 text-[11px] font-semibold uppercase tracking-widest text-slate-400">Toko</p>
        <a href="/" target="_blank" rel="noopener"
           class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                <i class="ph ph-storefront text-lg"></i>
            </span>
            Lihat Toko
            <i class="ph ph-arrow-up-right ml-auto text-slate-400"></i>
        </a>
    </nav>

    <div class="border-t border-slate-100 p-4">
        <div class="mb-3 flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold text-white">
                <?= esc(strtoupper(substr((string) ($user['username'] ?? 'A'), 0, 1))) ?>
            </span>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900"><?= esc($user['username'] ?? 'Admin') ?></p>
                <p class="text-xs text-slate-500">Administrator</p>
            </div>
        </div>
        <form action="/admin/logout" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                <i class="ph ph-sign-out text-lg"></i>
                Keluar
            </button>
        </form>
    </div>
</aside>
