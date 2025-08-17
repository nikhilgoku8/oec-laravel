<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'title',
        'image_file',
        'link',
        'sort_order'
    ];

    protected static function booted()
    {
        static::deleting(function ($banner) {
            $folderPath = public_path('uploads/banners');
            if ($banner->image_file && file_exists($folderPath.'/'.$banner->image_file)) {
                @unlink($folderPath.'/'.$banner->image_file);
            }
        });
    }
}