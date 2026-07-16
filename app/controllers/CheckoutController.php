<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cart;
use App\Models\ShippingMethod;
use App\Models\Order;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index(): void
    {
        $userId = $this->currentUser()['id'];
        $items = (new Cart())->getItems($userId);

        if (empty($items)) {
            $this->flash('error', 'Keranjang Anda masih kosong.');
            $this->redirect('/cart');
        }

        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
        $shippingMethods = (new ShippingMethod())->getActive();
        $user = (new User())->find($userId);

        $this->view('checkout/index', [
            'pageTitle' => 'Checkout',
            'items' => $items,
            'subtotal' => $subtotal,
            'shippingMethods' => $shippingMethods,
            'user' => $user,
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $userId = $this->currentUser()['id'];

        $shippingMethodId = (int) $this->input('shipping_method_id');
        $address = $this->input('address');
        $notes = $this->input('notes', '');

        if (empty($address)) {
            $this->flash('error', 'Alamat pengiriman wajib diisi.');
            $this->redirect('/checkout');
        }

        $cartModel = new Cart();
        $items = $cartModel->getItems($userId);
        if (empty($items)) {
            $this->flash('error', 'Keranjang Anda masih kosong.');
            $this->redirect('/cart');
        }

        foreach ($items as $item) {
            if ($item['quantity'] > $item['stock']) {
                $this->flash('error', "Stok produk \"{$item['name']}\" tidak mencukupi.");
                $this->redirect('/cart');
            }
        }

        $shippingMethods = (new ShippingMethod())->getActive();
        $shippingCost = 0;
        foreach ($shippingMethods as $sm) {
            if ($sm['id'] == $shippingMethodId) {
                $shippingCost = (float) $sm['cost'];
                break;
            }
        }

        $orderModel = new Order();
        try {
            $result = $orderModel->createOrderWithItems($userId, $shippingMethodId, $address, $notes, $items, $shippingCost);
        } catch (\Throwable $e) {
            error_log('[CHECKOUT ERROR] ' . $e->getMessage());
            $this->flash('error', 'Gagal memproses pesanan. Silakan cek stok dan coba lagi.');
            $this->redirect('/cart');
        }

        $cartModel->clear($userId);
        $this->flash('success', 'Pesanan berhasil dibuat! Kode pesanan: ' . $result['order_code']);
        $this->redirect('/pesanan/' . $result['order_code']);
    }
}
