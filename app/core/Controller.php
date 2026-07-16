<?php

namespace App\Core;

class Controller
{
    protected function view(string $path, array $data = []): void
    {
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        $data['old'] = $data['old'] ?? $old;

        extract($data);
        $viewFile = APP_PATH . '/views/' . $path . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            die("View tidak ditemukan: {$path}");
        }
        require $viewFile;
    }

    protected function redirect(string $path): void
    {
        $url = str_starts_with($path, 'http') ? $path : BASE_URL . $path;
        header('Location: ' . $url);
        exit;
    }

    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    protected function requireAdmin(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/login');
        }
    }

    protected function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            die('Sesi form tidak valid atau kedaluwarsa. Silakan muat ulang halaman dan coba lagi.');
        }
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function input(string $key, $default = null)
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        if (is_string($value)) {
            $value = trim($value);
        }
        return $value;
    }

    protected function old(string $key, $default = '')
    {
        $value = $_SESSION['old'][$key] ?? $default;
        return $value;
    }

    protected function setOld(array $data): void
    {
        $_SESSION['old'] = $data;
    }

    protected function clearOld(): void
    {
        unset($_SESSION['old']);
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    protected function getFlash(): array
    {
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flash;
    }
}
