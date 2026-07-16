<?php

namespace App\Core;

class UploadHelper
{
    /**
     * Validasi dan pindahkan file upload ke folder tujuan.
     * Mengembalikan nama file baru (unik) jika berhasil, atau melempar Exception dengan pesan yang aman ditampilkan ke user.
     */
    public static function validateAndMove(array $file, string $destDir, array $allowedMimes, int $maxSizeBytes, array $allowedExts): string
    {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Gagal mengunggah file. Silakan coba lagi.');
        }

        if ($file['size'] > $maxSizeBytes) {
            $maxMb = round($maxSizeBytes / 1024 / 1024, 1);
            throw new \Exception("Ukuran file melebihi batas maksimum {$maxMb}MB.");
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts, true)) {
            throw new \Exception('Tipe file tidak diizinkan. Ekstensi yang diperbolehkan: ' . implode(', ', $allowedExts));
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedMimes, true)) {
            throw new \Exception('Jenis file tidak valid.');
        }

        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $newName = uniqid('f_', true) . '.' . $ext;
        $destPath = rtrim($destDir, '/') . '/' . $newName;

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            throw new \Exception('Gagal menyimpan file yang diunggah.');
        }

        return $newName;
    }

    public static function imageDefaults(): array
    {
        return [
            'mimes' => ['image/jpeg', 'image/png', 'image/webp'],
            'exts' => ['jpg', 'jpeg', 'png', 'webp'],
            'maxSize' => 2 * 1024 * 1024,
        ];
    }

    public static function paymentProofDefaults(): array
    {
        return [
            'mimes' => ['image/jpeg', 'image/png', 'application/pdf'],
            'exts' => ['jpg', 'jpeg', 'png', 'pdf'],
            'maxSize' => 2 * 1024 * 1024,
        ];
    }
}
