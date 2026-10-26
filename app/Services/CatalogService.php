<?php

namespace App\Services;

use App\Libraries\ProductImage;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class CatalogService
{
    protected ProductModel $products;
    protected CategoryModel $categories;
    protected ProductImage $images;

    public function __construct()
    {
        $this->products = new ProductModel();
        $this->categories = new CategoryModel();
        $this->images = new ProductImage();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function categories(): array
    {
        return $this->categories->withProductCounts();
    }

    /**
     * @return array<int, string>
     */
    public function categoryOptions(): array
    {
        $options = [];

        foreach ($this->categories->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->findAll() as $category) {
            $options[(int) $category['id']] = $category['name'];
        }

        return $options;
    }

    public function findCategory(int $id): ?array
    {
        return $this->categories->find($id);
    }

    public function findProduct(int $id): ?array
    {
        return $this->products->find($id);
    }

    /**
     * @return array{items: list<array<string, mixed>>, pager: \CodeIgniter\Pager\Pager}
     */
    public function paginateProducts(?string $search, ?int $categoryId, int $perPage = 10): array
    {
        $items = $this->products->paginateAdmin($search, $categoryId, $perPage);
        $pager = $this->products->pager;
        $pager->only(['q', 'kategori']);

        return ['items' => $items, 'pager' => $pager];
    }

    /**
     * @return array<string, mixed>
     */
    public function productInput(array $post): array
    {
        return [
            'name' => mb_substr(trim((string) ($post['name'] ?? '')), 0, 255),
            'description' => trim((string) ($post['description'] ?? '')),
            'price' => (int) ($post['price'] ?? 0),
            'unit' => mb_substr(trim((string) ($post['unit'] ?? '')), 0, 50),
            'category_id' => (int) ($post['category_id'] ?? 0),
            'image_url' => trim((string) ($post['image_url'] ?? '')) ?: null,
        ];
    }

    /**
     * @return list<string>
     */
    public function validateProduct(array $input): array
    {
        $errors = [];

        if ($input['name'] === '') {
            $errors[] = 'Nama produk wajib diisi.';
        }

        if ($input['price'] <= 0) {
            $errors[] = 'Harga harus lebih besar dari 0.';
        }

        if ($input['category_id'] <= 0 || $this->categories->find($input['category_id']) === null) {
            $errors[] = 'Pilih kategori produk yang valid.';
        }

        if (($input['image_url'] ?? null) !== null && filter_var($input['image_url'], FILTER_VALIDATE_URL) === false) {
            $errors[] = 'URL foto tidak valid.';
        }

        return $errors;
    }

    /**
     * @return array{errors: list<string>, id: int|null}
     */
    public function saveProduct(?int $id, array $input, ?UploadedFile $photo = null): array
    {
        $current = $id !== null ? $this->products->find($id) : null;

        if ($id !== null && $current === null) {
            return ['errors' => ['Produk tidak ditemukan.'], 'id' => null];
        }

        $errors = $this->validateProduct($input);

        if ($errors !== []) {
            return ['errors' => $errors, 'id' => $id];
        }

        $newImage = null;

        if ($photo !== null && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            try {
                $newImage = $this->images->save($photo);
            } catch (RuntimeException $e) {
                return ['errors' => [$e->getMessage()], 'id' => $id];
            }
        }

        if ($newImage !== null) {
            $input['image_url'] = $newImage;
        } elseif (($input['image_url'] ?? null) === null) {
            $input['image_url'] = $current['image_url'] ?? null;
        }

        if ($id === null) {
            $newId = (int) $this->products->insert($input, true);
        } else {
            $this->products->update($id, $input);
            $newId = $id;
        }

        if ($newImage !== null && $current !== null && ($current['image_url'] ?? null) !== $newImage) {
            $this->images->delete($current['image_url'] ?? null);
        }

        return ['errors' => [], 'id' => $newId];
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->products->find($id);

        if ($product === null) {
            return false;
        }

        $this->products->delete($id);
        $this->images->delete($product['image_url'] ?? null);

        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function categoryInput(array $post): array
    {
        $name = mb_substr(trim((string) ($post['name'] ?? '')), 0, 100);
        $slug = trim((string) ($post['slug'] ?? ''));

        return [
            'name' => $name,
            'slug' => $this->slugify($slug !== '' ? $slug : $name),
            'description' => trim((string) ($post['description'] ?? '')),
            'image_url' => trim((string) ($post['image_url'] ?? '')) ?: null,
            'sort_order' => max(0, (int) ($post['sort_order'] ?? 0)),
        ];
    }

    /**
     * @return list<string>
     */
    public function validateCategory(array $input, ?int $ignoreId = null): array
    {
        $errors = [];

        if ($input['name'] === '') {
            $errors[] = 'Nama kategori wajib diisi.';
        }

        if ($input['slug'] === '') {
            $errors[] = 'Slug kategori wajib diisi.';
        } else {
            $existing = $this->categories->where('slug', $input['slug']);

            if ($ignoreId !== null) {
                $existing->where('id !=', $ignoreId);
            }

            if ($existing->first() !== null) {
                $errors[] = 'Slug kategori sudah dipakai.';
            }
        }

        if (($input['image_url'] ?? null) !== null && filter_var($input['image_url'], FILTER_VALIDATE_URL) === false) {
            $errors[] = 'URL gambar kategori tidak valid.';
        }

        return $errors;
    }

    /**
     * @return array{errors: list<string>, id: int|null}
     */
    public function saveCategory(?int $id, array $input): array
    {
        if ($id !== null && $this->categories->find($id) === null) {
            return ['errors' => ['Kategori tidak ditemukan.'], 'id' => null];
        }

        $errors = $this->validateCategory($input, $id);

        if ($errors !== []) {
            return ['errors' => $errors, 'id' => $id];
        }

        if ($id === null) {
            $newId = (int) $this->categories->insert($input, true);
        } else {
            $this->categories->update($id, $input);
            $newId = $id;
        }

        return ['errors' => [], 'id' => $newId];
    }

    /**
     * @return list<string>
     */
    public function deleteCategory(int $id): array
    {
        if ($this->categories->find($id) === null) {
            return ['Kategori tidak ditemukan.'];
        }

        if ($this->categories->productCount($id) > 0) {
            return ['Kategori masih dipakai produk. Pindahkan produk ke kategori lain terlebih dahulu.'];
        }

        $this->categories->delete($id);

        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function stats(): array
    {
        $averagePrice = $this->products->db->table('products')
            ->selectAvg('price', 'average_price')
            ->get()
            ->getRowArray();

        $categories = $this->categories();

        return [
            'total_products' => $this->products->countAllResults(),
            'total_categories' => $this->categories->countAllResults(),
            'uncategorized' => $this->products->where('category_id', null)->countAllResults(),
            'average_price' => (int) round((float) ($averagePrice['average_price'] ?? 0)),
            'top_category' => $categories[0] ?? null,
            'latest_products' => $this->products->latest(5),
        ];
    }

    public function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';

        return trim($value, '-');
    }
}
