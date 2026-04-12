<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['question', 'description', 'slug', 'is_multichoice', 'end_at', 'data'])]
class Poll extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($poll) {
            $poll->user_id = auth()->id(); // only authenticated user can create poll
        });
    }

    public function options(): HasMany
    {
        return $this->hasMany(PollOptions::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }
}
