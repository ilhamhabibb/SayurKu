<?php

namespace App\Controllers\Admin;

use App\Services\CatalogService;
use CodeIgniter\Controller;

class Products extends Controller
{
    protected CatalogService $service;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->service = new CatalogService();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));
        $categoryId = (int) $this->request->getGet('kategori');
        $result = $this->service->paginateProducts($search, $categoryId);

        return view('admin/products/index', [
            'title' => 'Produk',
            'products' => $result['items'],
            'categories' => $this->service->categories(),
            'search' => $search,
            'categoryId' => $categoryId,
            'pager' => $result['pager'],
        ]);
    }

    public function create()
    {
        return view('admin/products/form', [
            'title' => 'Tambah Produk',
            'action' => '/admin/products',
            'submitLabel' => 'Simpan Produk',
            'product' => null,
            'categories' => $this->service->categoryOptions(),
            'errors' => [],
            'old' => null,
        ]);
    }

    public function store()
    {
        $input = $this->service->productInput($this->request->getPost());
        $result = $this->service->saveProduct(null, $input, $this->request->getFile('photo'));

        if ($result['errors'] !== []) {
            return view('admin/products/form', [
                'title' => 'Tambah Produk',
                'action' => '/admin/products',
                'submitLabel' => 'Simpan Produk',
                'product' => null,
                'categories' => $this->service->categoryOptions(),
                'errors' => $result['errors'],
                'old' => $input,
            ]);
        }

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product = $this->service->findProduct($id);

        if ($product === null) {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }

        return view('admin/products/form', [
            'title' => 'Edit Produk',
            'action' => '/admin/products/' . $id,
            'submitLabel' => 'Simpan Perubahan',
            'product' => $product,
            'categories' => $this->service->categoryOptions(),
            'errors' => [],
            'old' => null,
        ]);
    }

    public function update(int $id)
    {
        $input = $this->service->productInput($this->request->getPost());
        $result = $this->service->saveProduct($id, $input, $this->request->getFile('photo'));

        if ($result['errors'] !== []) {
            return view('admin/products/form', [
                'title' => 'Edit Produk',
                'action' => '/admin/products/' . $id,
                'submitLabel' => 'Simpan Perubahan',
                'product' => $this->service->findProduct($id),
                'categories' => $this->service->categoryOptions(),
                'errors' => $result['errors'],
                'old' => $input,
            ]);
        }

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if (! $this->service->deleteProduct($id)) {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
    }
}
