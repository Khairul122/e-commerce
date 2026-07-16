<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;
use App\Core\Database;

class CustomerController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->userModel = new User();
    }

    public function index(): void
    {
        $search = $this->input('search', '');
        
        $db = Database::getInstance();
        $sql = "SELECT u.*, 
                       COUNT(o.id) AS total_orders, 
                       COALESCE(SUM(CASE WHEN o.status = 'selesai' THEN o.total ELSE 0 END), 0) AS total_spent 
                FROM users u
                LEFT JOIN orders o ON u.id = o.user_id
                WHERE u.role = 'customer'";
        
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
            $searchVal = "%$search%";
            $params = [$searchVal, $searchVal, $searchVal];
        }
        
        $sql .= " GROUP BY u.id ORDER BY u.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $customers = $stmt->fetchAll();

        $this->view('admin/customers/index', [
            'pageTitle' => 'Manajemen Pembeli',
            'customers' => $customers,
            'search' => $search,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $name = $this->input('name');
        $email = $this->input('email');
        $password = $this->input('password');
        $phone = $this->input('phone');
        $address = $this->input('address');

        if (empty($name) || empty($email) || empty($password)) {
            $this->flash('error', 'Nama, email, dan password wajib diisi.');
            $this->redirect('/admin/pembeli');
        }

        if ($this->userModel->emailExists($email)) {
            $this->flash('error', 'Email sudah terdaftar.');
            $this->redirect('/admin/pembeli');
        }

        $this->userModel->createCustomer($name, $email, $password, $phone, $address);
        $this->flash('success', 'Data pembeli berhasil ditambahkan.');
        $this->redirect('/admin/pembeli');
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        $name = $this->input('name');
        $email = $this->input('email');
        $password = $this->input('password');
        $phone = $this->input('phone');
        $address = $this->input('address');

        if (empty($name) || empty($email)) {
            $this->flash('error', 'Nama dan email wajib diisi.');
            $this->redirect('/admin/pembeli');
        }

        $existing = $this->userModel->findByEmail($email);
        if ($existing && (int)$existing['id'] !== $id) {
            $this->flash('error', 'Email sudah digunakan oleh user lain.');
            $this->redirect('/admin/pembeli');
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        $this->flash('success', 'Data pembeli berhasil diperbarui.');
        $this->redirect('/admin/pembeli');
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        
        $db = Database::getInstance();
        $db->exec('SET FOREIGN_KEY_CHECKS = 0;');
        
        $db->prepare("DELETE ci FROM cart_items ci JOIN carts c ON ci.cart_id = c.id WHERE c.user_id = ?")->execute([$id]);
        $db->prepare("DELETE FROM carts WHERE user_id = ?")->execute([$id]);
        $db->prepare("DELETE oi FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.user_id = ?")->execute([$id]);
        $db->prepare("DELETE FROM orders WHERE user_id = ?")->execute([$id]);
        $this->userModel->delete($id);
        
        $db->exec('SET FOREIGN_KEY_CHECKS = 1;');

        $this->flash('success', 'Data pembeli berhasil dihapus.');
        $this->redirect('/admin/pembeli');
    }
}
