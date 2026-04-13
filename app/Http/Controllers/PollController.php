<?php

namespace App\Http\Controllers;

use App\Events\PollAnswerAdded;
use App\Models\Poll;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PollController extends Controller
{
    /**
     * Load inertia view with respective data
     */
    public function show($slug): Response
    {
        $poll = Poll::with('options:id,poll_id,option_text')->where('slug', $slug)->select([
            'id',
            'is_multichoice',
            'slug',
            'question',
            'end_at'
        ])->firstOrFail();

        // check if user already sub answer on poll
        $canAns = PollAnswer::where('poll_id', $poll->id)->where(function ($query) {
            $query->where('user_id', auth()->id())->orWhere('ip_address', request()->ip());
        })->count();

        // user selected answer
        $answer = PollAnswer::where('poll_id', $poll->id)->where(function ($query) {
            $query->where('user_id', auth()->id())->orWhere('ip_address', request()->ip());
        })->select(['id', 'poll_option_id'])->get();

        $ansCount = PollAnswer::answerCount($poll->id);

        return Inertia::render('poll/show', [
            'poll' => $poll,
            'ansCount' => $ansCount,
            'canAns' => $canAns == 0,
            'answer' => $answer
        ]);
    }

    /**
     * Store user poll answers
     */
    public function store(Request $request, $slug): RedirectResponse
    {        
        $poll = Poll::where('slug', $slug)->firstOrFail();

        $data = [
            'user_id' => auth()->id(), // auth user if or null
            'poll_id' => $poll->id,
            'ip_address' => $request->ip(),
        ];
        if ($poll->is_multichoice) {
            $storeData = [];
            foreach (array_values($request->all()) as $ans) {
                $data['poll_option_id'] = $ans;
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $storeData[] = $data;
            }
            // insert will not trigger model event
            // insert used here to store all data in one query
            PollAnswer::insert($storeData);
        } else {
            $data['poll_option_id'] = $request->{$slug};
            PollAnswer::create($data);
        }
        $this->updatePollPercentage($poll);

        broadcast(new PollAnswerAdded($poll))->toOthers();
        return redirect()->back();
    }

    /**
     * Update percentage for poll options
     */
    public function updatePollPercentage($poll)
    {
        $options = $poll->options()->get();
        $totalAnswers = PollAnswer::answerCount($poll->id);
        foreach ($options as $option) {
            $option->percentage = round(($option->answers()->count() / $totalAnswers) * 100, 2);
            $option->save();
        }
    }
}
