<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'careers';

    protected $fillable = [
        'name',
        'email',
        'position',
        'message',
        'resume',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
