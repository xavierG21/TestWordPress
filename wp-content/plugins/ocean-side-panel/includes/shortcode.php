<?php
/**
 * Opening button shortcode
 */

if ( ! function_exists( 'osp_opening_btn_shortcode' ) ) {

	function osp_opening_btn_shortcode( $atts ) {

		// Extract attributes
		extract( shortcode_atts( array(
			'icon' 		=> 'fa fa-bars',
			'btn' 		=> 'default',
			'text' 		=> '',
		), $atts ) );

		// Wrap class if text
		if ( $text ) {
			$class = ' has-text';
		} else {
			$class = '';
		} ?>

		<a href="#" class="side-panel-btn<?php echo esc_attr( $class ); ?>">
			<?php
			if ( 'default' != $btn ) { ?>
				<div class="side-panel-icon hamburger hamburger--<?php echo esc_attr( $btn ); ?>">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			<?php
			} else { ?>
				<i class="side-panel-icon <?php echo esc_attr( $icon ); ?>"></i>
			<?php
			}
			if ( $text ) { ?>
				<span class="side-panel-text"><?php echo esc_html( $text ); ?></span>
			<?php
			} ?>
		</a>

	<?php
	}

}
add_shortcode( 'osp_btn', 'osp_opening_btn_shortcode' );