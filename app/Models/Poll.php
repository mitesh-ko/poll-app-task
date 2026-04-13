<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['question', 'description', 'slug', 'is_multichoice', 'end_at', 'data', 'user_id'])]
class Poll extends Model
{
    use HasFactory;

    public function options(): HasMany
    {
        return $this->hasMany(PollOptions::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }
}
