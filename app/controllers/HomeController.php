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

    public function testimonial(): void
    {
        $testimonials = (new Testimonial())->all('created_at DESC');
        $settings = (new Setting())->get();

        $this->view('landing/testimonial', [
            'pageTitle' => 'Testimoni',
            'testimonials' => $testimonials,
            'settings' => $settings,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function submitTestimonial(): void
    {
        $this->requireLogin();
        $this->verifyCsrf();

        $message = $this->input('message');
        $rating = (int) $this->input('rating', 5);

        if (empty($message)) {
            $this->flash('error', 'Pesan testimoni tidak boleh kosong.');
            $this->redirect('/testimoni');
        }

        if ($rating < 1 || $rating > 5) {
            $rating = 5;
        }

        $userModel = new \App\Models\User();
        $user = $userModel->find($this->currentUser()['id']);

        $testimonialModel = new Testimonial();
        $testimonialModel->create([
            'customer_name' => $user['name'],
            'message' => $message,
            'rating' => $rating,
            'photo' => $user['photo'] ?? null,
            'is_shown' => 1
        ]);

        $this->flash('success', 'Testimoni Anda berhasil dikirim! Terima kasih atas dukungan Anda.');
        $this->redirect('/testimoni');
    }
}
