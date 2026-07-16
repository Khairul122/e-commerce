<?php

namespace App\Models;

use App\Core\Model;

class Cart extends Model
{
    protected string $table = 'carts';

    public function getOrCreateCartId(int $userId): int
    {
        $cart = $this->whereFirst(['user_id' => $userId]);
        if ($cart) {
            return (int) $cart['id'];
        }
        return $this->create(['user_id' => $userId]);
    }

    public function getItems(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT ci.id as cart_item_id, ci.quantity, p.id as product_id, p.name, p.slug, p.price, p.stock, p.image
             FROM cart_items ci
             JOIN carts c ON c.id = ci.cart_id
             JOIN products p ON p.id = ci.product_id
             WHERE c.user_id = ?
             ORDER BY ci.id DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function addItem(int $userId, int $productId, int $quantity): void
    {
        $cartId = $this->getOrCreateCartId($userId);

        $stmt = $this->db->prepare('SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?');
        $stmt->execute([$cartId, $productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $this->db->prepare('UPDATE cart_items SET quantity = quantity + ? WHERE id = ?')
                ->execute([$quantity, $existing['id']]);
        } else {
            $this->db->prepare('INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)')
                ->execute([$cartId, $productId, $quantity]);
        }
    }

    public function updateItemQty(int $userId, int $cartItemId, int $quantity): void
    {
        $stmt = $this->db->prepare(
            "UPDATE cart_items ci JOIN carts c ON c.id = ci.cart_id
             SET ci.quantity = ? WHERE ci.id = ? AND c.user_id = ?"
        );
        $stmt->execute([$quantity, $cartItemId, $userId]);
    }

    public function removeItem(int $userId, int $cartItemId): void
    {
        $stmt = $this->db->prepare(
            "DELETE ci FROM cart_items ci JOIN carts c ON c.id = ci.cart_id
             WHERE ci.id = ? AND c.user_id = ?"
        );
        $stmt->execute([$cartItemId, $userId]);
    }

    public function clear(int $userId): void
    {
        $stmt = $this->db->prepare(
            "DELETE ci FROM cart_items ci JOIN carts c ON c.id = ci.cart_id WHERE c.user_id = ?"
        );
        $stmt->execute([$userId]);
    }
}
