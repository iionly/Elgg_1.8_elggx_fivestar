<?php

// Make sure we're logged in (send us to the front page if not)
gatekeeper();
action_gatekeeper();

elggx_fivestar_defaults();

forward($_SERVER['HTTP_REFERER']);
