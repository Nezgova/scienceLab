<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'votes' => 'integer|nullable',
        ]);

        $article = Article::create($validated);
        return response()->json($article);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $validated = $request->validate([
            'author_id' => 'exists:users,id',
            'title' => 'string|max:255',
            'link' => 'url',
            'votes' => 'integer|nullable',
        ]);

        $article->update($validated);
        return response()->json($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(['message' => 'Article deleted successfully']);
    }
}
