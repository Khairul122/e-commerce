<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\UploadHelper;
use App\Models\Banner;

class BannerController extends Controller
{
    private Banner $bannerModel;

    public function __construct()
    {
        $this->requireAdmin();
        $this->bannerModel = new Banner();
    }

    public function index(): void
    {
        $banners = $this->bannerModel->all('sort_order ASC');
        $this->view('admin/banners/index', [
            'pageTitle' => 'Manajemen Banner',
            'banners' => $banners,
            'csrf' => $this->csrfToken(),
            'flash' => $this->getFlash(),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $title = $this->input('title');
        $link = $this->input('link');
        $sortOrder = (int) $this->input('sort_order', 0);

        if (empty($_FILES['image']['name'])) {
            $this->flash('error', 'Gambar banner wajib diunggah.');
            $this->redirect('/admin/banner');
        }

        try {
            $defaults = UploadHelper::imageDefaults();
            $filename = UploadHelper::validateAndMove($_FILES['image'], \UPLOAD_PATH . '/banners', $defaults['mimes'], $defaults['maxSize'], $defaults['exts']);
        } catch (\Exception $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/admin/banner');
        }

        $this->bannerModel->create([
            'title' => $title,
            'image' => $filename,
            'link' => $link,
            'is_active' => 1,
            'sort_order' => $sortOrder,
        ]);
        $this->flash('success', 'Banner berhasil ditambahkan.');
        $this->redirect('/admin/banner');
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        $isActive = $this->input('is_active') ? 1 : 0;
        $this->bannerModel->update($id, ['is_active' => $isActive]);
        $this->flash('success', 'Banner berhasil diperbarui.');
        $this->redirect('/admin/banner');
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->bannerModel->delete($id);
        $this->flash('success', 'Banner berhasil dihapus.');
        $this->redirect('/admin/banner');
    }
}
