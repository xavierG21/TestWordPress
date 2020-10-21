// Side panel
var $j = jQuery.noConflict();

$j( document ).on( 'ready', function() {
	// Init side panel
	initSidePanel();
} );

/* ==============================================
INIT SIDE PANEL
============================================== */
function initSidePanel() {
	"use strict"

	// Close function
	var oceanwp_close_side_panel = function() {
		$j( 'a.side-panel-btn, .side-panel-btn a' ).removeClass( 'opened' );
		$j( 'body' ).removeClass( 'osp-opened' );
		$j( '.side-panel-btn > .side-panel-icon.hamburger' ).removeClass( 'is-active' );
	};

	// Open/Close panel
	$j( 'a.side-panel-btn, .side-panel-btn a, #side-panel-wrap a.close-panel, .osp-overlay' ).on( 'click', function( e ) {
		e.preventDefault();

		if ( ! $j( 'a.side-panel-btn' ).hasClass( 'opened' )
			&& ! $j( '.side-panel-btn a' ).hasClass( 'opened' ) ) {

			$j( '#side-panel-inner' ).css( { 'visibility': 'visible' } );
			$j( this ).addClass( 'opened' );
			$j( 'body' ).addClass( 'osp-opened' );
			$j( '.side-panel-btn > .side-panel-icon.hamburger' ).addClass( 'is-active' );

		} else {

			oceanwp_close_side_panel();

		}

	} );

	// Close when click on mobile button
	$j( '#ocean-mobile-menu-icon a.mobile-menu' ).on( 'click', function() {
		oceanwp_close_side_panel();
	} );

	// Panel scrollbar
	if ( ! navigator.userAgent.match( /(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/ ) ) {
		$j( '#side-panel-inner' ).niceScroll( {
			autohidemode		: false,
			cursorborder		: 0,
			cursorborderradius	: 0,
			cursorcolor			: 'transparent',
			cursorwidth			: 0,
			horizrailenabled	: false,
			mousescrollstep		: 40,
			scrollspeed			: 60,
			zindex				: 100005,
		} );
	}

}