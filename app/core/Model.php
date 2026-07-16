<?php

namespace App\Core;

use PDO;

class Model
{
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(string $orderBy = ''): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function where(array $conditions, string $orderBy = ''): array
    {
        $clauses = [];
        $values = [];
        foreach ($conditions as $col => $val) {
            $clauses[] = "{$col} = ?";
            $values[] = $val;
        }
        $sql = "SELECT * FROM {$this->table}";
        if ($clauses) {
            $sql .= ' WHERE ' . implode(' AND ', $clauses);
        }
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    public function whereFirst(array $conditions): ?array
    {
        $rows = $this->where($conditions);
        return $rows[0] ?? null;
    }

    public function create(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        return (int) $this->db->lastInsertId();
    }

    public function update($id, array $data): bool
    {
        $columns = array_keys($data);
        $set = implode(',', array_map(fn($col) => "{$col} = ?", $columns));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $values = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    public function count(array $conditions = []): int
    {
        $clauses = [];
        $values = [];
        foreach ($conditions as $col => $val) {
            $clauses[] = "{$col} = ?";
            $values[] = $val;
        }
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($clauses) {
            $sql .= ' WHERE ' . implode(' AND ', $clauses);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return (int) $stmt->fetch()['total'];
    }
}
