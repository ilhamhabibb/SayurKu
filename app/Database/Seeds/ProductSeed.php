<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeed extends Seeder
{
    public function run()
    {
        $data = [
            ['name'=>'Bayam Hijau Organik','description'=>'Segar setiap hari','price'=>5500,'unit'=>'ikatan','image_url'=>'https://placehold.co/400x300/e2e8f0/16a34a?text=Bayam+Hijau','category'=>'Sayur'],
            ['name'=>'Wortel Berastagi','description'=>'Wortel segar premium','price'=>12000,'unit'=>'500 gram','image_url'=>'https://placehold.co/400x300/e2e8f0/16a34a?text=Wortel','category'=>'Sayur'],
            ['name'=>'Tomat Cherry Merah','description'=>'Tomat cherry manis','price'=>15000,'unit'=>'200 gram','image_url'=>'https://placehold.co/400x300/e2e8f0/16a34a?text=Tomat+Cherry','category'=>'Sayur'],
            ['name'=>'Bawang Merah Brebes','description'=>'Bawang merah pilihan','price'=>14500,'unit'=>'250 gram','image_url'=>'https://placehold.co/400x300/e2e8f0/16a34a?text=Bawang+Merah','category'=>'Bumbu'],
        ];
        $this->db->table('products')->insertBatch($data);
    }
}
