<?php

use App\Libraries\ProductImage;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class ProductImageTest extends CIUnitTestCase
{
    public function testEmptyPathUsesPlaceholder(): void
    {
        $this->assertSame(base_url('uploads/placeholder.svg'), product_image_url(null));
        $this->assertSame(base_url('uploads/placeholder.svg'), product_image_url(''));
    }

    public function testExternalUrlIsUsedAsIs(): void
    {
        $url = 'https://contoh.com/foto.jpg';

        $this->assertSame($url, product_image_url($url));
    }

    public function testLocalUploadPathGetsBaseUrl(): void
    {
        $this->assertSame(base_url('uploads/20261015/abc123.jpg'), product_image_url('uploads/20261015/abc123.jpg'));
    }

    public function testDeleteIgnoresExternalUrl(): void
    {
        $image = new ProductImage();
        $image->delete('https://contoh.com/foto.jpg');

        $this->assertTrue(true, 'tidak melempar exception');
    }

    public function testDeleteRefusesPathOutsideUploadsFolder(): void
    {
        $outside = WRITEPATH . 'unit-test-outside.txt';
        file_put_contents($outside, 'dummy');

        (new ProductImage())->delete('../writable/unit-test-outside.txt');

        $this->assertFileExists($outside, 'file di luar folder uploads tidak boleh terhapus');

        unlink($outside);
    }

    public function testDeleteRemovesFileInsideUploadsFolder(): void
    {
        $folder = FCPATH . 'uploads/' . date('Ymd');
        if (! is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = $folder . '/unit-test-temporary.jpg';
        file_put_contents($file, 'dummy');

        (new ProductImage())->delete('uploads/' . date('Ymd') . '/unit-test-temporary.jpg');

        $this->assertFileDoesNotExist($file);
    }
}