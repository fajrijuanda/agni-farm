<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::published()->latest()->paginate(9);

        // Get popular articles for slider (top 5 by views)
        $popularArticles = Article::published()
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('articles.index', compact('articles', 'popularArticles'));
    }

    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        // Increment view count
        $article->increment('views');

        // Get recent articles for sidebar (exclude current article)
        $recentArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(5)
            ->get();

        return view('articles.show', compact('article', 'recentArticles'));
    }
}
