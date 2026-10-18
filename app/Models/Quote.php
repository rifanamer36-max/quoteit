<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quote extends Model
{
    protected $fillable = ['user_id', 'text'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function likedBy(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'quote_likes')->withTimestamps();
}
}