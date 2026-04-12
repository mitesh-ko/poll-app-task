<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'poll_id', 'poll_option_id'])]
class PollAnswer extends Model
{
    //
}
