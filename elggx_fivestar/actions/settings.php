<?php

/**
 * Save Elggx Fivestar settings
 *
 */

// Params array (text boxes and drop downs)
$params = get_input('params');
foreach ($params as $k => $v) {
    if (!elgg_set_plugin_setting($k, $v, 'elggx_fivestar')) {
        register_error(sprintf(elgg_echo('plugins:settings:save:fail'), 'elggx_fivestar'));
        forward(REFERER);
    }
}

$change_vote = (int)get_input('change_vote');
if ($change_vote == 0) {
    elgg_set_plugin_setting('change_cancel', 0, 'elggx_fivestar');
} else {
    elgg_set_plugin_setting('change_cancel', 1, 'elggx_fivestar');
}

$elggx_fivestar_view = '';

$values = get_input('elggx_fivestar_views');

if (is_array($values)) {
    foreach ($values as $value) {
       $elggx_fivestar_view .= $value . "\n";
    }
}

elgg_set_plugin_setting('elggx_fivestar_view', $elggx_fivestar_view, 'elggx_fivestar');

system_message(elgg_echo('elggx_fivestar:settings:save:ok'));

forward(REFERER);
