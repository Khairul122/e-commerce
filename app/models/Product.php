<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected string $table = 'products';

    public function getFeatured(int $limit = 8): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE status = 'active' AND is_featured = 1 ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getActive(?int $categoryId = null, ?string $search = null): array
    {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON c.id = p.category_id
                WHERE p.status = 'active'";
        $params = [];

        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        if ($search) {
            $sql .= " AND p.name LIKE ?";
            $params[] = '%' . $search . '%';
        }
        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug
                                     FROM products p JOIN categories c ON c.id = p.category_id
                                     WHERE p.slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getImages(int $productId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function getRelated(int $categoryId, int $excludeId, int $limit = 4): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? AND status = 'active' LIMIT ?");
        $stmt->bindValue(1, $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $excludeId, \PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function decrementStock(int $productId, int $qty): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");
        return $stmt->execute([$qty, $productId, $qty]);
    }

    public function createProduct(array $data): int
    {
        $data['slug'] = $this->uniqueSlug(slugify($data['name']));
        return $this->create($data);
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base;
        $i = 1;
        while ($this->whereFirst(['slug' => $slug])) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }
}
