<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductTabLabel extends Model
{
    protected $table = 'product_tab_labels';

    protected $fillable = [
        'title',
        'sort_order',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function productTabContents(){
        return $this->hasMany(ProductTabContent::class);
    }
}
