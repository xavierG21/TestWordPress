<?php
/**
 * Array of Icons for the opening button
 */

if ( ! function_exists( 'osp_opening_btn_icons' ) ) {

	function osp_opening_btn_icons( $return = 'fa fa-bars', $default = 'none' ) {

		// Add none to top of array
		$icons_array = array(
			'none' =>''
		);

		// Define return icons
		$return_icons = array();

		// Returns
		if ( 'fa fa-bars' == $return ) {
			$return_icons = array('fa fa-bars','fa fa-angle-double-left','fa fa-angle-double-right','fa fa-angle-left','fa fa-angle-right','fa fa-long-arrow-left','fa fa-long-arrow-right','fa fa-hand-o-left','fa fa-hand-o-right');
			$return_icons = array_combine($return_icons, $return_icons);
		}
		
		return apply_filters( 'osp_opening_btn_icons', array_merge( $icons_array, $return_icons ) );
		
	}

}