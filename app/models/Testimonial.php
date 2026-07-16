<?php

namespace App\Models;

use App\Core\Model;

class Testimonial extends Model
{
    protected string $table = 'testimonials';

    public function getShown(): array
    {
        $stmt = $this->db->query("SELECT * FROM testimonials WHERE is_shown = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}
