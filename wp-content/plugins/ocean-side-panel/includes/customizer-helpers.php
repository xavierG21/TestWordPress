<?php
/**
 * Active callback functions for the customizer
 */

function osp_customizer_helpers( $return = NULL ) {
	// Return library templates array
	if ( 'library' == $return ) {
		$templates 		= array( '&mdash; '. esc_html__( 'Select', 'ocean-side-panel' ) .' &mdash;' );
		$get_templates 	= get_posts( array( 'post_type' => 'oceanwp_library', 'numberposts' => -1, 'post_status' => 'publish' ) );

	    if ( ! empty ( $get_templates ) ) {
	    	foreach ( $get_templates as $template ) {
				$templates[ $template->ID ] = $template->post_title;
		    }
		}

		return $templates;
	}
}

function osp_cac_has_menu_open_btn() {
	if ( 'menu' == get_theme_mod( 'osp_side_panel_open_btn_position', 'menu' ) ) {
		return true;
	} else {
		return false;
	}
}

function osp_cac_has_beside_open_btn() {
	if ( 'beside' == get_theme_mod( 'osp_side_panel_open_btn_position', 'menu' ) ) {
		return true;
	} else {
		return false;
	}
}

function osp_cac_hasnt_beside_open_btn() {
	if ( 'beside' == get_theme_mod( 'osp_side_panel_open_btn_position', 'menu' ) ) {
		return false;
	} else {
		return true;
	}
}

function osp_cac_has_custom_open_btn() {
	if ( 'default' != get_theme_mod( 'osp_side_panel_custom_open_btn', 'default' ) ) {
		return true;
	} else {
		return false;
	}
}

function osp_cac_has_custom_breakpoint() {
	if ( 'custom' == get_theme_mod( 'osp_side_panel_breakpoints', '959' ) ) {
		return true;
	} else {
		return false;
	}
}

function osp_cac_has_overlay() {
	if ( true == get_theme_mod( 'osp_side_panel_overlay', false ) ) {
		return true;
	} else {
		return false;
	}
}