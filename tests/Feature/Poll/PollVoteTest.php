<?php

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\User;

test('user can view poll page on a slug', function () {
    $user = User::factory()->create();
    $poll = Poll::factory()
        ->for($user, 'user')
        ->create();
    PollOption::factory()
        ->count(3)
        ->for($poll)
        ->create();

    $response = $this
        ->actingAs($user)
        ->get(route('poll.show', ['slug' => $poll->slug]));

    $response->assertStatus(200);
});

test('user can vote on poll on a slug', function () {
    $user = User::factory()->create();
    $poll = Poll::factory()
        ->for($user, 'user')
        ->create();
    $options = PollOption::factory()
        ->count(3)
        ->for($poll)
        ->create();

    $response = $this
        ->actingAs($user)
        ->post(route('poll.store', ['slug' => $poll->slug]), [
            $poll->slug => $options[0]->id,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertStatus(302);
});

test('user can vote only once on a poll', function () {
    $user = User::factory()->create();
    $poll = Poll::factory()
        ->for($user, 'user')
        ->create();
    $options = PollOption::factory()
        ->count(3)
        ->for($poll)
        ->create();

    $this
        ->actingAs($user)
        ->post(route('poll.store', ['slug' => $poll->slug]), [
            $poll->slug => $options[0]->id,
        ]);

    $response = $this
        ->actingAs($user)
        ->post(route('poll.store', ['slug' => $poll->slug]), [
            $poll->slug => $options[0]->id,
        ]);

    $response
        ->assertSessionHasErrors([
             $poll->slug => 'You have already answered on this poll.'
         ]);
});
