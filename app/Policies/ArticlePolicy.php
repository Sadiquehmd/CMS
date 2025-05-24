<?php
namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function view(User $user, Article $article)
    {
        return $user->isAdmin() || $user->id === $article->user_id;
    }

    public function update(User $user, Article $article)
    {
        return $user->isAdmin() || $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
        return $user->isAdmin() || $user->id === $article->user_id;
    }
}
