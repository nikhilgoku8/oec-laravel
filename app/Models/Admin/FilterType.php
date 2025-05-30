<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class FilterType extends Model
{
    protected $table = 'filter_types';

    protected $fillable = [
        'title',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function filterValues(){
        return $this->hasMany(FilterValue::class);
    }

}
