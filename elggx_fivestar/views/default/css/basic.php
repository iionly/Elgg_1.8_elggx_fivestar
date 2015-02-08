<?php
?>

.ui-stars-star,
.ui-stars-cancel {
	float: left;
	display: block;
	overflow: hidden;
	text-indent: -999em;
	cursor: pointer;
}
.ui-stars-star a,
.ui-stars-cancel a {
	width: 16px;
	height: 15px;
	display: block;
	background: url(<?php echo elgg_get_site_url(); ?>mod/elggx_fivestar/_graphics/ui.stars.gif) no-repeat 0 0;
}
.ui-stars-star a {
	background-position: 0 -32px;
}
.ui-stars-star-on a {
	background-position: 0 -48px;
}
.ui-stars-star-hover a {
	background-position: 0 -64px;
}
.ui-stars-cancel-hover a {
	background-position: 0 -16px;
}
.ui-stars-star-disabled,
.ui-stars-star-disabled a,
.ui-stars-cancel-disabled a {
	cursor: default !important;
}

.fivestar-messages {
	margin-left: 1em;
	float: left;
	line-height: 15px;
	color: #fd1c24
}

#fivestar_izap_videos_list {
float:right;
font-size:xx-small;
width:120px;
}

#fivestar_izap_videos_list p {
margin:0;
float:left;
}
