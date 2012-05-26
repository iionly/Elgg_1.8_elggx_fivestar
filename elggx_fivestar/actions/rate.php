<?php

// Make sure we're logged in (send us to the front page if not)
gatekeeper();
action_gatekeeper();

$guid = (int)get_input('id');
$vote = (int)get_input('vote');

if (!$vote && $rate = (int)get_input('rate_avg')) {
    $vote = $rate;
}

$msg = elggx_fivestar_vote($guid, $vote);

// Get the new rating
$rating = elggx_fivestar_getRating($guid);

$rating['msg'] = $msg;

if (!(int)get_input('vote') && (int)get_input('rate_avg')) {
    system_message(elgg_echo("elggx_fivestar:rating_saved"));
    forward($_SERVER['HTTP_REFERER']);
} else {
    header('Content-type: application/json');
    echo json_encode($rating);
    exit;
}
