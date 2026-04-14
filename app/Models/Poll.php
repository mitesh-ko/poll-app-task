<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['question', 'description', 'slug', 'is_multichoice', 'end_at', 'data', 'user_id'])]
class Poll extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'array'
    ];

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
