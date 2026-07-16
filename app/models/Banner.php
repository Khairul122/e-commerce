<?php

namespace App\Models;

use App\Core\Model;

class Banner extends Model
{
    protected string $table = 'banners';

    public function getActive(): array
    {
        $stmt = $this->db->query("SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}
