<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistArticle extends Model
{
    use HasFactory;

    public function Article() {
        return $this->belongsTo(Article::class);
    }

    public function WishList() {
        return $this->belongsTo(Wishlist::class);
    }
}
