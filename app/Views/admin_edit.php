<?php

echo view('_product_form', [
    'action' => '/admin/edit/' . $item['id'],
    'submitLabel' => 'Edit',
    'errors' => $errors ?? [],
    'old' => $old ?? null,
    'item' => $item,
]);