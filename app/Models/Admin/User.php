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
        'last_password_changed',
        'last_login',
        'login_attempts',
        'is_locked',
        'registered_at',
        'billing_fname',
        'billing_lname',
        'billing_phone',
        'billing_email',
        'billing_company',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_postcode',
        'same_address',
        'shipping_fname',
        'shipping_lname',
        'shipping_phone',
        'shipping_email',
        'shipping_company',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_country',
        'shipping_postcode',
        'paying_customer',
        'status',
        'created_by',
        'updated_by'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }
}
