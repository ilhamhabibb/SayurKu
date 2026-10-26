<?php

namespace App\Controllers\Admin;

use App\Services\CatalogService;
use CodeIgniter\Controller;

class Categories extends Controller
{
    protected CatalogService $service;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->service = new CatalogService();
    }

    public function index()
    {
        return view('admin/categories/index', [
            'title' => 'Kategori',
            'categories' => $this->service->categories(),
        ]);
    }

    public function create()
    {
        return view('admin/categories/form', [
            'title' => 'Tambah Kategori',
            'action' => '/admin/categories',
            'submitLabel' => 'Simpan Kategori',
            'category' => null,
            'errors' => [],
            'old' => null,
        ]);
    }

    public function store()
    {
        $input = $this->service->categoryInput($this->request->getPost());
        $result = $this->service->saveCategory(null, $input);

        if ($result['errors'] !== []) {
            return view('admin/categories/form', [
                'title' => 'Tambah Kategori',
                'action' => '/admin/categories',
                'submitLabel' => 'Simpan Kategori',
                'category' => null,
                'errors' => $result['errors'],
                'old' => $input,
            ]);
        }

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $category = $this->service->findCategory($id);

        if ($category === null) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('admin/categories/form', [
            'title' => 'Edit Kategori',
            'action' => '/admin/categories/' . $id,
            'submitLabel' => 'Simpan Perubahan',
            'category' => $category,
            'errors' => [],
            'old' => null,
        ]);
    }

    public function update(int $id)
    {
        $input = $this->service->categoryInput($this->request->getPost());
        $result = $this->service->saveCategory($id, $input);

        if ($result['errors'] !== []) {
            return view('admin/categories/form', [
                'title' => 'Edit Kategori',
                'action' => '/admin/categories/' . $id,
                'submitLabel' => 'Simpan Perubahan',
                'category' => $this->service->findCategory($id),
                'errors' => $result['errors'],
                'old' => $input,
            ]);
        }

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $errors = $this->service->deleteCategory($id);

        if ($errors !== []) {
            return redirect()->to('/admin/categories')->with('error', $errors[0]);
        }

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
