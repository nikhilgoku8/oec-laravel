<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'sub_category_id',
        'title',
        'description',
        'features',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function filterValues(){
        return $this->belongsToMany(FilterValue::class)->withTimestamps();
    }
}
