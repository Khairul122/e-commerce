<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showRegister(): void
    {
        if ($this->currentUser()) {
            $this->redirect('/');
        }
        $this->view('auth/register', [
            'csrf' => $this->csrfToken(),
            'errors' => $_SESSION['errors'] ?? [],
        ]);
        unset($_SESSION['errors']);
    }

    public function register(): void
    {
        $this->verifyCsrf();

        $name = $this->input('name');
        $email = $this->input('email');
        $phone = $this->input('phone');
        $password = $this->input('password');
        $confirmPassword = $this->input('confirm_password');

        $errors = [];
        if (empty($name)) {
            $errors[] = 'Nama wajib diisi.';
        }
        if (empty($email) || !isValidEmail($email)) {
            $errors[] = 'Email tidak valid.';
        } elseif ($this->userModel->emailExists($email)) {
            $errors[] = 'Email sudah terdaftar. Silakan login.';
        }
        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Konfirmasi password tidak cocok.';
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $this->setOld(['name' => $name, 'email' => $email, 'phone' => $phone]);
            $this->redirect('/register');
        }

        $this->userModel->createCustomer($name, $email, $password, $phone);
        $this->clearOld();
        $this->flash('success', 'Registrasi berhasil! Silakan login.');
        $this->redirect('/login');
    }

    public function showLogin(): void
    {
        if ($this->currentUser()) {
            $this->redirect('/');
        }
        $this->view('auth/login', [
            'csrf' => $this->csrfToken(),
            'errors' => $_SESSION['errors'] ?? [],
            'flash' => $this->getFlash(),
        ]);
        unset($_SESSION['errors']);
    }

    public function login(): void
    {
        $this->verifyCsrf();

        $email = $this->input('email');
        $password = $this->input('password');

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $_SESSION['errors'] = ['Email atau password salah.'];
            $this->setOld(['email' => $email]);
            $this->redirect('/login');
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        $this->clearOld();

        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard');
        }

        $this->redirect('/');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
        $this->redirect('/login');
    }

    public function showProfile(): void
    {
        $this->requireLogin();
        $user = $this->userModel->find($this->currentUser()['id']);
        $this->view('auth/profile', [
            'user' => $user,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function updateProfile(): void
    {
        $this->requireLogin();
        $this->verifyCsrf();

        $name = $this->input('name');
        $phone = $this->input('phone');
        $address = $this->input('address');

        if (empty($name)) {
            $this->flash('error', 'Nama wajib diisi.');
            $this->redirect('/profile');
        }

        $userId = $this->currentUser()['id'];
        $this->userModel->update($userId, [
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
        ]);

        $_SESSION['user']['name'] = $name;
        $this->flash('success', 'Profil berhasil diperbarui.');
        $this->redirect('/profile');
    }

    public function submitTestimonial(): void
    {
        $this->requireLogin();
        $this->verifyCsrf();

        $message = $this->input('message');
        $rating = (int) $this->input('rating', 5);

        if (empty($message)) {
            $this->flash('error', 'Pesan testimoni tidak boleh kosong.');
            $this->redirect('/profile');
        }

        if ($rating < 1 || $rating > 5) {
            $rating = 5;
        }

        $user = $this->userModel->find($this->currentUser()['id']);

        $testimonialModel = new \App\Models\Testimonial();
        $testimonialModel->create([
            'customer_name' => $user['name'],
            'message' => $message,
            'rating' => $rating,
            'photo' => $user['photo'] ?? null,
            'is_shown' => 1
        ]);

        $this->flash('success', 'Testimoni Anda berhasil dikirim dan ditampilkan di beranda! Terima kasih.');
        $this->redirect('/profile');
    }
}
