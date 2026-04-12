<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PollController extends Controller
{
    public function show($slug)
    {
        $poll = Poll::with('options:id,poll_id,option_text')->where('slug', $slug)->select([
            'id',
            'is_multichoice',
            'slug',
            'question',
            'end_at'
        ])->firstOrFail();

        return Inertia::render('poll/show', [
            'poll' => $poll
        ]);
    }

    public function store(Request $request, $slug)
    {
        $userId = null;
        if (auth()->check()) {
            $userId = auth()->id();
        }
        $poll = Poll::where('slug', $slug)->firstOrFail();

        $data = [
            'user_id' => $userId,
            'poll_id' => $poll->id,
        ];
        if ($poll->is_multichoice) {
            $storeData = [];
            foreach (array_values($request->all()) as $ans) {
                $data['poll_option_id'] = $ans;
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $storeData[] = $data;
            }
            PollAnswer::insert($storeData);
        } else {
            $data['poll_option_id'] = $request->{$slug};
            PollAnswer::create($data);
        }

        return redirect()->back();
    }
}
