<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class FilterValue extends Model
{
    protected $table = 'filter_values';

    protected $fillable = [
        'filter_type_id',
        'value',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function filterType(){
        return $this->belongsTo(FilterType::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
