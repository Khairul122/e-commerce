<?php

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected string $table = 'orders';

    public function generateUniqueCode(): string
    {
        do {
            $code = generateOrderCode();
            $exists = $this->whereFirst(['order_code' => $code]);
        } while ($exists);
        return $code;
    }

    public function createOrderWithItems(int $userId, int $shippingMethodId, string $address, string $notes, array $items, float $shippingCost): array
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $total = $subtotal + $shippingCost;
        $orderCode = $this->generateUniqueCode();

        $this->db->beginTransaction();
        try {
            $orderId = $this->create([
                'order_code' => $orderCode,
                'user_id' => $userId,
                'shipping_method_id' => $shippingMethodId,
                'shipping_address' => $address,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => 'pending',
                'notes' => $notes,
            ]);

            $itemStmt = $this->db->prepare(
                'INSERT INTO order_items (order_id, product_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)'
            );
            $productModel = new Product();

            foreach ($items as $item) {
                $itemStmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity'],
                    $item['price'] * $item['quantity'],
                ]);

                $ok = $productModel->decrementStock($item['product_id'], $item['quantity']);
                if (!$ok) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $item['name']);
                }
            }

            $this->db->commit();
            return ['id' => $orderId, 'order_code' => $orderCode];
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getByCode(string $code): ?array
    {
        return $this->whereFirst(['order_code' => $code]);
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getItems(int $orderId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public function getWithShipping(int $orderId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, sm.name as shipping_name, u.name as customer_name, u.email as customer_email, u.phone as customer_phone
             FROM orders o
             JOIN shipping_methods sm ON sm.id = o.shipping_method_id
             JOIN users u ON u.id = o.user_id
             WHERE o.id = ? LIMIT 1"
        );
        $stmt->execute([$orderId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getAllWithFilter(?string $status = null): array
    {
        $sql = "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON u.id = o.user_id";
        $params = [];
        if ($status) {
            $sql .= " WHERE o.status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->update($orderId, ['status' => $status]);
    }

    public function countToday(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM orders WHERE DATE(created_at) = CURDATE()");
        return (int) $stmt->fetch()['total'];
    }

    public function revenueCompleted(): float
    {
        $stmt = $this->db->query("SELECT COALESCE(SUM(total),0) as total FROM orders WHERE status = 'selesai'");
        return (float) $stmt->fetch()['total'];
    }

    public function weeklyStats(): array
    {
        $stmt = $this->db->query(
            "SELECT DATE(created_at) as day, COUNT(*) as total_orders, COALESCE(SUM(total),0) as total_revenue
             FROM orders
             WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
             GROUP BY DATE(created_at)
             ORDER BY day ASC"
        );
        return $stmt->fetchAll();
    }

    public function getInRange(string $from, string $to): array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON u.id = o.user_id
             WHERE DATE(o.created_at) BETWEEN ? AND ? ORDER BY o.created_at DESC"
        );
        $stmt->execute([$from, $to]);
        return $stmt->fetchAll();
    }
}
