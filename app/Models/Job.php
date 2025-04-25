<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'status',
        'recruiter_id',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    
}
