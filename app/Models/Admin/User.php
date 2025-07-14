<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'mobile',
        'last_login',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
