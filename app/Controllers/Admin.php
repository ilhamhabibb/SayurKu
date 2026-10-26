<?php

namespace App\Controllers;

use App\Libraries\ProductImage;
use App\Models\ProductModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use RuntimeException;

class Admin extends Controller
{
    protected $productModel;
    protected $userModel;
    protected $productImage;

    public function initController(RequestInterface $request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->productImage = new ProductImage();
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $username = trim((string) $this->request->getPost('username'));
            $password = (string) $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)->first();

            if ($user === null || ! password_verify($password, $user['password_hash'])) {
                return view('admin_login', ['error' => 'Username atau password salah.']);
            }

            setcookie('admin_logged_in', '1', time()+3600, '/');
            setcookie('admin_username', $user['username'], time()+3600, '/');

            return redirect()->to('/admin/products');
        }
        return view('admin_login');
    }

    public function products()
    {
        if (!($_COOKIE["admin_logged_in"] ?? false)) return redirect()->to('/admin/login');
        $data['items'] = $this->productModel->findAll();
        return view('admin_products', $data);
    }

    public function add()
    {
        if (!($_COOKIE["admin_logged_in"] ?? false)) return redirect()->to('/admin/login');

        if ($this->request->is('post')) {
            $input  = $this->productInput();
            $errors = $this->productErrors($input);
            $photo  = $errors === [] ? $this->uploadPhoto($errors) : null;

            if ($errors !== []) {
                return view('admin_add', ['errors'=>$errors, 'old'=>$input]);
            }

            $input['image_url'] = $photo ?? $input['image_url'];
            $this->productModel->insert($input);

            return redirect()->to('/admin/products');
        }

        return view('admin_add');
    }

    public function edit($id = null)
    {
        if (!($_COOKIE["admin_logged_in"] ?? false)) return redirect()->to('/admin/login');

        $item = $this->productModel->find($id);
        if ($item === null) return redirect()->to('/admin/products');

        if ($this->request->is('post')) {
            $input  = $this->productInput();
            $errors = $this->productErrors($input);
            $photo  = $errors === [] ? $this->uploadPhoto($errors) : null;

            if ($errors !== []) {
                return view('admin_edit', ['errors'=>$errors, 'old'=>$input, 'item'=>$item]);
            }

            $input['image_url'] = $photo ?? $input['image_url'] ?? ($item['image_url'] ?? null);
            $this->productModel->update($id, $input);

            if (($item['image_url'] ?? null) !== $input['image_url']) {
                $this->productImage->delete($item['image_url']);
            }

            return redirect()->to('/admin/products');
        }

        return view('admin_edit', ['item'=>$item]);
    }

    public function delete($id = null)
    {
        if (!($_COOKIE["admin_logged_in"] ?? false)) return redirect()->to('/admin/login');

        $item = $this->productModel->find($id);
        if ($item === null) return redirect()->to('/admin/products');

        $this->productModel->delete($id);
        $this->productImage->delete($item['image_url']);

        return redirect()->to('/admin/products');
    }

    public function logout()
    {
        setcookie('admin_logged_in', '', time()-3600, '/');
        setcookie('admin_username', '', time()-3600, '/');
        return redirect()->to('/');
    }

    private function productInput(): array
    {
        return [
            'name' => mb_substr(trim((string) $this->request->getPost('name')), 0, 255),
            'description' => trim((string) $this->request->getPost('description')),
            'price' => (int) $this->request->getPost('price'),
            'unit' => mb_substr(trim((string) $this->request->getPost('unit')), 0, 50),
            'category' => mb_substr(trim((string) $this->request->getPost('category')), 0, 50),
            'image_url' => $this->imageUrlInput(),
        ];
    }

    private function productErrors(array $input): array
    {
        $errors = [];

        if ($input['name'] === '') {
            $errors[] = 'Nama produk wajib diisi.';
        }

        if ($input['price'] <= 0) {
            $errors[] = 'Harga harus lebih besar dari 0.';
        }

        if (($input['image_url'] ?? '') !== '' && filter_var($input['image_url'], FILTER_VALIDATE_URL) === false) {
            $errors[] = 'URL foto tidak valid.';
        }

        return $errors;
    }

    private function imageUrlInput(): ?string
    {
        $url = trim((string) $this->request->getPost('image_url'));

        return $url === '' ? null : $url;
    }

    /**
     * Menyimpan foto kalau ada file yang dipilih. Error upload dikumpulkan ke
     * $errors supaya form menampilkan semua masalah sekaligus.
     */
    private function uploadPhoto(array &$errors): ?string
    {
        $file = $this->request->getFile('photo');
        if ($file === null) {
            return null;
        }

        try {
            return $this->productImage->save($file);
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();

            return null;
        }
    }
}