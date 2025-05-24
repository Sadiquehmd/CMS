<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
protected $fillable = [
    'title', 'slug', 'content', 'summary', 'status', 'published_at', 'user_id'
];

public function categories()
{
    return $this->belongsToMany(Category::class);
}

public function author()
{
    return $this->belongsTo(User::class, 'user_id');
}

   

}
