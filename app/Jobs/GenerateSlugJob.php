<?php

namespace App\Jobs;

use App\Services\GroqService;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateSlugJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }


public function handle(GroqService $groq)
{
    $title = $this->article->title;
    $content = $this->article->content;

    $slug = $groq->generateSlug($title, $content);

    $slugBase = $slug;
    $count = 1;
    while (Article::where('slug', $slug)->where('id', '!=', $this->article->id)->exists()) {
        $slug = $slugBase . '-' . $count++;
    }

    $this->article->slug = $slug;
    $this->article->save();
}

}
