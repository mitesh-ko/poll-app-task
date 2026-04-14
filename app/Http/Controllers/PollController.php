<?php

namespace App\Http\Controllers;

use App\Events\PollAnswerAdded;
use App\Http\Requests\StorePollAnswer;
use App\Interfaces\PollAnswerRepositoryInterface;
use App\Interfaces\PollRepositoryInterface;
use App\Services\PollService;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PollController extends Controller
{
    protected $pollService;

    public function __construct(
        protected PollRepositoryInterface $pollRepository,
        protected PollAnswerRepositoryInterface $pollAnswerRepository
    ) {
        $this->pollService = new PollService();
    }

    /**
     * Load inertia view with respective data
     */
    public function show($slug): Response
    {
        $poll = $this->pollRepository->firstPollWithOptions($slug);

        // check if user already sub answer on poll
        $canAns = $this->pollService->canAnswerOnPoll($poll);

        // user selected answer
        $answer = $this->pollAnswerRepository->userAnswers($poll);

        $ansCount = $this->pollAnswerRepository->answerCount($poll);

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
    public function store(StorePollAnswer $request, $slug): RedirectResponse
    {
        $validData = $request->validated();

        $poll = $this->pollRepository->firstPoll($slug);

        $this->pollAnswerRepository->storePollAnswer($poll, $validData);

        $this->pollAnswerRepository->updateAnswerPercentage($poll);

        broadcast(new PollAnswerAdded($poll))->toOthers();

        return redirect()->back();
    }
}
