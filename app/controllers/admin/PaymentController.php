<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    private Payment $paymentModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->paymentModel = new Payment();
    }

    public function index(): void
    {
        $pending = $this->paymentModel->getPendingList();
        $this->view('admin/payments/index', [
            'pageTitle' => 'Verifikasi Pembayaran',
            'payments' => $pending,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function verify(int $id): void
    {
        $this->verifyCsrf();
        try {
            $this->paymentModel->verify($id, $this->currentUser()['id']);
            $this->flash('success', 'Pembayaran berhasil diverifikasi. Status pesanan diperbarui ke "diproses".');
        } catch (\Throwable $e) {
            error_log('[PAYMENT VERIFY ERROR] ' . $e->getMessage());
            $this->flash('error', 'Gagal memverifikasi pembayaran.');
        }
        $this->redirect('/admin/pembayaran');
    }

    public function reject(int $id): void
    {
        $this->verifyCsrf();
        $this->paymentModel->reject($id, $this->currentUser()['id']);
        $this->flash('success', 'Pembayaran ditolak.');
        $this->redirect('/admin/pembayaran');
    }
}
