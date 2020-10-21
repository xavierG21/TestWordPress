<?php
/**
 * Portfolio single meta
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get meta sections
$sections = op_portfolio_single_meta();

// Return if sections are empty
if ( empty( $sections ) ) {
	return;
} ?>

<ul class="meta clr">

	<?php
	// Loop through meta sections
	foreach ( $sections as $section ) { ?>

		<?php if ( 'author' == $section ) { ?>
			<li class="meta-author"<?php oceanwp_schema_markup( 'author_name' ); ?>><i class="icon-user"></i><?php echo the_author_posts_link(); ?></li>
		<?php } ?>

		<?php if ( 'date' == $section ) { ?>
			<li class="meta-date"<?php oceanwp_schema_markup( 'publish_date' ); ?>><i class="icon-clock"></i><?php echo get_the_date(); ?></li>
		<?php } ?>

		<?php if ( 'categories' == $section ) { ?>
			<?php if ( $categories = op_portfolio_category_meta() ) {?>
				<li class="meta-cat"><i class="icon-folder"></i><?php echo $categories; ?></li>
			<?php } ?>
		<?php } ?>

		<?php if ( 'comments' == $section && comments_open() && ! post_password_required() ) { ?>
			<li class="meta-comments"><i class="icon-bubble"></i><?php comments_popup_link( esc_html__( '0 Comments', 'ocean-portfolio' ), esc_html__( '1 Comment',  'ocean-portfolio' ), esc_html__( '% Comments', 'ocean-portfolio' ), 'comments-link' ); ?></li>
		<?php } ?>

	<?php } ?>
	
</ul>