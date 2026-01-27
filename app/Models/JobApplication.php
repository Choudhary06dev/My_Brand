<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_id',
        'name',
        'email',
        'phone',
        'cv_file',
        'cover_letter',
    ];

    public function job()
    {
        return $this->belongsTo(JobOpening::class, 'job_id');
    }
}
