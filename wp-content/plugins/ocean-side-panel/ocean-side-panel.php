<?php
/**
 * Plugin Name:			Ocean Side Panel
 * Plugin URI:			https://oceanwp.org/extension/ocean-side-panel/
 * Description:			Add a responsive side panel with your preferred widgets inside.
 * Version:				1.0.11
 * Author:				OceanWP
 * Author URI:			https://oceanwp.org/
 * Requires at least:	4.5.0
 * Tested up to:		4.9.6
 *
 * Text Domain: ocean-side-panel
 * Domain Path: /languages/
 *
 * @package Ocean_Side_Panel
 * @category Core
 * @author OceanWP
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the main instance of Ocean_Side_Panel to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Ocean_Side_Panel
 */
function Ocean_Side_Panel() {
	return Ocean_Side_Panel::instance();
} // End Ocean_Side_Panel()

Ocean_Side_Panel();

/**
 * Main Ocean_Side_Panel Class
 *
 * @class Ocean_Side_Panel
 * @version	1.0.0
 * @since 1.0.0
 * @package	Ocean_Side_Panel
 */
final class Ocean_Side_Panel {
	/**
	 * Ocean_Side_Panel The single instance of Ocean_Side_Panel.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct( $widget_areas = array() ) {
		$this->token 			= 'ocean-side-panel';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.11';

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'setup' ) );
		
		add_action( 'init', array( $this, 'updater' ), 1 );

		add_action( 'widgets_init', array( $this, 'register_sidebar' ), 11 );
	}

	/**
	 * Initialize License Updater.
	 * Load Updater initialize.
	 * @return void
	 */
	public function updater() {

		// Plugin Updater Code
		if( class_exists( 'OceanWP_Plugin_Updater' ) ) {
			$license	= new OceanWP_Plugin_Updater( __FILE__, 'Side Panel', $this->version, 'OceanWP' );
		}
	}

	/**
	 * Main Ocean_Side_Panel Instance
	 *
	 * Ensures only one instance of Ocean_Side_Panel is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Ocean_Side_Panel()
	 * @return Main Ocean_Side_Panel instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'ocean-side-panel', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number() {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	}

	/**
	 * Setup all the things.
	 * Only executes if OceanWP or a child theme using OceanWP as a parent is active and the extension specific filter returns true.
	 * @return void
	 */
	public function setup() {
		$theme = wp_get_theme();

		if ( 'OceanWP' == $theme->name || 'oceanwp' == $theme->template ) {
			// Capabilities
			$capabilities = apply_filters( 'ocean_main_metaboxes_capabilities', 'manage_options' );

			require_once( $this->plugin_path .'/includes/icons.php' );
			require_once( $this->plugin_path .'/includes/shortcode.php' );
			add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
			add_action( 'customize_register', array( $this, 'customizer_register' ) );
			if ( current_user_can( $capabilities ) ) {
				add_action( 'butterbean_register', array( $this, 'new_field' ), 10, 2 );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 999 );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_filter( 'wp_nav_menu_items', array( $this, 'side_panel_button' ), 11, 2 );
			add_action( 'ocean_after_mobile_icon', array( $this, 'side_panel_mobile_button' ) );
			add_action( 'wp_footer', array( $this, 'side_panel_overlay' ) );
			add_action( 'wp_footer', array( $this, 'side_panel' ) );
			add_filter( 'ocean_head_css', array( $this, 'head_css' ) );
		}
	}

	/**
	 * Registers sidebar
	 *
	 * @since  1.0.0
	 */
	public function register_sidebar() {

		register_sidebar( array(
			'name'			=> esc_html__( 'Side Panel Sidebar', 'ocean-side-panel' ),
			'id'			=> 'side-panel-sidebar',
			'description'	=> esc_html__( 'Widgets in this area are used in the side panel.', 'ocean-side-panel' ),
			'before_widget'	=> '<div class="sidebar-box %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h5 class="panel-widget-title">',
			'after_title'	=> '</h5>',
		) );

	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since  1.0.0
	 */
	public function customize_preview_init() {
		wp_enqueue_script( 'osp-customizer', plugins_url( '/assets/js/customizer/customizer.min.js', __FILE__ ), array( 'customize-preview' ), '1.0', true );
	}

	/**
	 * Customizer Controls and settings
	 *
	 * @since  1.0.0
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customizer_register( $wp_customize ) {

		/**
		 * Callback
		 */
		require_once( $this->plugin_path .'/includes/customizer-helpers.php' );

		/**
	     * Add a new section
	     */
		$wp_customize->add_section( 'osp_side_panel_section' , array(
		    'title'      	=> esc_html__( 'Side Panel', 'ocean-side-panel' ),
		    'priority'   	=> 210,
		) );

		/**
		 * Opening button position
		 */
		$wp_customize->add_setting( 'osp_side_panel_open_btn_position', array(
			'default' 				=> 'menu',
			'sanitize_callback' 	=> 'sanitize_key',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_open_btn_position', array(
			'label'	   				=> esc_html__( 'Opening Button Position', 'ocean-side-panel' ),
			'type' 					=> 'select',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_open_btn_position',
			'priority' 				=> 10,
			'choices' 				=> array(
				'menu' 		=> esc_html__( 'Inside the main menu', 'ocean-side-panel' ),
				'beside' 	=> esc_html__( 'Beside the panel', 'ocean-side-panel' ),
				'manual' 	=> esc_html__( 'Manual Position', 'ocean-side-panel' ),
			),
		) ) );

