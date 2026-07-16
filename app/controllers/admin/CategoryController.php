<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private Category $categoryModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        $categories = $this->categoryModel->all('name ASC');
        $this->view('admin/categories/index', [
            'pageTitle' => 'Manajemen Kategori',
            'categories' => $categories,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $name = $this->input('name');
        $icon = $this->input('icon', 'utensils');

        if (empty($name)) {
            $this->flash('error', 'Nama kategori wajib diisi.');
            $this->redirect('/admin/kategori');
        }

        $this->categoryModel->createCategory($name, $icon);
        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('/admin/kategori');
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        $name = $this->input('name');
        $icon = $this->input('icon', 'utensils');

        if (empty($name)) {
            $this->flash('error', 'Nama kategori wajib diisi.');
            $this->redirect('/admin/kategori');
        }

        $this->categoryModel->updateCategory($id, $name, $icon);
        $this->flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('/admin/kategori');
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->categoryModel->delete($id);
        $this->flash('success', 'Kategori berhasil dihapus.');
        $this->redirect('/admin/kategori');
    }
}
