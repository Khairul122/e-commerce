<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\UploadHelper;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;

class OrderController extends Controller
{
    public function myOrders(): void
    {
        $userId = $this->currentUser()['id'];
        $orders = (new Order())->getByUser($userId);

        $this->view('orders/index', [
            'pageTitle' => 'Pesanan Saya',
            'orders' => $orders,
        ]);
    }

    public function detail(string $code): void
    {
        $userId = $this->currentUser()['id'];
        $orderModel = new Order();
        $order = $orderModel->getByCode($code);

        if (!$order || (int) $order['user_id'] !== (int) $userId) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $orderFull = $orderModel->getWithShipping($order['id']);
        $items = $orderModel->getItems($order['id']);
        $payment = (new Payment())->findByOrder($order['id']);
        $settings = (new Setting())->get();

        $this->view('orders/detail', [
            'pageTitle' => 'Detail Pesanan ' . $order['order_code'],
            'order' => $orderFull,
            'items' => $items,
            'payment' => $payment,
            'settings' => $settings,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function uploadPayment(string $code): void
    {
        $this->verifyCsrf();
        $userId = $this->currentUser()['id'];
        $orderModel = new Order();
        $order = $orderModel->getByCode($code);

        if (!$order || (int) $order['user_id'] !== (int) $userId) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        if (empty($_FILES['proof']) || $_FILES['proof']['error'] === UPLOAD_ERR_NO_FILE) {
            $this->flash('error', 'Silakan pilih file bukti transfer.');
            $this->redirect('/pesanan/' . $code);
        }

        $defaults = UploadHelper::paymentProofDefaults();
        try {
            $filename = UploadHelper::validateAndMove(
                $_FILES['proof'],
                \UPLOAD_PATH . '/payment_proofs',
                $defaults['mimes'],
                $defaults['maxSize'],
                $defaults['exts']
            );
        } catch (\Exception $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/pesanan/' . $code);
        }

        $paymentModel = new Payment();
        $existing = $paymentModel->findByOrder($order['id']);
        if ($existing) {
            $paymentModel->update($existing['id'], [
                'payment_proof' => $filename,
                'amount' => $order['total'],
                'status' => 'pending',
                'verified_by' => null,
                'verified_at' => null,
            ]);
        } else {
            $paymentModel->create([
                'order_id' => $order['id'],
                'payment_proof' => $filename,
                'amount' => $order['total'],
                'status' => 'pending',
            ]);
        }

        $orderModel->updateStatus($order['id'], 'pending');
        $this->flash('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi admin.');
        $this->redirect('/pesanan/' . $code);
    }
}
