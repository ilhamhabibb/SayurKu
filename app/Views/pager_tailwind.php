<?php

use CodeIgniter\Pager\PagerRenderer;

/** @var PagerRenderer $pager */
$pager->setSurroundCount(1);
?>
<?php if ($pager->getPageCount() > 1): ?>
<nav class="mt-6 flex flex-col items-center justify-between gap-3 border-t border-slate-100 pt-5 sm:flex-row" aria-label="Navigasi halaman">
    <p class="text-sm text-slate-500">
        Halaman <span class="font-semibold text-slate-700"><?= $pager->getCurrentPageNumber() ?></span>
        dari <span class="font-semibold text-slate-700"><?= $pager->getPageCount() ?></span>
    </p>

    <div class="flex items-center gap-1">
        <?php if ($pager->hasPrevious()): ?>
        <a href="<?= $pager->getPrevious() ?>" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-300 hover:text-emerald-600" aria-label="Sebelumnya">
            <i class="ph ph-caret-left"></i>
        </a>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <?php if ($link['active']): ?>
            <span class="flex h-9 min-w-9 items-center justify-center rounded-lg bg-emerald-600 px-3 text-sm font-bold text-white"><?= (int) $link['title'] ?></span>
            <?php else: ?>
            <a href="<?= esc($link['uri']) ?>" class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-slate-200 px-3 text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:text-emerald-600"><?= (int) $link['title'] ?></a>
            <?php endif ?>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
        <a href="<?= $pager->getNext() ?>" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-300 hover:text-emerald-600" aria-label="Berikutnya">
            <i class="ph ph-caret-right"></i>
        </a>
        <?php endif ?>
    </div>
</nav>
<?php endif ?>
