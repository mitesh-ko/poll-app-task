<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['option_text', 'percentage'])]
class PollOptions extends Model
{
    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function answers()
    {
        return $this->hasMany(PollAnswer::class, 'poll_option_id');
    }
}
