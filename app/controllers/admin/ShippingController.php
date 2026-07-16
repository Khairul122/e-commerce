<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ShippingMethod;

class ShippingController extends Controller
{
    private ShippingMethod $shippingModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->shippingModel = new ShippingMethod();
    }

    public function index(): void
    {
        $methods = $this->shippingModel->all('id ASC');
        $this->view('admin/shipping/index', [
            'pageTitle' => 'Metode Pengiriman',
            'methods' => $methods,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $name = $this->input('name');
        $description = $this->input('description');
        $cost = (float) $this->input('cost', 0);

        if (empty($name)) {
            $this->flash('error', 'Nama metode wajib diisi.');
            $this->redirect('/admin/pengiriman');
        }

        $this->shippingModel->create([
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
            'is_active' => 1,
        ]);
        $this->flash('success', 'Metode pengiriman berhasil ditambahkan.');
        $this->redirect('/admin/pengiriman');
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        $name = $this->input('name');
        $description = $this->input('description');
        $cost = (float) $this->input('cost', 0);
        $isActive = $this->input('is_active') ? 1 : 0;

        $this->shippingModel->update($id, [
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
            'is_active' => $isActive,
        ]);
        $this->flash('success', 'Metode pengiriman berhasil diperbarui.');
        $this->redirect('/admin/pengiriman');
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->shippingModel->delete($id);
        $this->flash('success', 'Metode pengiriman berhasil dihapus.');
        $this->redirect('/admin/pengiriman');
    }
}
