<?php
namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        return view('home', $data);
    }
}
