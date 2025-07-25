<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ReachUs extends Model
{
    protected $table = 'reach_us_enquiries';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'company_website',
        'street_address',
        'city',
        'state',
        'country',
        'postcode',
        'contact_reason',
        'message',
        'document',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::deleting(function ($reachUs) {
            $folderPath = public_path('uploads/reach-us-documents');
            if ($reachUs->document && file_exists($folderPath.'/'.$reachUs->document)) {
                @unlink($folderPath.'/'.$reachUs->document);
            }
        });
    }
}
