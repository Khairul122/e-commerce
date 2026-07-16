<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(): void
    {
        $categoryId = $this->input('category') ? (int) $this->input('category') : null;
        $search = $this->input('search') ?: null;

        $productModel = new Product();
        $products = $productModel->getActive($categoryId, $search);
        $categories = (new Category())->all('name ASC');

        $this->view('products/index', [
            'pageTitle' => 'Katalog Produk',
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'search' => $search,
        ]);
    }

    public function show(string $slug): void
    {
        $productModel = new Product();
        $product = $productModel->findBySlug($slug);

        if (!$product) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $images = $productModel->getImages($product['id']);
        $related = $productModel->getRelated($product['category_id'], $product['id']);

        $this->view('products/show', [
            'pageTitle' => $product['name'],
            'product' => $product,
            'images' => $images,
            'related' => $related,
            'csrf' => $this->csrfToken(),
        ]);
    }
}
