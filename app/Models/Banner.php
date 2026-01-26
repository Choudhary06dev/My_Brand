<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'button_text',
        'link',
        'order',
        'is_active',
    ];}
