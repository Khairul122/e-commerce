<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected string $table = 'categories';

    public function findBySlug(string $slug): ?array
    {
        return $this->whereFirst(['slug' => $slug]);
    }

    public function createCategory(string $name, string $icon = ''): int
    {
        return $this->create([
            'name' => $name,
            'slug' => $this->uniqueSlug(slugify($name)),
            'icon' => $icon,
        ]);
    }

    public function updateCategory(int $id, string $name, string $icon = ''): bool
    {
        return $this->update($id, [
            'name' => $name,
            'icon' => $icon,
        ]);
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base;
        $i = 1;
        while ($this->findBySlug($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }
}
