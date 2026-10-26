<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeed extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Sayuran', 'slug' => 'sayuran', 'description' => 'Sayur segar panen harian dari petani lokal.', 'sort_order' => 1],
            ['name' => 'Buah', 'slug' => 'buah', 'description' => 'Buah manis dan segar untuk camilan keluarga.', 'sort_order' => 2],
            ['name' => 'Bumbu & Rempah', 'slug' => 'bumbu-rempah', 'description' => 'Bumbu dapur lengkap untuk masakan rumahan.', 'sort_order' => 3],
            ['name' => 'Sembako', 'slug' => 'sembako', 'description' => 'Kebutuhan pokok untuk stok dapur Anda.', 'sort_order' => 4],
        ];

        foreach ($categories as $category) {
            $existing = $this->db->table('categories')->where('slug', $category['slug'])->get()->getRowArray();

            if ($existing === null) {
                $this->db->table('categories')->insert($category + [
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->table('categories')->where('id', $existing['id'])->update([
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'sort_order' => $category['sort_order'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->mergeLegacyCategories();
    }

    private function mergeLegacyCategories(): void
    {
        $legacyMap = [
            'sayur' => 'sayuran',
            'bumbu' => 'bumbu-rempah',
        ];

        foreach ($legacyMap as $legacySlug => $targetSlug) {
            $legacy = $this->db->table('categories')->where('slug', $legacySlug)->get()->getRowArray();
            $target = $this->db->table('categories')->where('slug', $targetSlug)->get()->getRowArray();

            if ($legacy === null || $target === null) {
                continue;
            }

            $this->db->table('products')->where('category_id', $legacy['id'])->update(['category_id' => $target['id']]);
            $this->db->table('categories')->where('id', $legacy['id'])->delete();
        }
    }
}
