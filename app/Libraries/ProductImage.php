<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class ProductImage
{
    public const FOLDER = 'uploads';

    public const MAX_SIZE = 2097152;

    private const ALLOWED_MIME = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    /**
     * Menyimpan file upload ke public/uploads/YYYYMMDD dengan nama acak.
     * Extension diambil dari mime hasil finfo, bukan dari nama file kiriman.
     *
     * @return string path relatif, mis. uploads/20261015/ab12....jpg
     *
     * @throws RuntimeException
     */
    public function save(UploadedFile $file): string
    {
        if (! $file->isValid()) {
            throw new RuntimeException('Upload foto gagal. Pastikan file tidak melebihi batas ukuran server.');
        }

        $extension = self::ALLOWED_MIME[$file->getMimeType()] ?? null;

        if ($extension === null) {
            throw new RuntimeException('Format foto harus JPG, PNG, atau WEBP.');
        }

        if ($file->getSize() > self::MAX_SIZE) {
            throw new RuntimeException('Ukuran foto maksimal 2MB.');
        }

        $folder = self::FOLDER . '/' . date('Ymd');
        $name   = bin2hex(random_bytes(16)) . '.' . $extension;

        $file->move(FCPATH . $folder, $name);

        return $folder . '/' . $name;
    }

    /**
     * Menghapus file foto lama. Path dari URL eksternal atau path di luar
     * folder uploads diabaikan supaya tidak bisa dipakai menghapus file lain.
     */
    public function delete(?string $relativePath): void
    {
        if ($relativePath === null || $relativePath === '') {
            return;
        }

        $base = realpath(FCPATH . self::FOLDER);
        $full = realpath(FCPATH . $relativePath);

        if ($base === false || $full === false || ! str_starts_with($full, $base . DIRECTORY_SEPARATOR)) {
            return;
        }

        if (is_file($full)) {
            unlink($full);
        }
    }
}