<?php

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function rupiah($number): string
{
    return 'Rp' . number_format((float) $number, 0, ',', '.');
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function generateOrderCode(): string
{
    return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
}

function isValidEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function uploadUrl(string $type, ?string $filename): string
{
    if (empty($filename) || $filename === 'placeholder-banner.jpg') {
        return BASE_URL . '/assets/images/placeholder.svg';
    }
    return BASE_URL . '/uploads.php?type=' . urlencode($type) . '&file=' . urlencode($filename);
}
