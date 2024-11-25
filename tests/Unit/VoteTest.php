<?php

use App\Models\Vote;

test('vote model could be created', function () {
    $vote = new Vote([
        'feedback_id' => 1,
        'vote_id' => 1,
    ]);

    expect($vote->feedback_id)->toBe(1);
});
