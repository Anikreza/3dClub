<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubCategory extends Model
{
    protected $table    =   'sub_Categories';           //Table Name
    public $timestamps  =   false;

    protected $fillable     =   [
        'whichCategory_id',
        'name',
        'slug'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'whichCategory_id');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_categories', 'category_id', 'article_id');
    }

}
