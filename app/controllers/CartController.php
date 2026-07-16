<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    private Cart $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    public function index(): void
    {
        $userId = $this->currentUser()['id'];
        $items = $this->cartModel->getItems($userId);
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));

        $this->view('cart/index', [
            'pageTitle' => 'Keranjang Belanja',
            'items' => $items,
            'subtotal' => $subtotal,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function add(): void
    {
        $this->verifyCsrf();
        $userId = $this->currentUser()['id'];
        $productId = (int) $this->input('product_id');
        $quantity = max(1, (int) $this->input('quantity', 1));

        $product = (new Product())->find($productId);
        if (!$product || $product['status'] !== 'active') {
            $this->flash('error', 'Produk tidak tersedia.');
            $this->redirect('/produk');
        }
        if ($quantity > $product['stock']) {
            $this->flash('error', 'Jumlah melebihi stok yang tersedia.');
            $this->redirect('/produk/' . $product['slug']);
        }

        $this->cartModel->addItem($userId, $productId, $quantity);
        $this->flash('success', 'Produk ditambahkan ke keranjang.');
        $this->redirect('/cart');
    }

    public function update(): void
    {
        $this->verifyCsrf();
        $userId = $this->currentUser()['id'];
        $cartItemId = (int) $this->input('cart_item_id');
        $quantity = max(1, (int) $this->input('quantity', 1));

        $this->cartModel->updateItemQty($userId, $cartItemId, $quantity);
        $this->flash('success', 'Keranjang diperbarui.');
        $this->redirect('/cart');
    }

    public function remove(): void
    {
        $this->verifyCsrf();
        $userId = $this->currentUser()['id'];
        $cartItemId = (int) $this->input('cart_item_id');

        $this->cartModel->removeItem($userId, $cartItemId);
        $this->flash('success', 'Produk dihapus dari keranjang.');
        $this->redirect('/cart');
    }
}
