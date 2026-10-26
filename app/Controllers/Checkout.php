<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Checkout extends Controller
{
    public function send()
    {
        $name = $this->request->getPost('name');
        $address = $this->request->getPost('address');
        $items = $this->request->getPost('items');
        $total = $this->request->getPost('total');
        $phone = env('WA_NUMBER', '628123456789');
        $text = "SayurSegar Order\nNama: $name\nAlamat: $address\nBarang: $items\nTotal: Rp $total";
        $url = "https://wa.me/$phone?text=" . urlencode($text);
        return redirect()->to($url);
    }
}
