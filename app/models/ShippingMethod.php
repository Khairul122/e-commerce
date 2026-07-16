<?php

namespace App\Models;

use App\Core\Model;

class ShippingMethod extends Model
{
    protected string $table = 'shipping_methods';

    public function getActive(): array
    {
        $stmt = $this->db->query("SELECT * FROM shipping_methods WHERE is_active = 1 ORDER BY cost ASC");
        return $stmt->fetchAll();
    }
}
