<?php helper('form'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc(($title ?? 'Admin') . ' - SayurSegar') ?></title>
<link rel="stylesheet" href="/assets/css/app.css">
<link rel="stylesheet" href="/assets/fonts/fonts.css">
<link rel="stylesheet" href="/assets/phosphor/regular/style.css">
<link rel="stylesheet" href="/assets/phosphor/fill/style.css">
<style>
    body { font-family: 'Inter', sans-serif; }
    .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden" onclick="toggleSidebar()"></div>

<?= $this->include('admin/partials/sidebar') ?>

<div class="min-h-screen lg:pl-72">
    <?= $this->include('admin/partials/topbar') ?>

    <main class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <?= $this->include('admin/partials/flash') ?>
        <?= $this->renderSection('content') ?>
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.toggle('hidden');
}

document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});
</script>
</body>
</html>
