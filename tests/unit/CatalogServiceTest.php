<?php

use App\Services\CatalogService;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class CatalogServiceTest extends CIUnitTestCase
{
    public function testSlugifyCreatesUrlSafeSlug(): void
    {
        $service = new CatalogService();

        $this->assertSame('bumbu-rempah', $service->slugify('Bumbu & Rempah'));
        $this->assertSame('sayuran', $service->slugify('  Sayuran  '));
        $this->assertSame('buah-lokal', $service->slugify('Buah Lokal!'));
    }

    public function testProductInputTrimsAndCastsValues(): void
    {
        $service = new CatalogService();
        $input = $service->productInput([
            'name' => '  Bayam  ',
            'description' => '  Segar  ',
            'price' => '5500',
            'unit' => ' ikatan ',
            'category_id' => '3',
            'image_url' => '  ',
        ]);

        $this->assertSame('Bayam', $input['name']);
        $this->assertSame('Segar', $input['description']);
        $this->assertSame(5500, $input['price']);
        $this->assertSame('ikatan', $input['unit']);
        $this->assertSame(3, $input['category_id']);
        $this->assertNull($input['image_url']);
    }

    public function testCategoryInputDerivesSlugFromName(): void
    {
        $service = new CatalogService();
        $input = $service->categoryInput([
            'name' => 'Bumbu & Rempah',
            'slug' => '',
            'sort_order' => '-5',
        ]);

        $this->assertSame('bumbu-rempah', $input['slug']);
        $this->assertSame(0, $input['sort_order']);
    }
}
