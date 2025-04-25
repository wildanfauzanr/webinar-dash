<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarApplicant extends Model
{
    use HasFactory;


    public function applicants_status()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id', 'id');
    }
}
