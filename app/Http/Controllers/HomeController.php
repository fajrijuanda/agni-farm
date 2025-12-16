<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Article; // Import Article
use App\Models\Contact;
use App\Models\PageView;
use App\Models\User; // Import User
use App\Notifications\NewContactMessage; // Import Notification
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification; // Import Facade

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Record page view
        PageView::record('home');

        // Get featured products
        $featuredProducts = Product::with(['category', 'images'])
            ->active()
            ->featured()
            ->ordered()
            ->take(8)
            ->get();

        // Get categories with product count
        $categories = Category::withCount(['products' => function ($q) {
                $q->where('is_active', true);
            }])
            ->active()
            ->ordered()
            ->take(6)
            ->get();

        // Get latest products
        $latestProducts = Product::with(['category', 'images'])
            ->active()
            ->latest()
            ->take(4)
            ->get();

        // Get latest articles
        $latestArticles = Article::published()->latest()->take(3)->get();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'latestProducts',
            'latestArticles'
        ));
    }

    /**
     * Display about page
     */
    public function about()
    {
        PageView::record('about');
        return view('about');
    }

    /**
     * Display catalog page
     */
    public function catalog(Request $request)
    {
        PageView::record('catalog');

        $query = Product::with(['category', 'images'])->active();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'popular':
                $query->popular();
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Display product detail
     */
    public function productShow(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Record page view and increment product view count
        PageView::record('product', $product->id);
        $product->incrementViewCount();

        $product->load(['category', 'images', 'specifications']);

        // Get related products
        $relatedProducts = Product::with(['category', 'images'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        PageView::record('contact');
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = Contact::create($validated);

        // Notify Admins
        try {
            $admins = User::where('is_admin', true)->get();
            Notification::send($admins, new NewContactMessage($contact));
        } catch (\Exception $e) {
            // Log error but continue
        }

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
