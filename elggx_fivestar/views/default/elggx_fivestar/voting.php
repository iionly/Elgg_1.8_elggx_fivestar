<script type="text/javascript">
	function fivestar(guid, unique_id) {
		$("#fivestar-form-"+guid+"-"+unique_id).find('input[type=submit]').hide();

		// Create stars for: Rate this
		$("#fivestar-form-"+guid+"-"+unique_id).stars( {
			cancelShow: 0,
			cancelValue: 0,
			captionEl: $("#caption"),
			callback: function(ui, type, value) {
				// Disable Stars while AJAX connection is active
				ui.disable();

				// Display message to the user at the begining of request
				$("#fivestar-messages-"+guid+"-"+unique_id).text("<?php echo elgg_echo('saving'); ?>").stop().css("opacity", 1).fadeIn(30);
				var url = elgg.security.addToken("<?php echo elgg_get_site_url();?>action/elggx_fivestar/rate");
				$.post(url, {id: guid, vote: value}, function(db) {
					// Select stars from "Average rating" control to match the returned average rating value
					$("#fivestar-form-"+guid+"-"+unique_id).stars("select", Math.round(db.rating));

					// Update other text controls...
					$("#fivestar-votes-"+guid+"-"+unique_id).text(db.votes);
					$("#fivestar-rating-"+guid+"-"+unique_id).text(db.rating);

					// Display confirmation message to the user
					if (db.msg) {
						$("#fivestar-messages-"+guid+"-"+unique_id).text(db.msg).stop().css("opacity", 1).fadeIn(30);
					} else {
						$("#fivestar-messages-"+guid+"-"+unique_id).text("<?php echo elgg_echo('elggx_fivestar:rating_saved'); ?>").stop().css("opacity", 1).fadeIn(30);
					}

					// Hide confirmation message and enable stars for "Rate this" control, after 2 sec...
					setTimeout(function() {
						$("#fivestar-messages-"+guid+"-"+unique_id).fadeOut(1000, function(){ui.enable()})
					}, 2000);
				}, "json");
			}
		});

		// Create element to use for confirmation messages
		$('<div class="fivestar-messages" id="fivestar-messages-'+guid+"-"+unique_id+'"/>').appendTo("#fivestar-form-"+guid+"-"+unique_id);
	};
</script>

<?php

elgg_load_css('fivestar_css');
elgg_load_js('fivestar');

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

$unique_id = md5(uniqid(rand(), true));

$subclass = $vars['subclass'] ? ' ' . $vars['subclass'] : '';
$outerId = $vars['outerId'] ? 'id="' . $vars['outerId'] . '"' : '';
$ratingText = $vars['ratingTextClass'] ? 'class="' . $vars['ratingTextClass'] . '"' : '';
?>

<div <?php echo $outerId; ?> class="fivestar-ratings-<?php echo $guid."-".$unique_id . $subclass; ?>">
	<form id="fivestar-form-<?php echo $guid."-".$unique_id; ?>" style="width: 200px" action="<?php echo elgg_get_site_url(); ?>action/elggx_fivestar/rate" method="post">
		<?php for ($i = 1; $i <= $stars; $i++) { ?>
			<?php if (round($rating['rating']) == $i) { $checked = 'checked="checked"'; } ?>
				<input type="radio" name="rate_avg" <?php echo $checked; ?> <?php echo $disabled; ?> value="<?php echo $pps * $i; ?>" />
				<?php $checked = ''; ?>
		<?php }
			echo elgg_view('input/hidden', array('name' => 'id','value' => $guid));
			echo elgg_view('input/securitytoken');
		?>
		<input type="submit" value="Rate it!" />
	</form>
	<div class="clearfloat">
	<?php if (!$vars['min']) { ?>
		<p <?php echo $ratingText; ?>>
			<span id="fivestar-rating-<?php echo $guid."-".$unique_id; ?>"><?php echo $rating['rating']; ?></span>/<?php echo $stars . ' ' . elgg_echo('elggx_fivestar:lowerstars'); ?> (<span id="fivestar-votes-<?php echo $guid."-".$unique_id; ?>"><?php echo $rating['votes'] . ' ' . elgg_echo('elggx_fivestar:votes'); ?></span>)
		</p>
	<?php } ?>
	</div>
</div>

<script type="text/javascript">
	jQuery(fivestar(<?php echo $guid; ?>, '<?php echo $unique_id; ?>'));
</script>
