<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeed extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'username'=>'admin',
            'password_hash'=>password_hash('admin123',PASSWORD_DEFAULT),
        ]);
    }
}
