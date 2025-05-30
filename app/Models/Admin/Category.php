<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'sort_order',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function subCategories(){
        return $this->hasMany(SubCategory::class)->orderBy('sort_order')->orderBy('title');
    }
}
