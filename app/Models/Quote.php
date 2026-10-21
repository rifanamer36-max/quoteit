<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quote extends Model
{
 public const MOODS = [
    'hope'       => '💡 Hope',
    'calm'       => '🌿 Calm',
    'philosophy' => '📖 Philosophy',
    'motivation' => '⚡ Motivation',
];

protected $fillable = ['user_id', 'text', 'mood'];
 public function user(): BelongsTo
 {
 return $this->belongsTo(User::class);
 }

 public function likedBy(): BelongsToMany
 {
 return $this->belongsToMany(User::class, 'quote_likes')->withTimestamps();
 }

 public function favoredBy(): BelongsToMany
 {
 return $this->belongsToMany(User::class, 'quote_user_favorites')->withTimestamps();
 }
}