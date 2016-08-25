=== Star Rating ===
	Contributors: paratheme
	Donate link: http://paratheme.com
	Tags: star, star rating, 5 star, five star, star rate, post rate, star ratings,
	Requires at least: 3.8
	Tested up to: 4.2.4
	Stable tag: 1.0
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html

	Display five Star Rating under post or page.

== Description ==

Star Rating allows you to display five star rating under post or page or other post type via shortcode. 

### Star Rating by http://paratheme.com


<strong>Plugin Features</strong><br />

* Responsive admin settings.
* Use via short-code.
* Use on archive(loop) or content.
* Unlimited rating or single rating per user.

N.B. We are working on this plugin making some fancy star rating.




== Installation ==

1. Install as regular WordPress plugin.<br />
2. Go your plugin setting via WordPress dashboard and find "<strong>Star Rating</strong>" activate it.<br />

After activate plugin you will see "Star Rating" menu at left side on WordPress dashboard.<br />

hort-code inside content for fixed post id you can use anywhere inside content.

`[star_rating themes="flat"]`

Short-code inside loop by dynamic post id you can use anywhere inside loop or single.php

`<?php
echo do_shortcode( '[star_rating themes="flat" id="'.get_the_ID().'"]' ); 
?>`


== Screenshots ==

1. screenshot-1


== Changelog ==

	= 1.0 =
	
    * 07/11/2014 Initial release.
