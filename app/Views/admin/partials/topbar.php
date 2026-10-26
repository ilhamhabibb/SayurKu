<?php $user = session()->get('admin_user'); ?>
<header class="sticky top-0 z-20 border-b border-slate-200 bg-slate-100/90 backdrop-blur">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button type="button" onclick="toggleSidebar()" class="rounded-xl border border-slate-200 bg-white p-2 text-slate-600 shadow-sm hover:text-emerald-600 lg:hidden" aria-label="Buka menu">
                <i class="ph ph-list text-xl"></i>
            </button>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-widest text-slate-400">Admin / <?= esc($title ?? 'Dashboard') ?></p>
                <h1 class="font-display text-lg font-bold leading-tight text-slate-900"><?= esc($title ?? 'Dashboard') ?></h1>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="hidden items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 sm:flex">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Toko aktif
            </span>
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-xs font-bold text-white">
                <?= esc(strtoupper(substr((string) ($user['username'] ?? 'A'), 0, 1))) ?>
            </span>
        </div>
    </div>
</header>
