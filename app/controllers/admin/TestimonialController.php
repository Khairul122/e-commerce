<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    private Testimonial $testimonialModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->testimonialModel = new Testimonial();
    }

    public function index(): void
    {
        $testimonials = $this->testimonialModel->all('created_at DESC');
        $this->view('admin/testimonials/index', [
            'pageTitle' => 'Manajemen Testimoni',
            'testimonials' => $testimonials,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $name = $this->input('customer_name');
        $message = $this->input('message');
        $rating = max(1, min(5, (int) $this->input('rating', 5)));

        if (empty($name) || empty($message)) {
            $this->flash('error', 'Nama dan pesan wajib diisi.');
            $this->redirect('/admin/testimoni');
        }

        $this->testimonialModel->create([
            'customer_name' => $name,
            'message' => $message,
            'rating' => $rating,
            'is_shown' => 1,
        ]);
        $this->flash('success', 'Testimoni berhasil ditambahkan.');
        $this->redirect('/admin/testimoni');
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        $isShown = $this->input('is_shown') ? 1 : 0;
        $this->testimonialModel->update($id, ['is_shown' => $isShown]);
        $this->flash('success', 'Testimoni berhasil diperbarui.');
        $this->redirect('/admin/testimoni');
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->testimonialModel->delete($id);
        $this->flash('success', 'Testimoni berhasil dihapus.');
        $this->redirect('/admin/testimoni');
    }
}