		/**
		 * Beside opening button icon size
		 */
		$wp_customize->add_setting( 'osp_beside_open_btn_icon_size', array(
			'default'				=> '20',
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_beside_open_btn_icon_size', array(
			'label'	   				=> esc_html__( 'Icon Size', 'ocean-side-panel' ),
			'type' 					=> 'number',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_beside_open_btn_icon_size',
			'priority' 				=> 10,
			'active_callback' 		=> 'osp_cac_has_beside_open_btn',
		    'input_attrs' 			=> array(
		        'min'   => 0,
		        'step'  => 1,
		    ),
		) ) );

		/**
	     * Beside opening button background color
	     */
        $wp_customize->add_setting( 'osp_beside_open_btn_bg', array(
			'default'				=> '#ffffff',
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_beside_open_btn_bg', array(
			'label'					=> esc_html__( 'Button: Background Color', 'ocean-side-panel' ),
			'section'				=> 'osp_side_panel_section',
			'settings'				=> 'osp_beside_open_btn_bg',
			'priority'				=> 10,
			'active_callback' 		=> 'osp_cac_has_beside_open_btn',
		) ) );

		/**
	     * Beside opening button color
	     */
        $wp_customize->add_setting( 'osp_beside_open_btn_color', array(
			'default'				=> '#13aff0',
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_beside_open_btn_color', array(
			'label'					=> esc_html__( 'Button: Color', 'ocean-side-panel' ),
			'section'				=> 'osp_side_panel_section',
			'settings'				=> 'osp_beside_open_btn_color',
			'priority'				=> 10,
			'active_callback' 		=> 'osp_cac_has_beside_open_btn',
		) ) );

		/**
	     * Beside opening button border color
	     */
        $wp_customize->add_setting( 'osp_beside_open_btn_border_color', array(
			'default'				=> '#eaeaea',
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_beside_open_btn_border_color', array(
			'label'					=> esc_html__( 'Button: Border Color', 'ocean-side-panel' ),
			'section'				=> 'osp_side_panel_section',
			'settings'				=> 'osp_beside_open_btn_border_color',
			'priority'				=> 10,
			'active_callback' 		=> 'osp_cac_has_beside_open_btn',
		) ) );

		/**
	     * Opening Button Color
	     */
        $wp_customize->add_setting( 'osp_side_panel_open_btn_color', array(
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_side_panel_open_btn_color', array(
			'label'					=> esc_html__( 'Opening Button: Color', 'ocean-side-panel' ),
			'section'				=> 'osp_side_panel_section',
			'settings'				=> 'osp_side_panel_open_btn_color',
			'priority'				=> 10,
			'active_callback' 		=> 'osp_cac_hasnt_beside_open_btn',
		) ) );

		/**
	     * Opening Button Hover Color
	     */
        $wp_customize->add_setting( 'osp_side_panel_open_btn_hover_color', array(
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_side_panel_open_btn_hover_color', array(
			'label'					=> esc_html__( 'Opening Button: Hover Color', 'ocean-side-panel' ),
			'section'				=> 'osp_side_panel_section',
			'settings'				=> 'osp_side_panel_open_btn_hover_color',
			'priority'				=> 10,
			'active_callback' 		=> 'osp_cac_hasnt_beside_open_btn',
		) ) );

		/**
		 * Opening button icon
		 */
		$wp_customize->add_setting( 'osp_side_panel_open_btn_icon', array(
			'transport' 			=> 'postMessage',
			'default'           	=> 'fa fa-bars',
			'sanitize_callback' 	=> 'wp_filter_nohtml_kses',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Icon_Select_Control( $wp_customize, 'osp_side_panel_open_btn_icon', array(
			'label'	   				=> esc_html__( 'Opening Button Icon', 'oceanwp' ),
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_open_btn_icon',
			'priority' 				=> 10,
		    'choices' 				=> osp_opening_btn_icons( 'fa fa-bars' ),
		) ) );

		/**
	     * Opening button text
	     */
        $wp_customize->add_setting( 'osp_side_panel_open_btn_text', array(
			'transport'				=> 'postMessage',
			'sanitize_callback' 	=> 'wp_kses_post',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_open_btn_text', array(
			'label'					=> esc_html__( 'Opening Button Text', 'ocean-side-panel' ),
			'section'				=> 'osp_side_panel_section',
			'settings'				=> 'osp_side_panel_open_btn_text',
			'type'					=> 'text',
			'priority'				=> 10,
			'active_callback' 		=> 'osp_cac_has_menu_open_btn',
		) ) );

		/**
		 * Text Position
		 */
		$wp_customize->add_setting( 'osp_side_panel_open_btn_text_position', array(
			'default' 				=> 'after-icon',
			'sanitize_callback' 	=> 'sanitize_key',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_open_btn_text_position', array(
			'label'	   				=> esc_html__( 'Text Position', 'ocean-side-panel' ),
			'type' 					=> 'select',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_open_btn_text_position',
			'priority' 				=> 10,
			'choices' 				=> array(
				'before-icon'	=> esc_html__( 'Before Icon', 'ocean-side-panel' ),
				'after-icon'	=> esc_html__( 'After Icon', 'ocean-side-panel' ),
			),
		) ) );

		/**
		 * Custom Opening Button
		 */
		$wp_customize->add_setting( 'osp_side_panel_custom_open_btn', array(
			'default' 				=> 'default',
			'sanitize_callback' 	=> 'sanitize_key',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_custom_open_btn', array(
			'label'	   				=> esc_html__( 'Custom Opening Button', 'ocean-side-panel' ),
			'type' 					=> 'select',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_custom_open_btn',
			'priority' 				=> 10,
			'choices' 				=> oceanwp_hamburgers_styles(),
		) ) );

		/**
	     * Custom Opening Button Color
	     */
        $wp_customize->add_setting( 'osp_side_panel_custom_open_btn_color', array(
			'default'			=> '#000000',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_side_panel_custom_open_btn_color', array(
			'label'			=> esc_html__( 'Opening Button: Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_side_panel_custom_open_btn_color',
			'priority'		=> 10,
			'active_callback' => 'osp_cac_has_custom_open_btn',
		) ) );

		/**
		 * Breakpoints
		 */
		$wp_customize->add_setting( 'osp_side_panel_breakpoints', array(
			'default' 				=> '959',
			'sanitize_callback' 	=> 'sanitize_key',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_breakpoints', array(
			'label'	   				=> esc_html__( 'Breakpoints', 'ocean-side-panel' ),
			'description'	   		=> esc_html__( 'Choose the media query where you want to hide the side panel.', 'ocean-side-panel' ),
			'type' 					=> 'select',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_breakpoints',
			'priority' 				=> 10,
			'choices' 				=> array(
				'never' 	=> esc_html__( 'Never hide the side panel', 'ocean-side-panel' ),
				'1280' 		=> esc_html__( 'From 1280px', 'ocean-side-panel' ),
				'1080' 		=> esc_html__( 'From 1080px', 'ocean-side-panel' ),
				'959' 		=> esc_html__( 'From 959px', 'ocean-side-panel' ),
				'767' 		=> esc_html__( 'From 767px', 'ocean-side-panel' ),
				'480' 		=> esc_html__( 'From 480px', 'ocean-side-panel' ),
				'320' 		=> esc_html__( 'From 320px', 'ocean-side-panel' ),
				'custom' 	=> esc_html__( 'Custom media query', 'ocean-side-panel' ),
			),
		) ) );

		/**
		 * Custom Media Query
		 */
		$wp_customize->add_setting( 'osp_side_panel_custom_breakpoint', array(
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_custom_breakpoint', array(
			'label'	   				=> esc_html__( 'Custom Media Query', 'ocean-side-panel' ),
			'description'	   		=> esc_html__( 'Enter your custom media query where you want to hide the side panel.', 'ocean-side-panel' ),
			'type' 					=> 'number',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_custom_breakpoint',
			'priority' 				=> 10,
			'active_callback' 		=> 'osp_cac_has_custom_breakpoint',
		    'input_attrs' 			=> array(
		        'min'   => 0,
		        'step'  => 1,
		    ),
		) ) );

		/**
	     * Display close button
	     */
        $wp_customize->add_setting( 'osp_side_panel_close_btn', array(
			'default'			=> true,
			'sanitize_callback'	=> 'oceanwp_sanitize_checkbox',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_close_btn', array(
			'label'			=> esc_html__( 'Display Close Button', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_side_panel_close_btn',
			'type'			=> 'checkbox',
			'priority'		=> 10,
		) ) );

		/**
	     * Displace
	     */
        $wp_customize->add_setting( 'osp_side_panel_displace', array(
			'transport'			=> 'postMessage',
			'default'			=> true,
			'sanitize_callback'	=> 'oceanwp_sanitize_checkbox',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_displace', array(
			'label'			=> esc_html__( 'Displace', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_side_panel_displace',
			'type'			=> 'checkbox',
			'priority'		=> 10,
		) ) );

		/**
	     * Add overlay
	     */
        $wp_customize->add_setting( 'osp_side_panel_overlay', array(
			'default'			=> false,
			'sanitize_callback'	=> 'oceanwp_sanitize_checkbox',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_side_panel_overlay', array(
			'label'			=> esc_html__( 'Add Overlay', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_side_panel_overlay',
			'type'			=> 'checkbox',
			'priority'		=> 10,
		) ) );

		/**
	     * Panel position
	     */
        $wp_customize->add_setting( 'osp_side_panel_position', array(
			'default'           	=> 'osp-right',
			'sanitize_callback' 	=> 'oceanwp_sanitize_select',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Buttonset_Control( $wp_customize, 'osp_side_panel_position', array(
			'label'	   				=> esc_html__( 'Panel Position', 'ocean-side-panel' ),
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_side_panel_position',
			'priority' 				=> 10,
			'choices' 				=> array(
				'osp-right' 	=> esc_html__( 'Right', 'ocean-side-panel' ),
				'osp-left' 		=> esc_html__( 'Left', 'ocean-side-panel' ),
			),
		) ) );

		/**
	     * Panel width
	     */
		$wp_customize->add_setting( 'osp_side_panel_width', array(
			'transport' 			=> 'postMessage',
			'default'				=> '300',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number',
		) );
		$wp_customize->add_setting( 'osp_side_panel_width_tablet', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );

		$wp_customize->add_setting( 'osp_side_panel_width_mobile', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Slider_Control( $wp_customize, 'osp_side_panel_width', array(
			'label'	   				=> esc_html__( 'Panel Width (px)', 'oceanwp' ),
			'section'  				=> 'osp_side_panel_section',
			'settings' => array(
	            'desktop' 	=> 'osp_side_panel_width',
	            'tablet' 	=> 'osp_side_panel_width_tablet',
	            'mobile' 	=> 'osp_side_panel_width_mobile',
		    ),
			'priority' 				=> 10,
		    'input_attrs' 			=> array(
		        'min'   => 100,
		        'max'   => 800,
		        'step'  => 1,
		    ),
		) ) );

		/**
	     * Close button text
	     */
        $wp_customize->add_setting( 'osp_close_button_text', array(
			'default'			=> esc_html__( 'Close Panel', 'ocean-side-panel' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_close_button_text', array(
			'label'			=> esc_html__( 'Close Button Text', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_close_button_text',
			'type'			=> 'text',
			'priority'		=> 10,
		) ) );

		/**
		 * Template
		 */
		$wp_customize->add_setting( 'osp_template', array(
			'default'           	=> '0',
			'sanitize_callback' 	=> 'oceanwp_sanitize_select',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'osp_template', array(
			'label'	   				=> esc_html__( 'Select Template', 'ocean-side-panel' ),
			'description'	   		=> esc_html__( 'Choose a template created in Theme Panel > My Library to replace the content.', 'ocean-side-panel' ),
			'type' 					=> 'select',
			'section'  				=> 'osp_side_panel_section',
			'settings' 				=> 'osp_template',
			'priority' 				=> 10,
			'choices' 				=> osp_customizer_helpers( 'library' ),
		) ) );

		/**
		 * Padding
		 */
		$wp_customize->add_setting( 'osp_top_padding', array(
			'transport' 			=> 'postMessage',
			'default'           	=> '20',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number',
		) );
		$wp_customize->add_setting( 'osp_right_padding', array(
			'transport' 			=> 'postMessage',
			'default'           	=> '30',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number',
		) );
		$wp_customize->add_setting( 'osp_bottom_padding', array(
			'transport' 			=> 'postMessage',
			'default'           	=> '30',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number',
		) );
		$wp_customize->add_setting( 'osp_left_padding', array(
			'transport' 			=> 'postMessage',
			'default'           	=> '30',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number',
		) );

		$wp_customize->add_setting( 'osp_tablet_top_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );
		$wp_customize->add_setting( 'osp_tablet_right_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );
		$wp_customize->add_setting( 'osp_tablet_bottom_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );
		$wp_customize->add_setting( 'osp_tablet_left_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );

		$wp_customize->add_setting( 'osp_mobile_top_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );
		$wp_customize->add_setting( 'osp_mobile_right_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );
		$wp_customize->add_setting( 'osp_mobile_bottom_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );
		$wp_customize->add_setting( 'osp_mobile_left_padding', array(
			'transport' 			=> 'postMessage',
			'sanitize_callback' 	=> 'oceanwp_sanitize_number_blank',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Dimensions_Control( $wp_customize, 'osp_padding', array(
			'label'	   				=> esc_html__( 'Padding (px)', 'ocean-side-panel' ),
			'section'  				=> 'osp_side_panel_section',				
			'settings'   => array(					
	            'desktop_top' 		=> 'osp_top_padding',
	            'desktop_right' 	=> 'osp_right_padding',
	            'desktop_bottom' 	=> 'osp_bottom_padding',
	            'desktop_left' 		=> 'osp_left_padding',
	            'tablet_top' 		=> 'osp_tablet_top_padding',
	            'tablet_right' 		=> 'osp_tablet_right_padding',
	            'tablet_bottom' 	=> 'osp_tablet_bottom_padding',
	            'tablet_left' 		=> 'osp_tablet_left_padding',
	            'mobile_top' 		=> 'osp_mobile_top_padding',
	            'mobile_right' 		=> 'osp_mobile_right_padding',
	            'mobile_bottom' 	=> 'osp_mobile_bottom_padding',
	            'mobile_left' 		=> 'osp_mobile_left_padding',
			),
			'priority' 				=> 10,
		    'input_attrs' 			=> array(
		        'min'   => 0,
		        'step'  => 1,
		    ),
		) ) );

		/**
	     * Overlay color
	     */
        $wp_customize->add_setting( 'osp_side_panel_overlay_color', array(
			'default'			=> 'rgba(0,0,0,0.3)',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_side_panel_overlay_color', array(
			'label'				=> esc_html__( 'Overlay Color', 'ocean-side-panel' ),
			'section'			=> 'osp_side_panel_section',
			'settings'			=> 'osp_side_panel_overlay_color',
			'priority'			=> 10,
			'active_callback' 	=> 'osp_cac_has_overlay',
		) ) );

		/**
	     * Background color
	     */
        $wp_customize->add_setting( 'osp_side_panel_bg', array(
			'default'			=> '#1b1b1b',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_side_panel_bg', array(
			'label'			=> esc_html__( 'Background Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_side_panel_bg',
			'priority'		=> 10,
		) ) );

		/**
	     * Close button background color
	     */
        $wp_customize->add_setting( 'osp_close_button_bg', array(
			'default'			=> '#111111',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_close_button_bg', array(
			'label'			=> esc_html__( 'Close Button Background', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_close_button_bg',
			'priority'		=> 10,
		) ) );

		/**
	     * Close button hover background color
	     */
        $wp_customize->add_setting( 'osp_close_button_hover_bg', array(
			'default'			=> '#111111',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_close_button_hover_bg', array(
			'label'			=> esc_html__( 'Close Button Background: Hover', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_close_button_hover_bg',
			'priority'		=> 10,
		) ) );

		/**
	     * Close button color
	     */
        $wp_customize->add_setting( 'osp_close_button_color', array(
			'default'			=> '#dddddd',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_close_button_color', array(
			'label'			=> esc_html__( 'Close Button Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_close_button_color',
			'priority'		=> 10,
		) ) );

		/**
	     * Close button hover color
	     */
        $wp_customize->add_setting( 'osp_close_button_hover_color', array(
			'default'			=> '#ffffff',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_close_button_hover_color', array(
			'label'			=> esc_html__( 'Close Button Color: Hover', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_close_button_hover_color',
			'priority'		=> 10,
		) ) );

		/**
	     * Text color
	     */
        $wp_customize->add_setting( 'osp_text_color', array(
			'default'			=> '#888888',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_text_color', array(
			'label'			=> esc_html__( 'Text Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_text_color',
			'priority'		=> 10,
		) ) );

		/**
	     * Headings color
	     */
        $wp_customize->add_setting( 'osp_headings_color', array(
			'default'			=> '#ffffff',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_headings_color', array(
			'label'			=> esc_html__( 'Headings Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_headings_color',
			'priority'		=> 10,
		) ) );

		/**
	     * Links color
	     */
        $wp_customize->add_setting( 'osp_links_color', array(
			'default'			=> '#888888',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_links_color', array(
			'label'			=> esc_html__( 'Links Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_links_color',
			'priority'		=> 10,
		) ) );

		/**
	     * Links hover color
	     */
        $wp_customize->add_setting( 'osp_links_hover_color', array(
			'default'			=> '#ffffff',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_links_hover_color', array(
			'label'			=> esc_html__( 'Links Color: Hover', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_links_hover_color',
			'priority'		=> 10,
		) ) );

		/**
	     * List border color
	     */
        $wp_customize->add_setting( 'osp_list_border_color', array(
			'default'			=> '#555555',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'oceanwp_sanitize_color',
		) );

		$wp_customize->add_control( new OceanWP_Customizer_Color_Control( $wp_customize, 'osp_list_border_color', array(
			'label'			=> esc_html__( 'Widgets List Borders Color', 'ocean-side-panel' ),
			'section'		=> 'osp_side_panel_section',
			'settings'		=> 'osp_list_border_color',
			'priority'		=> 10,
		) ) );

	}

	/**
	 * Add new field in metabox.
	 *
	 * @since  1.0.8
	 */
	public function new_field( $butterbean, $post_type ) {

		// Gets the manager object we want to add sections to.
		$manager = $butterbean->get_manager( 'oceanwp_mb_settings' );
						
		$manager->register_control(
	        'osp_disable_panel', // Same as setting name.
	        array(
	            'section' 		=> 'oceanwp_mb_main',
	            'type'    		=> 'buttonset',
	            'label'   		=> esc_html__( 'Side Panel', 'ocean-side-panel' ),
	            'description'   => esc_html__( 'Disable the side panel on this page/post.', 'ocean-side-panel' ),
				'choices' 		=> array(
					'default' 	=> esc_html__( 'Default', 'ocean-side-panel' ),
					'off' 		=> esc_html__( 'Disable', 'ocean-side-panel' ),
				),
	        )
	    );
		
		$manager->register_setting(
	        'osp_disable_panel', // Same as control name.
	        array(
	            'sanitize_callback' => 'sanitize_key',
	            'default' 			=> 'default',
	        )
	    );

	}

	/**
	 * If side panel
	 *
	 * @since  1.0.8
	 */
	public function if_side_panel() {

		// Return true by default
		$return = true;
		
		// Retunr meta if Disable if selected
		$meta = oceanwp_post_id() ? get_post_meta( oceanwp_post_id(), 'osp_disable_panel', true ) : '';

		if ( 'off' == $meta ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'osp_display_side_panel', $return );

	}

	/**
	 * Enqueue scripts.
	 *
	 * @since  1.0.0
	 */
	public function scripts() {

		// Load main stylesheet
		wp_enqueue_style( 'osp-side-panel-style', plugins_url( '/assets/css/style.min.css', __FILE__ ) );

		// If rtl
		if ( is_RTL() ) {
			wp_enqueue_style( 'osp-side-panel-rtl', plugins_url( '/assets/css/rtl.css', __FILE__ ) );
		}
		
		// Load js script.
		wp_enqueue_script( 'nicescroll' );
		wp_enqueue_script( 'osp-script', plugins_url( '/assets/js/main.min.js', __FILE__ ), array( 'jquery', 'oceanwp-main' ), null, true );

		// Get hamburger icon style
		$hamburger = get_theme_mod( 'osp_side_panel_custom_open_btn', 'default' );

		// Enqueue hamburger icon style
		if ( ! empty( $hamburger ) && 'default' != $hamburger ) {
			wp_enqueue_style( 'oceanwp-hamburgers' );
			wp_enqueue_style( 'oceanwp-'. $hamburger .'' );
		}

	}

	/**
	 * Add classes to body
	 *
	 * @since  1.0.0
	 */
	public function body_classes( $classes ) {

		// Panel position
		$classes[] = get_theme_mod( 'osp_side_panel_position', 'osp-right' );

		// If no breakpoint
		if ( '959' == get_theme_mod( 'osp_side_panel_breakpoints', '959' ) ) {
			$classes[] = 'osp-no-breakpoint';
		}

		// If no displace
		if ( true != get_theme_mod( 'osp_side_panel_displace', true ) ) {
			$classes[] = 'osp-no-displace';
		}

		// Return classes
		return $classes;

	}

	/**
	 * Add button to open the side panel
	 *
	 * @since  1.0.0
	 */
	public function side_panel_button( $items, $args ) {

		// Return if disabled
		if ( false == $this->if_side_panel() ) {
			return $items;
		}

		// Button position
		$btn = get_theme_mod( 'osp_side_panel_open_btn_position', 'menu' );

		// Only used on main menu
		if ( 'main_menu' != $args->theme_location
			|| ( 'menu' != $btn || 'manual' == $btn ) ) {
			return $items;
		}

		// Get icon
		$icon = get_theme_mod( 'osp_side_panel_open_btn_icon', 'fa fa-bars' );
		$icon = $icon ? $icon : 'fa fa-bars';

		// Custom hamburger button
		$btn = get_theme_mod( 'osp_side_panel_custom_open_btn', 'default' );

		// Get text
		$text = get_theme_mod( 'osp_side_panel_open_btn_text' );

		// Get text position
		$text_position = get_theme_mod( 'osp_side_panel_open_btn_text_position' );
		$text_position = $text_position ? $text_position : 'after-icon';

		// Classes
		$classes = array( 'side-panel-btn' ); 

		// If text
		if ( $text ) {
			$classes[] = 'has-text';

			// Text position
			if ( $text_position ) {
				$classes[] = $text_position;
			}
		}

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// Add button to menu
		$items .= '<li class="side-panel-li">';
			$items .= '<a href="#" class="'. $classes .'">';
				if ( $text
					&& 'before-icon' == $text_position ) {
					$items .= '<span class="side-panel-text">'. $text .'</span>';
				}
				if ( 'default' != $btn ) {
					$items .= '<div class="side-panel-icon hamburger hamburger--'. $btn .'">';
						$items .= '<div class="hamburger-box">';
							$items .= '<div class="hamburger-inner"></div>';
						$items .= '</div>';
					$items .= '</div>';
				} else {
					$items .= '<i class="side-panel-icon '. $icon .'"></i>';
				}
				if ( $text
					&& 'after-icon' == $text_position ) {
					$items .= '<span class="side-panel-text">'. $text .'</span>';
				}
			$items .= '</a>';
		$items .= '</li>';
		
		// Return nav $items
		return $items;

	}

	/**
	 * Add button to open the side panel
	 *
	 * @since  1.0.0
	 */
	public function side_panel_mobile_button() {

		// Return if manual position
		if ( 'manual' == get_theme_mod( 'osp_side_panel_open_btn_position', 'menu' )
			|| false == $this->if_side_panel() ) {
			return;
		}

		// Get icon
		$icon = get_theme_mod( 'osp_side_panel_open_btn_icon', 'fa fa-bars' );
		$icon = $icon ? $icon : 'fa fa-bars';

		// Custom hamburger button
		$btn = get_theme_mod( 'osp_side_panel_custom_open_btn', 'default' );

		// Get text
		$text = get_theme_mod( 'osp_side_panel_open_btn_text' );

		// Get text position
		$text_position = get_theme_mod( 'osp_side_panel_open_btn_text_position' );
		$text_position = $text_position ? $text_position : 'after-icon';

		// Classes
		$classes = array( 'side-panel-btn' ); 

		// If text
		if ( $text ) {
			$classes[] = 'has-text';

			// Text position
			if ( $text_position ) {
				$classes[] = $text_position;
			}
		}

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// Add button to menu
		$items = '<a href="#" class="'. $classes .'">';
			if ( $text
				&& 'before-icon' == $text_position ) {
				$items .= '<span class="side-panel-text">'. $text .'</span>';
			}
			if ( 'default' != $btn ) {
				$items .= '<div class="side-panel-icon hamburger hamburger--'. $btn .'">';
					$items .= '<div class="hamburger-box">';
						$items .= '<div class="hamburger-inner"></div>';
					$items .= '</div>';
				$items .= '</div>';
			} else {
				$items .= '<span class="side-panel-icon '. $icon .'"></span>';
			}
				if ( $text
					&& 'after-icon' == $text_position ) {
					$items .= '<span class="side-panel-text">'. $text .'</span>';
				}
		$items .= '</a>';
		
		// Echo nav $items
		echo $items;
		
	}

	/**
	 * Overlay
	 *
	 * @since  1.0.0
	 */
	public function side_panel_overlay() {

		// Return if not true
		if ( true != get_theme_mod( 'osp_side_panel_overlay', false )
			|| false == $this->if_side_panel() ) {
			return;
		}

		// Add overlay div
		echo '<div class="osp-overlay"></div>';

	}

	/**
	 * Social sharing links
	 *
	 * @since  1.0.0
	 */
	public function side_panel() {

		// Return if disabled
		if ( false == $this->if_side_panel() ) {
			return;
		}

		$file 		= $this->plugin_path . 'template/side-panel.php';
		$theme_file = get_stylesheet_directory() . '/templates/extra/side-panel.php';

		if ( file_exists( $theme_file ) ) {
			$file = $theme_file;
		}

		if ( file_exists( $file ) ) {
			include $file;
		}

	}

	/**
	 * Add css in head tag.
	 *
	 * @since  1.0.0
	 */
	public function head_css( $output ) {
		
		// Global vars
		$beside_open_btn_icon_size 			= get_theme_mod( 'osp_beside_open_btn_icon_size', '20' );
		$beside_open_btn_bg 				= get_theme_mod( 'osp_beside_open_btn_bg', '#ffffff' );
		$beside_open_btn_color 				= get_theme_mod( 'osp_beside_open_btn_color', '#13aff0' );
		$beside_open_btn_border_color 		= get_theme_mod( 'osp_beside_open_btn_border_color', '#eaeaea' );
		$open_btn_color 					= get_theme_mod( 'osp_side_panel_open_btn_color' );
		$open_btn_hover_color 				= get_theme_mod( 'osp_side_panel_open_btn_hover_color' );
		$custom_open_btn_color 				= get_theme_mod( 'osp_side_panel_custom_open_btn_color', '#000000' );
		$panel_width 						= get_theme_mod( 'osp_side_panel_width', '300' );
		$panel_width_tablet					= get_theme_mod( 'osp_side_panel_width_tablet' );
		$panel_width_mobile					= get_theme_mod( 'osp_side_panel_width_mobile' );
		$top_padding 						= get_theme_mod( 'osp_top_padding', '20' );
		$right_padding 						= get_theme_mod( 'osp_right_padding', '30' );
		$bottom_padding 					= get_theme_mod( 'osp_bottom_padding', '30' );
		$left_padding 						= get_theme_mod( 'osp_left_padding', '30' );
		$tablet_top_padding 				= get_theme_mod( 'osp_tablet_top_padding' );
		$tablet_right_padding 				= get_theme_mod( 'osp_tablet_right_padding' );
		$tablet_bottom_padding 				= get_theme_mod( 'osp_tablet_bottom_padding' );
		$tablet_left_padding 				= get_theme_mod( 'osp_tablet_left_padding' );
		$mobile_top_padding 				= get_theme_mod( 'osp_mobile_top_padding' );
		$mobile_right_padding 				= get_theme_mod( 'osp_mobile_right_padding' );
		$mobile_bottom_padding 				= get_theme_mod( 'osp_mobile_bottom_padding' );
		$mobile_left_padding 				= get_theme_mod( 'osp_mobile_left_padding' );
		$overlay 							= get_theme_mod( 'osp_side_panel_overlay_color', 'rgba(0,0,0,0.3)' );
		$background 						= get_theme_mod( 'osp_side_panel_bg', '#1b1b1b' );
		$close_button_bg 					= get_theme_mod( 'osp_close_button_bg', '#111111' );
		$close_button_hover_bg 				= get_theme_mod( 'osp_close_button_hover_bg', '#111111' );
		$close_button_color 				= get_theme_mod( 'osp_close_button_color', '#dddddd' );
		$close_button_hover_color 			= get_theme_mod( 'osp_close_button_hover_color', '#ffffff' );
		$text_color 						= get_theme_mod( 'osp_text_color', '#888888' );
		$headings_color 					= get_theme_mod( 'osp_headings_color', '#ffffff' );
		$links_color 						= get_theme_mod( 'osp_links_color', '#888888' );
		$links_hover_color 					= get_theme_mod( 'osp_links_hover_color', '#ffffff' );
		$list_border_color 					= get_theme_mod( 'osp_list_border_color', '#555555' );
		$breakpoint 						= get_theme_mod( 'osp_side_panel_breakpoints', '959' );
		$custom_breakpoint 					= get_theme_mod( 'osp_side_panel_custom_breakpoint' );

		// Define css var
		$css = '';

		// Add beside opening btn icon size
		if ( ! empty( $beside_open_btn_icon_size ) && '20' != $beside_open_btn_icon_size ) {
			$css .= '#side-panel-wrap a.side-panel-btn{font-size:'. $beside_open_btn_icon_size .'px;}';
		}

		// Add beside opening btn background color
		if ( ! empty( $beside_open_btn_bg ) && '#ffffff' != $beside_open_btn_bg ) {
			$css .= '#side-panel-wrap a.side-panel-btn{background-color:'. $beside_open_btn_bg .';}';
		}

		// Add beside opening btn color
		if ( ! empty( $beside_open_btn_color ) && '#13aff0' != $beside_open_btn_color ) {
			$css .= '#side-panel-wrap a.side-panel-btn, #side-panel-wrap a.side-panel-btn:hover{color:'. $beside_open_btn_color .';}';
		}

		// Add beside opening btn border color
		if ( ! empty( $beside_open_btn_border_color ) && '#eaeaea' != $beside_open_btn_border_color ) {
			$css .= '#side-panel-wrap a.side-panel-btn{border-color: '. $beside_open_btn_border_color .';}';
		}

		// Add beside opening btn border color
		if ( ! empty( $open_btn_color ) ) {
			$css .= '.side-panel-btn, #site-navigation-wrap .dropdown-menu > li > a.side-panel-btn{color: '. $open_btn_color .';}';
		}

		// Add beside opening btn border color
		if ( ! empty( $open_btn_hover_color ) ) {
			$css .= '.side-panel-btn:hover, #site-navigation-wrap .dropdown-menu > li > a.side-panel-btn:hover{color: '. $open_btn_hover_color .';}';
		}

		// Add custom opening btn color
		if ( ! empty( $custom_open_btn_color ) && '#000000' != $custom_open_btn_color ) {
			$css .= '.side-panel-btn .hamburger-inner, .side-panel-btn .hamburger-inner::before, .side-panel-btn .hamburger-inner::after{background-color: '. $custom_open_btn_color .';}';
		}

		// Add panel width
		if ( ! empty( $panel_width ) && '300' != $panel_width ) {
			$css .= '#side-panel-wrap{width:'. $panel_width .'px;}.osp-right #side-panel-wrap{right:-'. $panel_width .'px;}.osp-right.osp-opened #outer-wrap{left:-'. $panel_width .'px;}.osp-left #side-panel-wrap{left:-'. $panel_width .'px;}.osp-left.osp-opened #outer-wrap{right:-'. $panel_width .'px;}';
		}

		// Add panel width tablet
		if ( ! empty( $panel_width_tablet ) ) {
			$css .= '@media (max-width: 768px){#side-panel-wrap{width:'. $panel_width_tablet .'px;}.osp-right #side-panel-wrap{right:-'. $panel_width_tablet .'px;}.osp-right.osp-opened #outer-wrap{left:-'. $panel_width_tablet .'px;}.osp-left #side-panel-wrap{left:-'. $panel_width_tablet .'px;}.osp-left.osp-opened #outer-wrap{right:-'. $panel_width_tablet .'px;}}';
		}

		// Add panel width mobile
		if ( ! empty( $panel_width_mobile ) ) {
			$css .= '@media (max-width: 480px){#side-panel-wrap{width:'. $panel_width_mobile .'px;}.osp-right #side-panel-wrap{right:-'. $panel_width_mobile .'px;}.osp-right.osp-opened #outer-wrap{left:-'. $panel_width_mobile .'px;}.osp-left #side-panel-wrap{left:-'. $panel_width_mobile .'px;}.osp-left.osp-opened #outer-wrap{right:-'. $panel_width_mobile .'px;}}';
		}

		// Padding
		if ( isset( $top_padding ) && '30' != $top_padding && '' != $top_padding
			|| isset( $right_padding ) && '30' != $right_padding && '' != $right_padding
			|| isset( $bottom_padding ) && '30' != $bottom_padding && '' != $bottom_padding
			|| isset( $left_padding ) && '30' != $left_padding && '' != $left_padding ) {
			$css .= '#side-panel-wrap #side-panel-content{padding:'. oceanwp_spacing_css( $top_padding, $right_padding, $bottom_padding, $left_padding ) .'}';
		}

		// Tablet padding
		if ( isset( $tablet_top_padding ) && '' != $tablet_top_padding
			|| isset( $tablet_right_padding ) && '' != $tablet_right_padding
			|| isset( $tablet_bottom_padding ) && '' != $tablet_bottom_padding
			|| isset( $tablet_left_padding ) && '' != $tablet_left_padding ) {
			$css .= '@media (max-width: 768px){#side-panel-wrap #side-panel-content{padding:'. oceanwp_spacing_css( $tablet_top_padding, $tablet_right_padding, $tablet_bottom_padding, $tablet_left_padding ) .'}}';
		}

		// Mobile padding
		if ( isset( $mobile_top_padding ) && '' != $mobile_top_padding
			|| isset( $mobile_right_padding ) && '' != $mobile_right_padding
			|| isset( $mobile_bottom_padding ) && '' != $mobile_bottom_padding
			|| isset( $mobile_left_padding ) && '' != $mobile_left_padding ) {
			$css .= '@media (max-width: 480px){#side-panel-wrap #side-panel-content{padding:'. oceanwp_spacing_css( $mobile_top_padding, $mobile_right_padding, $mobile_bottom_padding, $mobile_left_padding ) .'}}';
		}

		// Add overlay color
		if ( ! empty( $overlay ) && 'rgba(0,0,0,0.3)' != $overlay ) {
			$css .= '.osp-overlay{background-color:'. $overlay .';}';
		}

		// Add background color
		if ( ! empty( $background ) && '#1b1b1b' != $background ) {
			$css .= '#side-panel-wrap{background-color:'. $background .';}';
		}

		// Add close button background color
		if ( ! empty( $close_button_bg ) && '#111111' != $close_button_bg ) {
			$css .= '#side-panel-wrap a.close-panel{background-color:'. $close_button_bg .';}';
		}

		// Add close button hover background color
		if ( ! empty( $close_button_hover_bg ) && '#111111' != $close_button_hover_bg ) {
			$css .= '#side-panel-wrap a.close-panel:hover{background-color:'. $close_button_hover_bg .';}';
		}

		// Add close button color
		if ( ! empty( $close_button_color ) && '#dddddd' != $close_button_color ) {
			$css .= '#side-panel-wrap a.close-panel{color:'. $close_button_color .';}';
		}

		// Add close button hover color
		if ( ! empty( $close_button_hover_color ) && '#ffffff' != $close_button_hover_color ) {
			$css .= '#side-panel-wrap a.close-panel:hover{color:'. $close_button_hover_color .';}';
		}

		// Add text color
		if ( ! empty( $text_color ) && '#888888' != $text_color ) {
			$css .= '#side-panel-wrap,#side-panel-wrap p,#side-panel-wrap #wp-calendar caption,#side-panel-wrap #wp-calendar th,#side-panel-wrap #wp-calendar td{color:'. $text_color .';}';
		}

		// Add headings color
		if ( ! empty( $headings_color ) && '#ffffff' != $headings_color ) {
			$css .= '#side-panel-wrap h1,#side-panel-wrap h2,#side-panel-wrap h3,#side-panel-wrap h4,#side-panel-wrap h5,#side-panel-wrap h6,#side-panel-wrap .sidebar-box .panel-widget-title{color:'. $headings_color .';}';
		}

		// Add links color
		if ( ! empty( $links_color ) && '#888888' != $links_color ) {
			$css .= '#side-panel-wrap a{color:'. $links_color .';}';
		}

		// Add links hover color
		if ( ! empty( $links_hover_color ) && '#ffffff' != $links_hover_color ) {
			$css .= '#side-panel-wrap a:hover{color:'. $links_hover_color .';}';
		}

		// Add list border color
		if ( ! empty( $list_border_color ) && '#555555' != $list_border_color ) {
			$css .= '#side-panel-wrap .ocean-widget-recent-posts-li,#side-panel-wrap .widget_categories li,#side-panel-wrap .widget_recent_entries li,#side-panel-wrap .widget_archive li,#side-panel-wrap .widget_recent_comments li,#side-panel-wrap .widget_layered_nav li,#side-panel-wrap .widget-recent-posts-icons li,#side-panel-wrap .ocean-widget-recent-posts-li:first-child,#side-panel-wrap .widget_categories li:first-child,#side-panel-wrap .widget_recent_entries li:first-child,#side-panel-wrap .widget_archive li:first-child,#side-panel-wrap .widget_recent_comments li:first-child,#side-panel-wrap .widget_layered_nav li:first-child,#side-panel-wrap .widget-recent-posts-icons li:first-child{border-color:'. $list_border_color .';}';
		}

		// Breakpoint
		if ( ! empty( $breakpoint ) && '959' != $breakpoint ) {

			if ( 'custom' == $breakpoint && ! empty( $custom_breakpoint ) && '959' != $custom_breakpoint ) {
				$breakpoint = $custom_breakpoint;
			}

			$css .= '@media (max-width: '. $breakpoint .'px) {li.side-panel-li,#side-panel-wrap, .oceanwp-mobile-menu-icon a.side-panel-btn { display: none !important; }}';
		}
			
		// Return CSS
		if ( ! empty( $css ) ) {
			$output .= '/* Side Panel CSS */'. $css;
		}

		// Return output css
		return $output;

	}

} // End Class