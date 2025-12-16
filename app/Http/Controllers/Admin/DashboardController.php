<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\PageView;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_categories' => Category::count(),
            'total_views' => PageView::count(),
            'today_views' => PageView::getTodayViews(),
            'week_views' => PageView::getWeekViews(),
            'month_views' => PageView::getMonthViews(),
            'unread_contacts' => Contact::unread()->count(),
            'total_contacts' => Contact::count(),
            // Views per page
            'home_views' => PageView::getViewCount('home'),
            'catalog_views' => PageView::getViewCount('catalog'),
            'product_views' => PageView::getViewCount('product'),
            'about_views' => PageView::getViewCount('about'),
            'contact_views' => PageView::getViewCount('contact'),
        ];

        // Get daily views for the last 7 days
        $dailyViews = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyViews[] = [
                'date' => $date->format('d M'),
                'views' => PageView::whereDate('created_at', $date)->count(),
            ];
        }

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        $popularProducts = Product::with('category')
            ->active()
            ->popular()
            ->take(5)
            ->get();

        $recentContacts = Contact::recent()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'dailyViews',
            'recentProducts',
            'popularProducts',
            'recentContacts'
        ));
    }
}
