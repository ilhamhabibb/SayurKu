<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('product_image_url')) {
    /**
     * Menerjemahkan nilai image_url dari database menjadi URL yang bisa dipakai
     * di atribut src: URL eksternal dipakai apa adanya, file upload lokal
     * diprefix dengan base URL, dan kosong memakai placeholder.
     */
    function product_image_url(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return base_url('uploads/placeholder.svg');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return base_url($path);
    }
}
