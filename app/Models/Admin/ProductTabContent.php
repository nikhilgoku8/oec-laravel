<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductTabContent extends Model
{
    protected $table = 'product_tab_contents';

    protected $fillable = [
        'product_tab_label_id',
        'product_id',
        'content',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function productTabLabel(){
        return $this->belongsTo(ProductTabLabel::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
