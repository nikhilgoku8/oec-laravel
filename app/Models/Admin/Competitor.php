<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Engines\MeilisearchEngine;

class Competitor extends Model
{
    use Searchable;

    protected $table = 'competitors';

    protected $fillable = [
        'title',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function toSearchableArray()
    {
        $this->loadMissing('product');

        return [
            // 'id' => $this->id,
            'title' => $this->title,
            'product_id' => $this->product_id,
            // 'product_title' => $this->product->title,
            // 'product_description' => $this->product->description,
            // Add other searchable fields if needed
        ];
    }
}
