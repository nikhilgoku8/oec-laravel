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

    protected static function booted()
    {
        static::deleting(function ($career) {
            // $folderPath = public_path('uploads/resumes');
            $uploadRoot = base_path(env('UPLOAD_ROOT'));
            $folderPath = $uploadRoot . '/resumes';
            if ($career->resume && file_exists($folderPath.'/'.$career->resume)) {
                @unlink($folderPath.'/'.$career->resume);
            }
        });
    }
}
