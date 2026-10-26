<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'unit', 'image_url', 'category_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    /**
     * Query dasar katalog dengan nama dan slug kategori.
     */
    public function withCategory()
    {
        return $this->select('products.*, categories.name AS category_name, categories.slug AS category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function catalog(?string $categorySlug = null): array
    {
        $builder = $this->withCategory();

        if ($categorySlug !== null && $categorySlug !== '') {
            $builder->where('categories.slug', $categorySlug);
        }

        return $builder
            ->orderBy('categories.sort_order', 'ASC')
            ->orderBy('products.name', 'ASC')
            ->findAll();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function paginateAdmin(?string $search, ?int $categoryId, int $perPage = 10): array
    {
        $builder = $this->withCategory();

        if ($search !== null && $search !== '') {
            $builder->groupStart()
                ->like('products.name', $search)
                ->orLike('products.description', $search)
                ->orLike('products.unit', $search)
                ->groupEnd();
        }

        if ($categoryId !== null && $categoryId > 0) {
            $builder->where('products.category_id', $categoryId);
        }

        return $builder
            ->orderBy('products.created_at', 'DESC')
            ->orderBy('products.id', 'DESC')
            ->paginate($perPage);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function latest(int $limit = 5): array
    {
        return $this->withCategory()
            ->orderBy('products.created_at', 'DESC')
            ->orderBy('products.id', 'DESC')
            ->findAll($limit);
    }

    public function countInCategory(int $categoryId): int
    {
        return $this->where('category_id', $categoryId)->countAllResults();
    }
}
