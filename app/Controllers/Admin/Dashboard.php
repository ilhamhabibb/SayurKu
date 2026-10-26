<?php

namespace App\Controllers\Admin;

use App\Services\CatalogService;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $service = new CatalogService();
        $categories = $service->categories();

        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'stats' => $service->stats(),
            'categories' => $categories,
        ]);
    }
}
