<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Engines\MeilisearchEngine;

class Product extends Model
{
    // use Searchable;

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

    public function productTabContents(){
        return $this->hasMany(ProductTabContent::class);
    }

    // protected static function booted()
    // {
    //     static::created(function () {
    //         $index = (new MeilisearchEngine(app('scout.engine')->meilisearch()))
    //             ->updateIndexSettings((new static)->searchableAs(), [
    //                 'filterableAttributes' => ['filter_values'],
    //                 'sortableAttributes' => ['title'],
    //             ]);
    //     });
    // }

    // // Optional: customize searchable fields
    // public function toSearchableArray()
    // {
    //     return [
    //         // 'id' => $this->id,
    //         'title' => $this->title,
    //         'description' => $this->description,
    //         'filter_values' => $this->filterValues()->pluck('filter_value_product.id')->toArray(),
    //         // Add other searchable fields if needed
    //     ];
    // }
}
