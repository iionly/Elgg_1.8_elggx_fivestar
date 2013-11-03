<script type="text/javascript">
    function fivestar(id, token, ts) {
        $("#fivestar-form-"+id).find('input[type=submit]').hide();

        // Create stars for: Rate this
        $("#fivestar-form-"+id).stars({
            cancelShow: 0,
            cancelValue: 0,
            captionEl: $("#caption"),
            callback: function(ui, type, value)
            {
                // Disable Stars while AJAX connection is active
                ui.disable();

                // Display message to the user at the begining of request
                $("#fivestar-messages-"+id).text("<?php echo elgg_echo('saving'); ?>").stop().css("opacity", 1).fadeIn(30);

                $.post("<?php echo elgg_get_site_url(); ?>action/elggx_fivestar/rate", {id: id, vote: value, __elgg_token: token, __elgg_ts: ts}, function(db)
                {
                    // Select stars from "Average rating" control to match the returned average rating value
                    $("#fivestar-form-"+id).stars("select", Math.round(db.rating));

                    // Update other text controls...
                    $("#fivestar-votes-"+id).text(db.votes);
                    $("#fivestar-rating-"+id).text(db.rating);

                    // Display confirmation message to the user
                    if (db.msg) {
                        $("#fivestar-messages-"+id).text(db.msg).stop().css("opacity", 1).fadeIn(30);
                    } else {
                        $("#fivestar-messages-"+id).text("<?php echo elgg_echo('elggx_fivestar:rating_saved'); ?>").stop().css("opacity", 1).fadeIn(30);
                    }

                    // Hide confirmation message and enable stars for "Rate this" control, after 2 sec...
                    setTimeout(function(){
                            $("#fivestar-messages-"+id).fadeOut(1000, function(){ui.enable()})
                    }, 2000);
                }, "json");
            }
        });

        // Create element to use for confirmation messages
        $('<div class="fivestar-messages" id="fivestar-messages-'+id+'"/>').appendTo("#fivestar-form-"+id);
    };
</script>

<?php

elgg_load_css('fivestar_css');
elgg_load_js('fivestar');

$ts = time();
$token = generate_action_token($ts);

$guid = isset($vars['fivestar_guid']) ? $vars['fivestar_guid'] : $vars['entity']->guid;

if (!$guid) {
    return;
}

$rating = elggx_fivestar_getRating($guid);
$stars = (int)elgg_get_plugin_setting('stars', 'elggx_fivestar');

$pps = 100 / $stars;

$checked = '';

$disabled = '';
if (!elgg_is_logged_in()) {
    $disabled = 'disabled="disabled"';
}

if (!(int)elgg_get_plugin_setting('change_cancel', 'elggx_fivestar')) {
    if (elggx_fivestar_hasVoted($guid)) {
        $disabled = 'disabled="disabled"';
    }
}

$subclass = $vars['subclass'] ? ' ' . $vars['subclass'] : '';
$outerId = $vars['outerId'] ? 'id="' . $vars['outerId'] . '"' : '';
$ratingText = $vars['ratingTextClass'] ? 'class="' . $vars['ratingTextClass'] . '"' : '';
?>

<div <?php echo $outerId; ?> class="fivestar-ratings-<?php echo $guid . $subclass; ?>">
    <form id="fivestar-form-<?php echo $guid; ?>" style="width: 200px" action="<?php echo elgg_get_site_url(); ?>action/elggx_fivestar/rate" method="post">
        <?php for ($i = 1; $i <= $stars; $i++) { ?>
            <?php if (round($rating['rating']) == $i) { $checked = 'checked="checked"'; } ?>
                <input type="radio" name="rate_avg" <?php echo $checked; ?> <?php echo $disabled; ?> value="<?php echo $pps * $i; ?>" />
                <?php $checked = ''; ?>
        <?php } ?>
            <input type="hidden" name="id" value="<?php echo $guid; ?>" />
            <input type="hidden" name="__elgg_token" value="<?php echo $token; ?>" />
            <input type="hidden" name="__elgg_ts" value="<?php echo $ts; ?>" />
            <input type="submit" value="Rate it!" />
    </form>
    <div class="clearfloat">
    <?php if (!$vars['min']) { ?>
        <p <?php echo $ratingText; ?>>
            <span id="fivestar-rating-<?php echo $guid; ?>"><?php echo $rating['rating']; ?></span>/<?php echo $stars . ' ' . elgg_echo('elggx_fivestar:lowerstars'); ?> (<span id="fivestar-votes-<?php echo $guid; ?>"><?php echo $rating['votes'] . ' ' . elgg_echo('elggx_fivestar:votes'); ?></span>)
        </p>
    <?php } ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(
        fivestar(<?php echo $guid; ?>, '<?php echo $token; ?>', '<?php echo $ts; ?>')
    );
</script>
