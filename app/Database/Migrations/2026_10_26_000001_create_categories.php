<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 120],
            'description' => ['type' => 'TEXT', 'null' => true],
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('categories');

        $this->forge->addColumn('products', [
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'category',
            ],
        ]);

        $this->db->query('CREATE INDEX idx_products_category_id ON products (category_id)');

        $this->backfillExistingCategories();
    }

    public function down()
    {
        $this->db->query('DROP INDEX IF EXISTS idx_products_category_id');
        $this->forge->dropColumn('products', 'category_id');
        $this->forge->dropTable('categories');
    }

    private function backfillExistingCategories(): void
    {
        $rows = $this->db->table('products')
            ->select('category')
            ->where('category IS NOT NULL')
            ->where('category !=', '')
            ->groupBy('category')
            ->get()
            ->getResultArray();

        $order = 1;

        foreach ($rows as $row) {
            $name = trim((string) $row['category']);
            $slug = $this->slugify($name);

            if ($name === '' || $slug === '') {
                continue;
            }

            $existing = $this->db->table('categories')->where('slug', $slug)->get()->getRowArray();

            if ($existing === null) {
                $this->db->table('categories')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => null,
                    'sort_order' => $order++,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $created = $this->db->table('categories')->where('slug', $slug)->get()->getRowArray();
                $id = (int) $created['id'];
            } else {
                $id = (int) $existing['id'];
            }

            $this->db->table('products')
                ->where('category', $name)
                ->update(['category_id' => $id]);
        }
    }

    private function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';

        return trim($value, '-');
    }
}
