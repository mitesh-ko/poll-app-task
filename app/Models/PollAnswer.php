<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'poll_id', 'poll_option_id', 'ip_address'])]
class PollAnswer extends Model
{
    public function pollOption()
    {
        return $this->belongsTo(PollOptions::class, 'poll_option_id');
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function answerCount($pollId) {
        return self::where('poll_id', $pollId)->distinct('user_id')->distinct('ip_address')->count();
    }
}
