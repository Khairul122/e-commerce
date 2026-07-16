<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Order;
use App\Models\Payment;

class OrderController extends Controller
{
    private Order $orderModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->orderModel = new Order();
    }

    public function index(): void
    {
        $status = $this->input('status') ?: null;
        $orders = $this->orderModel->getAllWithFilter($status);

        $this->view('admin/orders/index', [
            'pageTitle' => 'Manajemen Pesanan',
            'orders' => $orders,
            'statusFilter' => $status,
            'flash' => $this->getFlash(),
        ]);
    }

    public function detail(int $id): void
    {
        $order = $this->orderModel->getWithShipping($id);
        if (!$order) {
            $this->flash('error', 'Pesanan tidak ditemukan.');
            $this->redirect('/admin/pesanan');
        }
        $items = $this->orderModel->getItems($id);
        $payment = (new Payment())->findByOrder($id);

        $this->view('admin/orders/detail', [
            'pageTitle' => 'Detail Pesanan ' . $order['order_code'],
            'order' => $order,
            'items' => $items,
            'payment' => $payment,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function updateStatus(int $id): void
    {
        $this->verifyCsrf();
        $status = $this->input('status');
        $allowed = ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];

        if (!in_array($status, $allowed, true)) {
            $this->flash('error', 'Status tidak valid.');
            $this->redirect('/admin/pesanan/' . $id);
        }

        $this->orderModel->updateStatus($id, $status);
        $this->flash('success', 'Status pesanan berhasil diperbarui.');
        $this->redirect('/admin/pesanan/' . $id);
    }
}
