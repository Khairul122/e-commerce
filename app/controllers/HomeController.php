<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index(): void
    {
        $banners = (new Banner())->getActive();
        $featuredProducts = (new Product())->getFeatured(5);
        $categories = (new Category())->all('name ASC');
        $testimonials = (new Testimonial())->getShown();
        $settings = (new Setting())->get();

        $this->view('landing/index', [
            'pageTitle' => 'Beranda',
            'banners' => $banners,
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
            'testimonials' => $testimonials,
            'settings' => $settings,
        ]);
    }
}
