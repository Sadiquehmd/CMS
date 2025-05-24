<?php

namespace App\Http\Controllers\API;

use App\Jobs\GenerateSlugJob;
use App\Jobs\GenerateSummaryJob;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
{
    $query = Article::with(['categories', 'author']);

    if ($request->filled('category')) {
        $query->whereHas('categories', fn($q) => $q->where('id', $request->category));
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date_from')) {
        $query->whereDate('published_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('published_at', '<=', $request->date_to);
    }
    if (!Auth::user()->isAdmin()) {
        $query->where('user_id', Auth::id());
    }

    return response()->json($query->paginate(10));
}



public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:Draft,Published,Archived',
        'published_at' => 'nullable|date',
        'categories' => 'array',
        'categories.*' => 'exists:categories,id',
    ]);

    $article = new Article($validated);
    $article->user_id = Auth::id();
    $article->save();

    if (!empty($validated['categories'])) {
        $article->categories()->sync($validated['categories']);
    }

    GenerateSlugJob::dispatch($article);
    GenerateSummaryJob::dispatch($article);

    return response()->json($article, 201);
}


    public function show(Article $article)
    {
        $this->authorize('view', $article);
        return response()->json($article->load('categories', 'author'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'status' => 'in:draft,published,archived',
            'category_ids' => 'array|exists:categories,id',
        ]);

        $article->update($request->only('title', 'content', 'status'));
        if ($request->has('category_ids')) {
            $article->categories()->sync($request->category_ids);
        }

        return response()->json($article->load('categories'));
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return response()->json(null, 204);
    }
}
