<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'fname',
        'email',
        'password',
        'role',
        'last_login',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
