<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UsState extends Model
{
    protected $table = 'us_states';

    protected $fillable = [
        'title',
        'abbr'
    ];

    public function salesRepresentatives(){
        return $this->belongsToMany(SalesRepresentative::class, 'sales_representative_us_state')->withTimestamps();
    }
}
