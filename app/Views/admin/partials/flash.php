<?php $success = session()->getFlashdata('success'); ?>
<?php $error = session()->getFlashdata('error'); ?>

<?php if ($success): ?>
<div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
    <i class="ph-fill ph-check-circle mt-0.5 text-lg text-emerald-600"></i>
    <p class="font-medium"><?= esc($success) ?></p>
</div>
<?php endif ?>

<?php if ($error): ?>
<div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
    <i class="ph-fill ph-warning-circle mt-0.5 text-lg text-red-500"></i>
    <p class="font-medium"><?= esc($error) ?></p>
</div>
<?php endif ?>
