<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'keywords',
        'is_published',
        'position',
        'categories',
    ];

    /**
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_categories', 'category_id', 'article_id');
    }

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'whichCategory_id', 'id');
    }
}
