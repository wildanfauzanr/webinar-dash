<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'date', 'time', 'recruiter_id', 'link_meet', 'price'
    ];

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'webinar_applicant', 'webinar_id', 'applicant_id')
                    ->withPivot('payment_proof', 'status')
                    ->withTimestamps();
    }

}
