<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();

        $orderModel = new Order();
        $ordersToday = $orderModel->countToday();
        $revenue = $orderModel->revenueCompleted();
        $pendingPayments = count((new Payment())->getPendingList());
        $weeklyStats = $orderModel->weeklyStats();

        $labels = [];
        $ordersData = [];
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('d M', strtotime($date));
            $found = null;
            foreach ($weeklyStats as $stat) {
                if ($stat['day'] === $date) {
                    $found = $stat;
                    break;
                }
            }
            $ordersData[] = $found ? (int) $found['total_orders'] : 0;
            $revenueData[] = $found ? (float) $found['total_revenue'] : 0;
        }

        $topProducts = (new Product())->getFeatured(5);

        $this->view('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'ordersToday' => $ordersToday,
            'revenue' => $revenue,
            'pendingPayments' => $pendingPayments,
            'chartLabels' => $labels,
            'chartOrders' => $ordersData,
            'chartRevenue' => $revenueData,
            'topProducts' => $topProducts,
        ]);
    }
}
