<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SalesRepresentative extends Model
{
    protected $table = 'sales_representatives';

    protected $fillable = [
        'rep_name',
        'address',
        'website',
        'email',
        'phone'
    ];

    public function usStates(){
        return $this->belongsToMany(UsState::class, 'sales_representative_us_state')->withTimestamps();
    }
}
