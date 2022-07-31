<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    public function Category() {
        return $this->belongsTo(Category::class);
    }

    public function WishlistArticle() {
        return $this->hasMany(WishlistArticle::class);
    }

}
