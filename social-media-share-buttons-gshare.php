<?php
/**
 * Plugin Name:       Social Media Share Buttons - Gshare
 * Plugin URI:        https://wppool.dev/social-media-share-button/
 * Description:       Social media share buttons with extended features, support and global setting option including gutenberg block and Elementor widget.
 * Version:           1.2.1
 * Author:            WPPOOL
 * Author URI:        https://wppool.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gshare
 * Requires at least: 5.0
 * Tested up to: 	  5.4
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Make sure the same class is not loaded twice in free/premium versions.
if ( ! class_exists( 'Gshare_Social' ) ) {
	/**
	 * Main Gshare Class
	 *
	 * The main class that initiates and runs the Gshare plugin.
	 *
	 * @since 1.0.0
	 */
	final class Gshare_Social {
		/**
		 * Instance
		 *
		 * Holds a single instance of the `Gshare_Social` class.
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 * @var Gshare_Social A single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Has_Pro
		 *
		 * Holds the boolean value for pro version.
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 */
		private static $has_pro = false;

		/**
		 * Keep the boolean value whethter pro version is enable or not
		 */
		public static function is_pro_installed()
		{
			if( defined( 'GSHARE_PRO_VERSION' ) ) {
				self::$has_pro = true;
			}

			return self::$has_pro;
		}

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @return Gshare_Social An instance of the class.
		 * @since 1.0.0
		 *
		 * @access public
		 * @static
		 *
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Clone
		 *
		 * Disable class cloning.
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 * @access protected
		 *
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'gshare' ), '1.0.0' );
		}

		/**
		 * Wakeup
		 *
		 * Disable unserializing the class.
		 *
		 * @return void
		 * @since 1.7.0
		 *
		 * @access protected
		 *
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'gshare' ), '1.0.0' );
		}

		/**
		 * Constructor
		 *
		 * Initialize the Gshare plugins.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			/**
			 * Constant for the plugins
			 */
			define( 'GSHARE_VERSION', '1.0.1' );
			define( 'GSHARE_FILE_PATH', plugin_dir_path( __FILE__ ) );
			define( 'GSHARE_URL', plugins_url( '', __FILE__ ) );
			register_activation_hook( __FILE__, [ $this, 'gshare_activate' ] );

			$this->addons_includes();

			do_action( 'gshare_loaded' );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
			$this->init_elementor();
			$this->init_tracker();
		}

		public function gshare_activate(){
			update_option('gshare_version', GSHARE_VERSION );
		}

		/**
		 * Include Files
		 *
		 * Load core files required to run the plugin.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function addons_includes() {
			require_once( GSHARE_FILE_PATH . 'inc/admin-settings.php' );
			require_once( GSHARE_FILE_PATH . 'views/template.php' );
			if(Gshare_Social::is_pro_installed()){
				require_once( GSHARE_PRO_FILE_PATH . 'views/init.php' );
			} else {
				require_once( GSHARE_FILE_PATH . 'views/init.php' );
			}
		}

		public function init_elementor() {
			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				return;
			}
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'el_widgets_registered' ] );
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'el_enqueue_preview_styles' ] );
		}

		public function el_widgets_registered() {
			$this->el_include_widgets();
			$this->el_register_widgets();
		}

		private function el_include_widgets() {
			require_once __DIR__ . '/views/elementor.php';
		}

		private function el_register_widgets() {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Gshare\Widgets\Gshare_Elementor() );
		}

		public function el_enqueue_preview_styles(){
			if (! Gshare_Social::is_pro_installed() ) {
				wp_enqueue_style('gshare-el-preview', GSHARE_URL . '/assets/css/el-style.css', array(), filemtime( plugin_dir_path( __FILE__ ) . '/assets/css/el-style.css' ) );
			} else {
				wp_enqueue_style('gshare-el-preview', GSHARE_PRO_URL . '/assets/css/el-style.css', array(), filemtime( GSHARE_PRO_FILE_PATH . '/assets/css/el-style.css' ) );
			}			
		}

		/**
		 * Initialize the plugin tracker
		 *
		 * @return void
		 */
		function init_tracker() {

			if ( ! class_exists( 'Appsero\Client' ) ) {
				require_once __DIR__ . '/appsero/src/Client.php';
			}

			$client = new Appsero\Client( '8fd56e38-84f0-4b0b-95af-a6968c45bfd9', 'Social Media Share Buttons Plugin &#8211; Gshare', __FILE__ );

			// Active insights
			$client->insights()->init();

		}


		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain( 'gshare', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Admin Enqueue 
		 */
		public function admin_scripts() {
			wp_enqueue_style( 'fontawesome', GSHARE_URL . '/assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'admin', GSHARE_URL . '/assets/css/admin.css', array(), filemtime( plugin_dir_path( __FILE__ ) . '/assets/css/admin.css' ) );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script('jquery-form');
			wp_register_script( 'gshare-admin-js', GSHARE_URL . '/assets/js/app.js', array('jquery', 'wp-color-picker'), filemtime( plugin_dir_path( __FILE__ ) . '/assets/js/app.js' ) );
			wp_localize_script( 'gshare-admin-js', 'gshare_setting_params', array(
				'save_success' => __('Settings saved successfully', 'gshare'),
				'save_error' => __('There was a problem. Try again', 'gshare'),
				'save_processing' => __('Settings saving', 'gshare'),
			) ); 
			wp_enqueue_script( 'gshare-admin-js' ); 
		}
	}
}

if ( ! function_exists( 'gshare_social_load' ) ) {
	/**
	 * Load Gshare
	 *
	 * Main instance of Gshare_Social.
	 *
	 * @since 1.0.0
	 */
	function gshare_social_load() {
		return Gshare_Social::instance();
	}

	// Run Gshare
	gshare_social_load();
}