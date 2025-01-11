<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get(); // Ambil semua artikel, urutkan berdasarkan terbaru
        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail(); // Ambil artikel berdasarkan slug
        return view('articles.show', compact('article'));
    }
}
