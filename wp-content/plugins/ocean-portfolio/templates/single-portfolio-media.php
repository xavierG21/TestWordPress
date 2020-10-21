<?php
/**
 * Displays the portfolio single thumbmnail
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if Ocean Extra is not active or no thumbnail defined
if ( ! has_post_thumbnail() ) {
	return;
} ?>

<div class="thumbnail">

	<?php
	// Display post thumbnail
	the_post_thumbnail( 'full', array(
		'alt'		=> get_the_title(),
		'itemprop' 	=> 'image',
	) ); ?>

</div>