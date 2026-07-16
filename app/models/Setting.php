<?php

namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    protected string $table = 'settings';

    public function get(): array
    {
        $rows = $this->all();
        return $rows[0] ?? [
            'site_name' => 'UKM ARC',
            'address' => '',
            'phone' => '',
            'email' => '',
            'whatsapp' => '',
            'about_text' => '',
            'bank_name' => '',
            'bank_account_number' => '',
            'bank_account_name' => '',
        ];
    }
}
