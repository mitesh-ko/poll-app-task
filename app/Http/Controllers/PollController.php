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
        $canAns = $this->canAnswer($poll);

        // user selected answer
        $answer = $this->userAnswers($poll);

        $ansCount = PollAnswer::answerCount($poll->id);

        return Inertia::render('poll/show', [
            'poll' => $poll,
            'ansCount' => $ansCount,
            'canAns' => $canAns,
            'answer' => $answer
        ]);
    }

    /**
     * Store user poll answers
     */
    public function store(Request $request, $slug): RedirectResponse
    {
        // validate request
        if (empty($request->all())) {
            return back()->withErrors([$slug => 'Select option to vote on the poll.']);
        }
        foreach($request->all() as $key => $value) {
            $rules[$key] = 'max:255|exists:poll_options,id';
            $messages["{$key}.exists"] = 'The selected option is invalid for the poll.';
            $messages["{$key}.max"] = 'The selected option is too long.';
        }
        $request->validate($rules, $messages);
        // validate request!

        $poll = Poll::where('slug', $slug)->firstOrFail();

        $canAns = $this->canAnswer($poll);
        if(!$canAns) {
            return back()->withErrors([$slug => 'You have already answered on this poll.']);
        }

        $ansData = [
            'user_id' => auth()->id(), // auth user id or null
            'poll_id' => $poll->id,
            'ip_address' => $request->ip(),
        ];
        
        $storeData = [];
        foreach ($request->all() as $value) {
            $ansData['poll_option_id'] = $value;
            $ansData['created_at'] = now();
            $ansData['updated_at'] = now();
            $storeData[] = $ansData;
        }
        PollAnswer::insert($storeData);

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

    /**
     * @return boolean
     * return true of user can answer for poll or false if no
     */
    public function canAnswer($poll)
    {
        return PollAnswer::where('poll_id', $poll->id)->where(function ($query) {
            if(auth()->check()){
                $query->where('user_id', auth()->id());
            } else {
                $query->Where('ip_address', request()->ip());
            }
        })->count() == 0 && $poll->end_at > now();
    }

    /**
     * Get user answers besaed on auth id or user ip
     */
    public function userAnswers($poll) {
        return PollAnswer::where('poll_id', $poll->id)->where(function ($query) {
            if(auth()->check()){
                $query->where('user_id', auth()->id());
            } else {
                $query->Where('ip_address', request()->ip());
            }
        })->select(['id', 'poll_option_id'])->get();
    }
}
