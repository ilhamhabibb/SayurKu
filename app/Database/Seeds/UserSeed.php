<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeed extends Seeder
{
    public function run()
    {
        $username = (string) env('ADMIN_USERNAME', 'admin');
        $password = (string) env('ADMIN_PASSWORD');

        if ($password === '') {
            throw new \RuntimeException('ADMIN_PASSWORD belum diatur di .env');
        }

        $data = [
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $existing = $this->db->table('users')->where('username', $username)->get()->getRowArray();

        if ($existing !== null) {
            $this->db->table('users')->where('id', $existing['id'])->update($data);

            return;
        }

        $this->db->table('users')->insert($data);
    }
}
