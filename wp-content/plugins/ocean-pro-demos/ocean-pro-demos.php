<?php
/**
 * Plugin Name:			Ocean Pro Demos
 * Description:			Import the OceanWP pro demos, widgets and customizer settings with one click.
 * Version:				1.0.6
 * Author:				OceanWP
 * Author URI:			https://oceanwp.org/
 * Requires at least:	4.0.0
 * Tested up to:		4.9.6
 *
 * Text Domain: ocean-pro-demos
 * Domain Path: /languages/
 *
 * @package Ocean_Pro_Demos
 * @category Core
 * @author OceanWP
 * @see This plugin is based on: https://github.com/proteusthemes/one-click-demo-import/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the main instance of Ocean_Pro_Demos to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Ocean_Pro_Demos
 */
function Ocean_Pro_Demos() {
	return Ocean_Pro_Demos::instance();
} // End Ocean_Pro_Demos()

Ocean_Pro_Demos();

/**
 * Main Ocean_Pro_Demos Class
 *
 * @class Ocean_Pro_Demos
 * @version	1.0.0
 * @since 1.0.0
 * @package	Ocean_Pro_Demos
 */
final class Ocean_Pro_Demos {
	/**
	 * Ocean_Pro_Demos The single instance of Ocean_Pro_Demos.
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
		$this->token 			= 'ocean-pro-demos';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.6';

		define( 'OPD_PATH', $this->plugin_path );
		define( 'OPD_URL', $this->plugin_url );

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'updater' ), 1 );

		// Add pro demos in the demos page
		add_filter( 'owp_demos_data', array( $this, 'get_pro_demos' ) );
	}

	/**
	 * Initialize License Updater.
	 * Load Updater initialize.
	 * @return void
	 */
	public function updater() {

		// Plugin Updater Code
		if ( class_exists( 'OceanWP_Plugin_Updater' ) ) {
			$license	= new OceanWP_Plugin_Updater( __FILE__, 'Pro Demos', $this->version, 'OceanWP' );
		}
	}

