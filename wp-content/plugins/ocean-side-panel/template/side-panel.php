<?php
/**
 * Side Panel Template
 *
 * @package Ocean WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get opening button icon
$icon = get_theme_mod( 'osp_side_panel_open_btn_icon', 'fa fa-bars' );
$icon = $icon ? $icon : 'fa fa-bars';

// Close button text
$text = get_theme_mod( 'osp_close_button_text' );
$text = $text ? $text : esc_html__( 'Close Panel', 'ocean-side-panel' );

// Custom hamburger button
$btn = get_theme_mod( 'osp_side_panel_custom_open_btn', 'default' );

// Get the template
$template = get_theme_mod( 'osp_template' );

// Check if page is Elementor page
$elementor = get_post_meta( $template, '_elementor_edit_mode', true );

// Get template content
if ( ! empty( $template ) ) {

	$content = get_post( $template );

	if ( $content && ! is_wp_error( $content ) ) {
		$get_content = $content->post_content;
	}

} ?>

<div id="side-panel-wrap" class="clr">

	<?php
	// If the opening button is beside the panel
	if ( 'beside' == get_theme_mod( 'osp_side_panel_open_btn_position', 'menu' ) ) {
		if ( 'default' != $btn ) { ?>
			<a href="#" class="side-panel-btn">
				<div class="side-panel-icon hamburger hamburger--<?php echo esc_attr( $btn ); ?>">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			</a>
		<?php
		} else { ?>
			<a href="#" class="side-panel-btn"><i class="side-panel-icon <?php echo esc_attr( $icon ); ?>"></i></a>
		<?php
		}
	} ?>

	<div id="side-panel-inner" class="clr">

		<?php
		// If close button enabled
		if ( false != get_theme_mod( 'osp_side_panel_close_btn', true ) ) { ?>
			<a href="#" class="close-panel"><i class="fa fa-close"></i><span class="close-panel-text"><?php echo esc_attr( $text ); ?></span></a>
		<?php
		} ?>

		<div id="side-panel-content" class="clr">
			<?php
			// If a template is selected
			if ( ! empty( $template ) ) {

				// If Elementor
			    if ( class_exists( 'Elementor\Plugin' ) && $elementor ) {

			        echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template );

			    }

			    // If Beaver Builder
			    else if ( class_exists( 'FLBuilder' ) && ! empty( $template ) ) {

			        echo do_shortcode( '[fl_builder_insert_layout id="' . $template . '"]' );

			    }

			    // Else
			    else {

			        // Display template content
			        echo do_shortcode( $get_content );

			    }

			// Else, display the widgets
			} else {
				dynamic_sidebar( 'side-panel-sidebar' );
			} ?>
		</div><!-- #side-panel-content -->

	</div><!-- #side-panel-inner -->

</div><!-- #side-panel-wrap -->