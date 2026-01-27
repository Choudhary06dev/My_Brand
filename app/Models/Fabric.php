<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'fabric_category_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(FabricCategory::class, 'fabric_category_id');
    }
}
