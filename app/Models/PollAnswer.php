<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'poll_id', 'poll_option_id', 'ip_address'])]
class PollAnswer extends Model
{
    //
}
