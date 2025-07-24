<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    protected $table = 'newsletter_subscriptions';

    protected $fillable = [
        'email'
    ];
}
