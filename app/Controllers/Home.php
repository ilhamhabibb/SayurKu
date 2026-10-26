<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $categories = $categoryModel->withProductCounts();
        $requestedSlug = trim((string) $this->request->getGet('kategori'));
        $activeCategory = null;

        if ($requestedSlug !== '') {
            $activeCategory = $categoryModel->findBySlug($requestedSlug);
        }

        $activeSlug = $activeCategory['slug'] ?? null;
        $products = $productModel->catalog($activeSlug);
        $catalogProducts = $activeSlug === null ? $products : $productModel->catalog();

        $cartProducts = [];
        foreach ($catalogProducts as $product) {
            $cartProducts[(int) $product['id']] = [
                'name' => $product['name'],
                'price' => (int) $product['price'],
            ];
        }

        return view('home', [
            'categories' => $categories,
            'products' => $products,
            'cartProducts' => $cartProducts,
            'activeCategory' => $activeCategory,
            'activeSlug' => $activeSlug,
        ]);
    }
}
