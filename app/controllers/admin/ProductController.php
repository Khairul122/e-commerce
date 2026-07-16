<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\UploadHelper;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    private Product $productModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $search = $this->input('search');
        $products = $search
            ? $this->productModel->getActive(null, $search)
            : $this->allWithCategory();

        $this->view('admin/products/index', [
            'pageTitle' => 'Manajemen Produk',
            'products' => $products,
            'search' => $search,
            'flash' => $this->getFlash(),
            'csrf' => $this->csrfToken(),
        ]);
    }

    private function allWithCategory(): array
    {
        // Query manual (bukan lewat model) supaya produk inactive tetap tampil di panel admin
        $db = \App\Core\Database::getInstance();
        $stmt = $db->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON c.id = p.category_id ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }

    public function create(): void
    {
        $categories = (new Category())->all('name ASC');
        $this->view('admin/products/form', [
            'pageTitle' => 'Tambah Produk',
            'categories' => $categories,
            'product' => null,
            'csrf' => $this->csrfToken(),
            'errors' => $_SESSION['errors'] ?? [],
        ]);
        unset($_SESSION['errors']);
    }

    public function store(): void
    {
        $this->verifyCsrf();

        $name = $this->input('name');
        $categoryId = (int) $this->input('category_id');
        $description = $this->input('description');
        $price = (float) $this->input('price');
        $stock = (int) $this->input('stock', 0);
        $isFeatured = $this->input('is_featured') ? 1 : 0;

        $errors = [];
        if (empty($name)) $errors[] = 'Nama produk wajib diisi.';
        if ($categoryId <= 0) $errors[] = 'Kategori wajib dipilih.';
        if ($price <= 0) $errors[] = 'Harga harus lebih dari 0.';

        $imageName = null;
        if (!empty($_FILES['image']['name'])) {
            try {
                $defaults = UploadHelper::imageDefaults();
                $imageName = UploadHelper::validateAndMove(
                    $_FILES['image'],
                    \UPLOAD_PATH . '/products',
                    $defaults['mimes'],
                    $defaults['maxSize'],
                    $defaults['exts']
                );
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/admin/produk/tambah');
        }

        $this->productModel->createProduct([
            'category_id' => $categoryId,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'image' => $imageName,
            'is_featured' => $isFeatured,
            'status' => 'active',
        ]);

        $this->flash('success', 'Produk berhasil ditambahkan.');
        $this->redirect('/admin/produk');
    }

    public function edit(int $id): void
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            $this->flash('error', 'Produk tidak ditemukan.');
            $this->redirect('/admin/produk');
        }
        $categories = (new Category())->all('name ASC');

        $this->view('admin/products/form', [
            'pageTitle' => 'Edit Produk',
            'categories' => $categories,
            'product' => $product,
            'csrf' => $this->csrfToken(),
            'errors' => $_SESSION['errors'] ?? [],
        ]);
        unset($_SESSION['errors']);
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        $product = $this->productModel->find($id);
        if (!$product) {
            $this->flash('error', 'Produk tidak ditemukan.');
            $this->redirect('/admin/produk');
        }

        $name = $this->input('name');
        $categoryId = (int) $this->input('category_id');
        $description = $this->input('description');
        $price = (float) $this->input('price');
        $stock = (int) $this->input('stock', 0);
        $isFeatured = $this->input('is_featured') ? 1 : 0;
        $status = $this->input('status', 'active');

        $errors = [];
        if (empty($name)) $errors[] = 'Nama produk wajib diisi.';
        if ($categoryId <= 0) $errors[] = 'Kategori wajib dipilih.';
        if ($price <= 0) $errors[] = 'Harga harus lebih dari 0.';

        $updateData = [
            'category_id' => $categoryId,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'is_featured' => $isFeatured,
            'status' => $status,
        ];

        if (!empty($_FILES['image']['name'])) {
            try {
                $defaults = UploadHelper::imageDefaults();
                $updateData['image'] = UploadHelper::validateAndMove(
                    $_FILES['image'],
                    \UPLOAD_PATH . '/products',
                    $defaults['mimes'],
                    $defaults['maxSize'],
                    $defaults['exts']
                );
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/admin/produk/' . $id . '/edit');
        }

        $this->productModel->update($id, $updateData);
        $this->flash('success', 'Produk berhasil diperbarui.');
        $this->redirect('/admin/produk');
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->productModel->delete($id);
        $this->flash('success', 'Produk berhasil dihapus.');
        $this->redirect('/admin/produk');
    }
}
