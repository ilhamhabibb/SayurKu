<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'description', 'image_url', 'sort_order'];
    protected $useTimestamps = true;

    /**
     * @return list<array<string, mixed>>
     */
    public function withProductCounts(): array
    {
        return $this->select('categories.*, COUNT(products.id) AS product_count')
            ->join('products', 'products.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->orderBy('categories.sort_order', 'ASC')
            ->orderBy('categories.name', 'ASC')
            ->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }

    public function productCount(int $id): int
    {
        return $this->db->table('products')->where('category_id', $id)->countAllResults();
    }
}