	/**
	 * Main Ocean_Pro_Demos Instance
	 *
	 * Ensures only one instance of Ocean_Pro_Demos is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Ocean_Pro_Demos()
	 * @return Main Ocean_Pro_Demos instance
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
		load_plugin_textdomain( 'ocean-pro-demos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
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
	 * Get pro demos.
	 * 
	 * @since   1.0.0
	 */
	public static function get_pro_demos( $data ) {

		// Demos url
		$url = OPD_URL . '/demos/';

		$data['construction'] = array(
			'categories'        => array( 'Corporate' ),
			'xml_file'     		=> $url . 'construction/sample-data.xml',
			'theme_settings' 	=> $url . 'construction/oceanwp-export.json',
			'widgets_file'  	=> $url . 'construction/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-portfolio',
						'init'  	=> 'ocean-portfolio/ocean-portfolio.php',
						'name' 		=> 'Ocean Portfolio',
					),
					array(
						'slug' 		=> 'ocean-sticky-footer',
						'init'  	=> 'ocean-sticky-footer/ocean-sticky-footer.php',
						'name' 		=> 'Ocean Sticky Footer',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['coffee'] = array(
			'categories'        => array( 'Corporate' ),
			'xml_file'     		=> $url . 'coffee/sample-data.xml',
			'theme_settings' 	=> $url . 'coffee/oceanwp-export.json',
			'widgets_file'  	=> $url . 'coffee/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-instagram',
						'init'  	=> 'ocean-instagram/ocean-instagram.php',
						'name' 		=> 'Ocean Instagram',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['hosting'] = array(
			'categories'        => array( 'Corporate' ),
			'xml_file'     		=> $url . 'hosting/sample-data.xml',
			'theme_settings' 	=> $url . 'hosting/oceanwp-export.json',
			'widgets_file'  	=> $url . 'hosting/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-modal-window',
						'init'  	=> 'ocean-modal-window/ocean-modal-window.php',
						'name'  	=> 'Ocean Modal Window',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['medical'] = array(
			'categories'        => array( 'Corporate' ),
			'xml_file'     		=> $url . 'medical/sample-data.xml',
			'theme_settings' 	=> $url . 'medical/oceanwp-export.json',
			'widgets_file'  	=> $url . 'medical/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-footer-callout',
						'init'  	=> 'ocean-footer-callout/ocean-footer-callout.php',
						'name' 		=> 'Ocean Footer Callout',
					),
					array(
						'slug' 		=> 'ocean-side-panel',
						'init'  	=> 'ocean-side-panel/ocean-side-panel.php',
						'name' 		=> 'Ocean Side Panel',
					),
				),
			),
		);

		$data['photography'] = array(
			'categories'        => array( 'Corporate' ),
			'xml_file'     		=> $url . 'photography/sample-data.xml',
			'theme_settings' 	=> $url . 'photography/oceanwp-export.json',
			'widgets_file'  	=> $url . 'photography/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '6',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-portfolio',
						'init'  	=> 'ocean-portfolio/ocean-portfolio.php',
						'name' 		=> 'Ocean Portfolio',
					),
				),
			),
		);

		$data['wedding'] = array(
			'categories'        => array( 'Corporate' ),
			'xml_file'     		=> $url . 'wedding/sample-data.xml',
			'theme_settings' 	=> $url . 'wedding/oceanwp-export.json',
			'widgets_file'  	=> $url . 'wedding/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '5',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-popup-login',
						'init'  	=> 'ocean-popup-login/ocean-popup-login.php',
						'name' 		=> 'Ocean Popup Login',
					),
					array(
						'slug' 		=> 'ocean-portfolio',
						'init'  	=> 'ocean-portfolio/ocean-portfolio.php',
						'name' 		=> 'Ocean Portfolio',
					),
				),
			),
		);

		$data['spa'] = array(
			'categories'        => array( 'One Page' ),
			'xml_file'     		=> $url . 'spa/sample-data.xml',
			'theme_settings' 	=> $url . 'spa/oceanwp-export.json',
			'widgets_file'  	=> $url . 'spa/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['restaurant'] = array(
			'categories'        => array( 'One Page' ),
			'xml_file'     		=> $url . 'restaurant/sample-data.xml',
			'theme_settings' 	=> $url . 'restaurant/oceanwp-export.json',
			'widgets_file'  	=> $url . 'restaurant/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
				),
			),
		);

		$data['chocolate'] = array(
			'categories'        => array( 'One Page' ),
			'xml_file'     		=> $url . 'chocolate/sample-data.xml',
			'theme_settings' 	=> $url . 'chocolate/oceanwp-export.json',
			'widgets_file'  	=> $url . 'chocolate/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-sticky-footer',
						'init'  	=> 'ocean-sticky-footer/ocean-sticky-footer.php',
						'name' 		=> 'Ocean Sticky Footer',
					),
				),
			),
		);

		$data['hotel'] = array(
			'categories'        => array( 'One Page' ),
			'xml_file'     		=> $url . 'hotel/sample-data.xml',
			'theme_settings' 	=> $url . 'hotel/oceanwp-export.json',
			'widgets_file'  	=> $url . 'hotel/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
				),
			),
		);

		$data['book'] = array(
			'categories'        => array( 'eCommerce' ),
			'xml_file'     		=> $url . 'book/sample-data.xml',
			'theme_settings' 	=> $url . 'book/oceanwp-export.json',
			'widgets_file'  	=> $url . 'book/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '4',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
					array(
						'slug'  	=> 'easy-digital-downloads',
						'init'  	=> 'easy-digital-downloads/easy-digital-downloads.php',
						'name'  	=> 'Easy Digital Downloads',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-popup-login',
						'init'  	=> 'ocean-popup-login/ocean-popup-login.php',
						'name' 		=> 'Ocean Popup Login',
					),
					array(
						'slug' 		=> 'ocean-woo-popup',
						'init'  	=> 'ocean-woo-popup/ocean-woo-popup.php',
						'name' 		=> 'Ocean Woo Popup',
					),
				),
			),
		);

		$data['jewelry'] = array(
			'categories'        => array( 'eCommerce' ),
			'xml_file'     		=> $url . 'jewelry/sample-data.xml',
			'theme_settings' 	=> $url . 'jewelry/oceanwp-export.json',
			'widgets_file'  	=> $url . 'jewelry/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1260',
			'is_shop'  			=> true,
			'woo_image_size'  	=> '600',
			'woo_thumb_size' 	=> '300',
			'woo_crop_width'  	=> '1',
			'woo_crop_height' 	=> '1',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-product-sharing',
						'init'  	=> 'ocean-product-sharing/ocean-product-sharing.php',
						'name'  	=> 'Ocean Product Sharing',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
					array(
						'slug'  	=> 'woocommerce',
						'init'  	=> 'woocommerce/woocommerce.php',
						'name'  	=> 'WooCommerce',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-footer-callout',
						'init'  	=> 'ocean-footer-callout/ocean-footer-callout.php',
						'name' 		=> 'Ocean Footer Callout',
					),
					array(
						'slug' 		=> 'ocean-woo-popup',
						'init'  	=> 'ocean-woo-popup/ocean-woo-popup.php',
						'name' 		=> 'Ocean Woo Popup',
					),
				),
			),
		);

		$data['shoes'] = array(
			'categories'        => array( 'eCommerce' ),
			'xml_file'     		=> $url . 'shoes/sample-data.xml',
			'theme_settings' 	=> $url . 'shoes/oceanwp-export.json',
			'widgets_file'  	=> $url . 'shoes/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1320',
			'is_shop'  			=> true,
			'woo_image_size'  	=> '600',
			'woo_thumb_size' 	=> '316',
			'woo_crop_width'  	=> '4',
			'woo_crop_height' 	=> '5',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-product-sharing',
						'init'  	=> 'ocean-product-sharing/ocean-product-sharing.php',
						'name'  	=> 'Ocean Product Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
					array(
						'slug'  	=> 'woocommerce',
						'init'  	=> 'woocommerce/woocommerce.php',
						'name'  	=> 'WooCommerce',
					),
					array(
						'slug'  	=> 'ti-woocommerce-wishlist',
						'init'  	=> 'ti-woocommerce-wishlist/ti-woocommerce-wishlist.php',
						'name'  	=> 'WooCommerce Wishlist',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-footer-callout',
						'init'  	=> 'ocean-footer-callout/ocean-footer-callout.php',
						'name' 		=> 'Ocean Footer Callout',
					),
					array(
						'slug' 		=> 'ocean-popup-login',
						'init'  	=> 'ocean-popup-login/ocean-popup-login.php',
						'name' 		=> 'Ocean Popup Login',
					),
				),
			),
		);

		$data['flowers'] = array(
			'categories'        => array( 'eCommerce' ),
			'xml_file'     		=> $url . 'flowers/sample-data.xml',
			'theme_settings' 	=> $url . 'flowers/oceanwp-export.json',
			'widgets_file'  	=> $url . 'flowers/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1220',
			'is_shop'  			=> true,
			'woo_image_size'  	=> '478',
			'woo_thumb_size' 	=> '294',
			'woo_crop_width'  	=> '4',
			'woo_crop_height' 	=> '5',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-product-sharing',
						'init'  	=> 'ocean-product-sharing/ocean-product-sharing.php',
						'name'  	=> 'Ocean Product Sharing',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
					array(
						'slug'  	=> 'woocommerce',
						'init'  	=> 'woocommerce/woocommerce.php',
						'name'  	=> 'WooCommerce',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['garden'] = array(
			'categories'        => array( 'eCommerce' ),
			'xml_file'     		=> $url . 'garden/sample-data.xml',
			'theme_settings' 	=> $url . 'garden/oceanwp-export.json',
			'widgets_file'  	=> $url . 'garden/widgets.wie',
			'home_title'  		=> 'Home',
			'blog_title'  		=> 'Blog',
			'posts_to_show'  	=> '3',
			'elementor_width'  	=> '1220',
			'is_shop'  			=> true,
			'woo_image_size'  	=> '441',
			'woo_thumb_size' 	=> '270',
			'woo_crop_width'  	=> '4',
			'woo_crop_height' 	=> '5',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'ocean-product-sharing',
						'init'  	=> 'ocean-product-sharing/ocean-product-sharing.php',
						'name'  	=> 'Ocean Product Sharing',
					),
					array(
						'slug'  	=> 'ocean-social-sharing',
						'init'  	=> 'ocean-social-sharing/ocean-social-sharing.php',
						'name'  	=> 'Ocean Social Sharing',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
					array(
						'slug'  	=> 'woocommerce',
						'init'  	=> 'woocommerce/woocommerce.php',
						'name'  	=> 'WooCommerce',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-sticky-header',
						'init'  	=> 'ocean-sticky-header/ocean-sticky-header.php',
						'name' 		=> 'Ocean Sticky Header',
					),
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
					array(
						'slug' 		=> 'ocean-footer-callout',
						'init'  	=> 'ocean-footer-callout/ocean-footer-callout.php',
						'name' 		=> 'Ocean Footer Callout',
					),
				),
			),
		);

		$data['electronic'] = array(
			'categories'        => array( 'Coming Soon' ),
			'xml_file'     		=> $url . 'electronic/sample-data.xml',
			'theme_settings' 	=> $url . 'electronic/oceanwp-export.json',
			'widgets_file'  	=> $url . 'electronic/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['fashion'] = array(
			'categories'        => array( 'Coming Soon' ),
			'xml_file'     		=> $url . 'fashion/sample-data.xml',
			'theme_settings' 	=> $url . 'fashion/oceanwp-export.json',
			'widgets_file'  	=> $url . 'fashion/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['food'] = array(
			'categories'        => array( 'Coming Soon' ),
			'xml_file'     		=> $url . 'food/sample-data.xml',
			'theme_settings' 	=> $url . 'food/oceanwp-export.json',
			'widgets_file'  	=> $url . 'food/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['gaming'] = array(
			'categories'        => array( 'Coming Soon' ),
			'xml_file'     		=> $url . 'gaming/sample-data.xml',
			'theme_settings' 	=> $url . 'gaming/oceanwp-export.json',
			'widgets_file'  	=> $url . 'gaming/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		$data['pink'] = array(
			'categories'        => array( 'Coming Soon' ),
			'xml_file'     		=> $url . 'pink/sample-data.xml',
			'theme_settings' 	=> $url . 'pink/oceanwp-export.json',
			'widgets_file'  	=> $url . 'pink/widgets.wie',
			'home_title'  		=> 'Home',
			'elementor_width'  	=> '1220',
			'required_plugins'  => array(
				'free' => array(
					array(
						'slug'  	=> 'ocean-extra',
						'init'  	=> 'ocean-extra/ocean-extra.php',
						'name'  	=> 'Ocean Extra',
					),
					array(
						'slug'  	=> 'elementor',
						'init'  	=> 'elementor/elementor.php',
						'name'  	=> 'Elementor',
					),
					array(
						'slug'  	=> 'contact-form-7',
						'init'  	=> 'contact-form-7/wp-contact-form-7.php',
						'name'  	=> 'Contact Form 7',
					),
				),
				'premium' => array(
					array(
						'slug' 		=> 'ocean-elementor-widgets',
						'init'  	=> 'ocean-elementor-widgets/ocean-elementor-widgets.php',
						'name' 		=> 'Ocean Elementor Widgets',
					),
				),
			),
		);

		// Return
		return $data;

	}

} // End Class
