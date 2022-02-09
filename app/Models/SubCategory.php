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
        'category_id',
        'name',
        'slug'
    ];
}
