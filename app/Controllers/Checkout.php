<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Checkout extends Controller
{
    public function send()
    {
        $name = mb_substr(trim((string) $this->request->getPost('name')), 0, 100);
        $address = mb_substr(trim((string) $this->request->getPost('address')), 0, 300);
        $items = mb_substr(trim((string) $this->request->getPost('items')), 0, 1000);
        $total = (int) $this->request->getPost('total');
        $phone = preg_replace('/\D+/', '', (string) env('WA_NUMBER', '628123456789')) ?: '628123456789';
        $text = "SayurSegar Order\nNama: {$name}\nAlamat: {$address}\nBarang: {$items}\nTotal: Rp " . number_format($total, 0, ',', '.');
        $url = "https://wa.me/{$phone}?text=" . urlencode($text);

        return redirect()->to($url);
    }
}
