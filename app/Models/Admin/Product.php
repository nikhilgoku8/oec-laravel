<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Engines\MeilisearchEngine;

class Product extends Model
{
    use Searchable;

    protected $table = 'products';

    protected $fillable = [
        'sub_category_id',
        'title',
        'slug',
        'description',
        'features',
        'sales_drawing',
        'catalogue',
        'featured',
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

    public function competitors(){
        return $this->hasMany(Competitor::class)->orderBy('title');
    }

    public function filterValues(){
        return $this->belongsToMany(FilterValue::class)->withTimestamps();
    }

    public function productTabContents(){
        return $this->hasMany(ProductTabContent::class);
    }

    public static function makeAllSearchableUsing($query)
    {
        return $query->with('filterValues');
    }
    
    // // We dont need this as new product doesnt need to be added in existing settings set by custom scout:meili-configure command
    // protected static function booted()
    // {
    //     static::created(function () {
    //         $index = (new MeilisearchEngine(app('scout.engine')->meilisearch()))
    //             ->updateIndexSettings((new static)->searchableAs(), [
    //                 'filterableAttributes' => ['filter_value_ids'],
    //                 'sortableAttributes' => ['title'],
    //             ]);
    //     });
    // }

    // Optional: customize searchable fields
    public function toSearchableArray()
    {
        $this->loadMissing('filterValues');

        return [
            // 'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'filter_value_ids' => $this->filterValues->pluck('id')->toArray(),
            'sub_category_id' => $this->sub_category_id,
            // Add other searchable fields if needed
        ];
    }
}
