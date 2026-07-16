<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Order;
use App\Models\Setting;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->requireAdmin();
    }

    private function resolveRange(): array
    {
        $from = $this->input('from') ?: date('Y-m-d', strtotime('-30 days'));
        $to = $this->input('to') ?: date('Y-m-d');
        return [$from, $to];
    }

    public function index(): void
    {
        [$from, $to] = $this->resolveRange();
        $orders = (new Order())->getInRange($from, $to);

        $totalOrders = count($orders);
        $totalRevenue = array_sum(array_map(fn($o) => $o['status'] === 'selesai' ? (float) $o['total'] : 0, $orders));

        $chartData = [];
        foreach ($orders as $o) {
            $day = date('Y-m-d', strtotime($o['created_at']));
            $chartData[$day] = ($chartData[$day] ?? 0) + 1;
        }
        ksort($chartData);

        $this->view('admin/reports/index', [
            'pageTitle' => 'Laporan Pemesanan',
            'orders' => $orders,
            'from' => $from,
            'to' => $to,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'chartLabels' => array_keys($chartData),
            'chartValues' => array_values($chartData),
        ]);
    }

    public function exportCsv(): void
    {
        [$from, $to] = $this->resolveRange();
        $orders = (new Order())->getInRange($from, $to);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan-pesanan-' . $from . '_' . $to . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['Kode Pesanan', 'Tanggal', 'Pelanggan', 'Subtotal', 'Ongkir', 'Total', 'Status']);
        foreach ($orders as $o) {
            fputcsv($out, [
                $o['order_code'],
                date('Y-m-d H:i', strtotime($o['created_at'])),
                $o['customer_name'],
                $o['subtotal'],
                $o['shipping_cost'],
                $o['total'],
                $o['status'],
            ]);
        }
        fclose($out);
        exit;
    }

    public function printView(): void
    {
        [$from, $to] = $this->resolveRange();
        $orders = (new Order())->getInRange($from, $to);
        $totalRevenue = array_sum(array_map(fn($o) => $o['status'] === 'selesai' ? (float) $o['total'] : 0, $orders));
        $settings = (new Setting())->get();

        $this->view('admin/reports/print', [
            'orders' => $orders,
            'from' => $from,
            'to' => $to,
            'totalRevenue' => $totalRevenue,
            'settings' => $settings,
        ]);
    }
}
