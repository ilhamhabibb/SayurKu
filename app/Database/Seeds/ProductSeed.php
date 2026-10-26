<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeed extends Seeder
{
    public function run()
    {
        $categories = [];
        foreach ($this->db->table('categories')->get()->getResultArray() as $category) {
            $categories[$category['slug']] = (int) $category['id'];
        }

        $products = [
            ['name' => 'Bayam Hijau Organik', 'description' => 'Daun bayam muda yang segar, cocok untuk sayur bening.', 'price' => 5500, 'unit' => 'ikatan', 'category' => 'sayuran', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Wortel Berastagi', 'description' => 'Wortel manis dengan warna oranye cerah.', 'price' => 12000, 'unit' => '500 gram', 'category' => 'sayuran', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Tomat Cherry Merah', 'description' => 'Tomat cherry manis, pas untuk salad dan camilan.', 'price' => 15000, 'unit' => '200 gram', 'category' => 'sayuran', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Brokoli Organik', 'description' => 'Brokoli hijau padat dengan kuntum rapat.', 'price' => 9800, 'unit' => '250 gram', 'category' => 'sayuran', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Kangkung Segar', 'description' => 'Kangkung darat segar siap tumis.', 'price' => 4000, 'unit' => 'ikatan', 'category' => 'sayuran', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Sawi Hijau', 'description' => 'Sawi hijau renyah untuk tumis dan sup.', 'price' => 5000, 'unit' => 'ikatan', 'category' => 'sayuran', 'image_url' => 'uploads/placeholder.svg'],

            ['name' => 'Apel Fuji', 'description' => 'Apel Fuji renyah dengan rasa manis segar.', 'price' => 28000, 'unit' => '500 gram', 'category' => 'buah', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Pisang Cavendish', 'description' => 'Pisang manis lembut, cocok untuk sarapan.', 'price' => 18000, 'unit' => 'sisir', 'category' => 'buah', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Jeruk Baby Pacitan', 'description' => 'Jeruk baby manis dengan kulit tipis.', 'price' => 22000, 'unit' => '500 gram', 'category' => 'buah', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Semangka Merah', 'description' => 'Semangka manis dengan daging merah segar.', 'price' => 25000, 'unit' => 'buah', 'category' => 'buah', 'image_url' => 'uploads/placeholder.svg'],

            ['name' => 'Bawang Merah Brebes', 'description' => 'Bawang merah pilihan dengan aroma kuat.', 'price' => 14500, 'unit' => '250 gram', 'category' => 'bumbu-rempah', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Bawang Putih Kating', 'description' => 'Bawang putih kating bersih dan mudah dikupas.', 'price' => 13000, 'unit' => '250 gram', 'category' => 'bumbu-rempah', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Cabai Rawit Merah', 'description' => 'Cabai rawit pedas segar untuk sambal.', 'price' => 9000, 'unit' => '100 gram', 'category' => 'bumbu-rempah', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Jahe Emprit', 'description' => 'Jahe emprit harum untuk masakan dan wedang.', 'price' => 6000, 'unit' => '100 gram', 'category' => 'bumbu-rempah', 'image_url' => 'uploads/placeholder.svg'],

            ['name' => 'Beras Pandan Wangi', 'description' => 'Beras pandan wangi pulen untuk kebutuhan harian.', 'price' => 75000, 'unit' => '5 kg', 'category' => 'sembako', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Telur Ayam Negeri', 'description' => 'Telur ayam negeri segar per tray.', 'price' => 32000, 'unit' => '1 tray', 'category' => 'sembako', 'image_url' => 'uploads/placeholder.svg'],
            ['name' => 'Minyak Goreng Sawit', 'description' => 'Minyak goreng kemasan 2 liter.', 'price' => 38000, 'unit' => '2 liter', 'category' => 'sembako', 'image_url' => 'uploads/placeholder.svg'],
        ];

        foreach ($products as $product) {
            $slug = $product['category'];
            unset($product['category']);
            $product['category_id'] = $categories[$slug] ?? null;

            if (str_starts_with((string) ($product['image_url'] ?? ''), 'http://') || str_starts_with((string) ($product['image_url'] ?? ''), 'https://')) {
                $product['image_url'] = 'uploads/placeholder.svg';
            }

            $existing = $this->db->table('products')->where('name', $product['name'])->get()->getRowArray();

            if ($existing === null) {
                $this->db->table('products')->insert($product + [
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $update = [
                    'category_id' => $product['category_id'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                if (str_starts_with((string) ($existing['image_url'] ?? ''), 'http://') || str_starts_with((string) ($existing['image_url'] ?? ''), 'https://')) {
                    $update['image_url'] = 'uploads/placeholder.svg';
                }

                $this->db->table('products')->where('id', $existing['id'])->update($update);
            }
        }
    }
}
