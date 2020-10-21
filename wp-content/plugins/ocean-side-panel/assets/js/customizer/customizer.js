/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Declare vars
	var body = $( 'body' ),
		panelPosition = [
			'osp-right',
			'osp-left'
		];

	wp.customize( 'osp_beside_open_btn_icon_size', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_beside_open_btn_icon_size' );
			if ( to ) {
				var style = '<style class="customizer-osp_beside_open_btn_icon_size">#side-panel-wrap a.side-panel-btn{font-size:' + to + 'px;}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_beside_open_btn_bg', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap a.side-panel-btn' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'osp_beside_open_btn_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_beside_open_btn_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_beside_open_btn_color">#side-panel-wrap a.side-panel-btn, #side-panel-wrap a.side-panel-btn:hover{color:' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_beside_open_btn_border_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_beside_open_btn_border_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_beside_open_btn_border_color">#side-panel-wrap a.side-panel-btn{border-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_side_panel_open_btn_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_side_panel_open_btn_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_side_panel_open_btn_color">.side-panel-btn, #site-navigation-wrap .dropdown-menu > li > a.side-panel-btn{color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_side_panel_open_btn_hover_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_side_panel_open_btn_hover_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_side_panel_open_btn_hover_color">.side-panel-btn:hover, #site-navigation-wrap .dropdown-menu > li > a.side-panel-btn:hover{color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize('osp_side_panel_open_btn_icon', function( value ) {
		value.bind( function( newval ) {
			var $btn = $( '.side-panel-btn i' );

			if ( $btn.length ) {
				$btn.removeClass();
				$btn.addClass( 'side-panel-icon ' + newval );
			}
		});
	});
	if ( ! $( '.side-panel-btn' ).hasClass( 'has-text' ) ) {
		$( '.side-panel-btn' ).append( '<span class="side-panel-text"></span>' );
	}
	wp.customize('osp_side_panel_open_btn_text', function( value ) {
		value.bind( function( newval ) {
			$( '.side-panel-btn' ).removeClass( 'has-text' );
			$( '.side-panel-btn' ).addClass( 'has-text' );
			$( '.side-panel-btn .side-panel-text' ).html( newval );
		});
	} );
	wp.customize( 'osp_side_panel_custom_open_btn_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_side_panel_custom_open_btn_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_side_panel_custom_open_btn_color">.side-panel-btn .hamburger-inner, .side-panel-btn .hamburger-inner::before, .side-panel-btn .hamburger-inner::after{background-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize('osp_side_panel_displace', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				body.removeClass( 'osp-no-displace' );
			} else {
				body.addClass( 'osp-no-displace' );
			}
		});
	} );
	wp.customize('osp_side_panel_position', function( value ) {
		value.bind( function( newval ) {
			if ( body.length ) {
				$.each( panelPosition, function( i, v ) {
					body.removeClass( v );
				});
				body.addClass( newval );
			}
		});
	} );
	wp.customize( 'osp_side_panel_width', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_side_panel_width' );
			if ( to ) {
				var style = '<style class="customizer-osp_side_panel_width">#side-panel-wrap{width:' + to + 'px;}.osp-right #side-panel-wrap{right:-' + to + 'px;}.osp-right.osp-opened #outer-wrap{left:-' + to + 'px;}.osp-left #side-panel-wrap{left:-' + to + 'px;}.osp-left.osp-opened #outer-wrap{right:-' + to + 'px;}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_side_panel_width_tablet', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_side_panel_width_tablet' );
			if ( to ) {
				var style = '<style class="customizer-osp_side_panel_width_tablet">@media (max-width: 768px){#side-panel-wrap{width:' + to + 'px;}.osp-right #side-panel-wrap{right:-' + to + 'px;}.osp-right.osp-opened #outer-wrap{left:-' + to + 'px;}.osp-left #side-panel-wrap{left:-' + to + 'px;}.osp-left.osp-opened #outer-wrap{right:-' + to + 'px;}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_side_panel_width_mobile', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_side_panel_width_mobile' );
			if ( to ) {
				var style = '<style class="customizer-osp_side_panel_width_mobile">@media (max-width: 480px){#side-panel-wrap{width:' + to + 'px;}.osp-right #side-panel-wrap{right:-' + to + 'px;}.osp-right.osp-opened #outer-wrap{left:-' + to + 'px;}.osp-left #side-panel-wrap{left:-' + to + 'px;}.osp-left.osp-opened #outer-wrap{right:-' + to + 'px;}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize('osp_close_button_text', function( value ) {
		value.bind( function( newval ) {
			$( '#side-panel-wrap .close-panel-text' ).html( newval );
		});
	} );
		wp.customize( 'osp_top_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_top_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_top_padding">#side-panel-wrap #side-panel-content { padding-top: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_right_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_right_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_right_padding">#side-panel-wrap #side-panel-content { padding-right: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_bottom_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_bottom_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_bottom_padding">#side-panel-wrap #side-panel-content { padding-bottom: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_left_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_left_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_left_padding">#side-panel-wrap #side-panel-content { padding-left: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_tablet_top_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_tablet_top_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_tablet_top_padding">@media (max-width: 768px){#side-panel-wrap #side-panel-content { padding-top: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_tablet_right_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_tablet_right_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_tablet_right_padding">@media (max-width: 768px){#side-panel-wrap #side-panel-content { padding-right: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_tablet_bottom_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_tablet_bottom_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_tablet_bottom_padding">@media (max-width: 768px){#side-panel-wrap #side-panel-content { padding-bottom: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_tablet_left_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_tablet_left_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_tablet_left_padding">@media (max-width: 768px){#side-panel-wrap #side-panel-content { padding-left: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_mobile_top_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_mobile_top_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_mobile_top_padding">@media (max-width: 480px){#side-panel-wrap #side-panel-content { padding-top: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_mobile_right_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_mobile_right_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_mobile_right_padding">@media (max-width: 480px){#side-panel-wrap #side-panel-content { padding-right: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_mobile_bottom_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_mobile_bottom_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_mobile_bottom_padding">@media (max-width: 480px){#side-panel-wrap #side-panel-content { padding-bottom: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_mobile_left_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_mobile_left_padding' );
			if ( to ) {
				var style = '<style class="customizer-osp_mobile_left_padding">@media (max-width: 480px){#side-panel-wrap #side-panel-content { padding-left: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_side_panel_overlay_color', function( value ) {
		value.bind( function( to ) {
			$( '.osp-overlay' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'osp_side_panel_bg', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'osp_close_button_bg', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap a.close-panel' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'osp_close_button_hover_bg', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_close_button_hover_bg' );
			if ( to ) {
				var style = '<style class="customizer-osp_close_button_hover_bg">#side-panel-wrap a.close-panel:hover { background-color: ' + to + '!important; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_close_button_color', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap a.close-panel' ).css( 'color', to );
		} );
	} );
	wp.customize( 'osp_close_button_hover_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_close_button_hover_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_close_button_hover_color">#side-panel-wrap a.close-panel:hover { color: ' + to + '!important; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_text_color', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap,#side-panel-wrap p,#side-panel-wrap #wp-calendar caption,#side-panel-wrap #wp-calendar th,#side-panel-wrap #wp-calendar td' ).css( 'color', to );
		} );
	} );
	wp.customize( 'osp_headings_color', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap h1,#side-panel-wrap h2,#side-panel-wrap h3,#side-panel-wrap h4,#side-panel-wrap h5,#side-panel-wrap h6,#side-panel-wrap .sidebar-box .panel-widget-title' ).css( 'color', to );
		} );
	} );
	wp.customize( 'osp_links_color', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap a' ).css( 'color', to );
		} );
	} );
	wp.customize( 'osp_links_hover_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-osp_links_hover_color' );
			if ( to ) {
				var style = '<style class="customizer-osp_links_hover_color">#side-panel-wrap a:hover { color: ' + to + '!important; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	wp.customize( 'osp_list_border_color', function( value ) {
		value.bind( function( to ) {
			$( '#side-panel-wrap .ocean-widget-recent-posts-li,#side-panel-wrap .widget_categories li,#side-panel-wrap .widget_recent_entries li,#side-panel-wrap .widget_archive li,#side-panel-wrap .widget_recent_comments li,#side-panel-wrap .widget_layered_nav li,#side-panel-wrap .widget-recent-posts-icons li,#side-panel-wrap .ocean-widget-recent-posts-li:first-child,#side-panel-wrap .widget_categories li:first-child,#side-panel-wrap .widget_recent_entries li:first-child,#side-panel-wrap .widget_archive li:first-child,#side-panel-wrap .widget_recent_comments li:first-child,#side-panel-wrap .widget_layered_nav li:first-child,#side-panel-wrap .widget-recent-posts-icons li:first-child' ).css( 'border-color', to );
		} );
	} );
} )( jQuery );