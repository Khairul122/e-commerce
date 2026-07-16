<?php

namespace App\Models;

use App\Core\Model;

class Payment extends Model
{
    protected string $table = 'payments';

    public function findByOrder(int $orderId): ?array
    {
        return $this->whereFirst(['order_id' => $orderId]);
    }

    public function getPendingList(): array
    {
        $stmt = $this->db->query(
            "SELECT p.*, o.order_code, o.total, u.name as customer_name
             FROM payments p
             JOIN orders o ON o.id = p.order_id
             JOIN users u ON u.id = o.user_id
             WHERE p.status = 'pending'
             ORDER BY p.created_at ASC"
        );
        return $stmt->fetchAll();
    }

    public function verify(int $paymentId, int $adminId): bool
    {
        $payment = $this->find($paymentId);
        if (!$payment) {
            return false;
        }
        $this->db->beginTransaction();
        try {
            $this->update($paymentId, [
                'status' => 'verified',
                'verified_by' => $adminId,
                'verified_at' => date('Y-m-d H:i:s'),
            ]);
            (new Order())->updateStatus($payment['order_id'], 'diproses');
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function reject(int $paymentId, int $adminId): bool
    {
        return $this->update($paymentId, [
            'status' => 'rejected',
            'verified_by' => $adminId,
            'verified_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
