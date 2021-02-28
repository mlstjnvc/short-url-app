<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JWToken extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    protected $fillable = ['jwt'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
