<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["title", "slug", "description", "price", "created_at", "updated_at"];
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
