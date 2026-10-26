<?php

echo view('_product_form', [
    'action' => '/admin/add',
    'submitLabel' => 'Tambah',
    'errors' => $errors ?? [],
    'old' => $old ?? null,
    'item' => null,
]);