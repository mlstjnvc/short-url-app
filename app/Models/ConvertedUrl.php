<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvertedUrl extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_url', 'short_url'];
}
