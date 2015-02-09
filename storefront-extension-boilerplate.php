<?php
/**
 * Plugin Name:			Storefront Extension Boilerplate
 * Plugin URI:			http://woothemes.com/products/storefront-extension-boilerplate/
 * Description:			A boilerplate plugin for creating Storefront extensions.
 * Version:				1.0.0
 * Author:				WooThemes
 * Author URI:			http://woothemes.com/
 * Requires at least:	4.0.0
 * Tested up to:		4.0.0
 *
 * Text Domain: storefront-extension-boilerplate
 * Domain Path: /languages/
 *
 * @package Storefront_Extension_Boilerplate
 * @category Core
 * @author James Koster
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Sold On Woo - Start
/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) ) {
	require_once( 'woo-includes/woo-functions.php' );
}

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), 'FILE_ID', 'PRODUCT_ID' );
// Sold On Woo - End

/**
 * Returns the main instance of Storefront_Extension_Boilerplate to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Storefront_Extension_Boilerplate
 */
function Storefront_Extension_Boilerplate() {
	return Storefront_Extension_Boilerplate::instance();
} // End Storefront_Extension_Boilerplate()

Storefront_Extension_Boilerplate();

/**
 * Main Storefront_Extension_Boilerplate Class
 *
 * @class Storefront_Extension_Boilerplate
 * @version	1.0.0
 * @since 1.0.0
 * @package	Storefront_Extension_Boilerplate
 */
final class Storefront_Extension_Boilerplate {
	/**
	 * Storefront_Extension_Boilerplate The single instance of Storefront_Extension_Boilerplate.
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
	public function __construct() {
		$this->token 			= 'storefront-extension-boilerplate';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'seb_load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'seb_setup' ) );

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'seb_plugin_links' ) );
	}

	/**
	 * Main Storefront_Extension_Boilerplate Instance
	 *
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Storefront_Extension_Boilerplate()
	 * @return Main Storefront_Extension_Boilerplate instance
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
	public function seb_load_plugin_textdomain() {
		load_plugin_textdomain( 'storefront-extension-boilerplate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
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
	 * Plugin page links
	 *
	 * @since  1.0.0
	 */
	public function seb_plugin_links( $links ) {
		$plugin_links = array(
			'<a href="http://support.woothemes.com/">' . __( 'Support', 'storefront-extension-boilerplate' ) . '</a>',
			'<a href="http://docs.woothemes.com/document/storefront-extension-boilerplate/">' . __( 'Docs', 'storefront-extension-boilerplate' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
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

		// get theme customizer url
		$url = admin_url() . 'customize.php?';
		$url .= 'url=' . urlencode( site_url() . '?storefront-customizer=true' ) ;
		$url .= '&return=' . urlencode( admin_url() . 'plugins.php' );
		$url .= '&storefront-customizer=true';

		$notices 		= get_option( 'seb_activation_notice', array() );
		$notices[]		= sprintf( __( '%sThanks for installing the Storefront Extension Boilerplate extension. To get started, visit the %sCustomizer%s.%s %sOpen the Customizer%s', 'storefront-extension-boilerplate' ), '<p>', '<a href="' . esc_url( $url ) . '">', '</a>', '</p>', '<p><a href="' . esc_url( $url ) . '" class="button button-primary">', '</a></p>' );

		update_option( 'seb_activation_notice', $notices );
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
	 * Only executes if Storefront or a child theme using Storefront as a parent is active and the extension specific filter returns true.
	 * Child themes can disable this extension using the storefront_extension_boilerplate_enabled filter
	 * @return void
	 */
	public function seb_setup() {
		$theme = wp_get_theme();

		if ( 'Storefront' == $theme->name || 'storefront' == $theme->template && apply_filters( 'storefront_extension_boilerplate_supported', true ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'seb_styles' ), 999 );
			add_action( 'customize_register', array( $this, 'seb_customize_register' ) );
			add_action( 'customize_preview_init', array( $this, 'seb_customize_preview_js' ) );
			add_filter( 'body_class', array( $this, 'seb_body_class' ) );
			add_action( 'wp', array( $this, 'seb_layout_adjustments' ), 999 );
			add_action( 'admin_notices', array( $this, 'seb_customizer_notice' ) );

			// Hide the 'More' section in the customizer
			add_filter( 'storefront_customizer_more', '__return_false' );
		}
	}

	/**
	 * Admin notice
	 * Checks the notice setup in install(). If it exists display it then delete the option so it's not displayed again.
	 * @since   1.0.0
	 * @return  void
	 */
	public function seb_customizer_notice() {
		$notices = get_option( 'seb_activation_notice' );

		if ( $notices = get_option( 'seb_activation_notice' ) ) {

			foreach ( $notices as $notice ) {
				echo '<div class="updated">' . $notice . '</div>';
			}

			delete_option( 'seb_activation_notice' );
		}
	}

	/**
	 * Customizer Controls and settings
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function seb_customize_register( $wp_customize ) {

		/**
		 * Custom controls
		 * Load custom control classes
		 */
		require_once dirname( __FILE__ ) . '/includes/class-storefront-extension-boilerplate-images-control.php';

		/**
		 * Modify existing controls
		 */
		// Note: If you want to modiy existing controls, do it this way. You can set defaults, change the transport, etc.
		//$wp_customize->get_setting( 'storefront_header_background_color' )->transport = 'refresh';

		/**
	     * Add a new section
	     */
        $wp_customize->add_section( 'seb_section' , array(
		    'title'      	=> __( 'Storefront Extension Boilerplate', 'storefront-extention-boilerplate' ),
		    'description' 	=> __( 'Add a description, if you want to!', 'storefront-extention-boilerplate' ),
		    'priority'   	=> 55,
		) );

		/**
		 * Image selector radios
		 * See class-control-images.php
		 */
		$wp_customize->add_setting( 'seb_image', array(
			'default'    		=> 'option-1',
			'sanitize_callback'	=> 'esc_attr'
		) );

		$wp_customize->add_control( new Storefront_Extension_Boilerplate_Images_Control( $wp_customize, 'seb_image', array(
			'label'    => __( 'Image selector', 'storefront' ),
			'section'  => 'seb_section',
			'settings' => 'seb_image',
			'priority' => 10,
		) ) );

		/**
		 * Add a divider.
		 * Type can be set to 'text' or 'heading' to display a title or description.
		 */
		if ( class_exists( 'Arbitrary_Storefront_Control' ) ) {
			$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'seb_divider', array(
				'section'  	=> 'seb_section',
				'type'		=> 'divider',
				'priority' 	=> 15,
			) ) );
		}

		/**
		 * Checkbox
		 */
		$wp_customize->add_setting( 'seb_checkbox', array(
			'default'			=> apply_filters( 'seb_checkbox_default', false ),
			'sanitize_callback'	=> 'absint',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'seb_checkbox', array(
			'label'			=> __( 'Checkbox', 'storefront-extension-boilerplate' ),
			'description'	=> __( 'Here\'s a simple boolean checkbox option. In this instance it toggles wrapping the main navigation in a wrapper div.', 'storefront-extension-boilerplate' ),
			'section'		=> 'seb_section',
			'settings'		=> 'seb_checkbox',
			'type'			=> 'checkbox',
			'priority'		=> 20,
		) ) );

		/**
		 * Color picker
		 */
		$wp_customize->add_setting( 'seb_color_picker', array(
			'default'			=> apply_filters( 'seb_color_picker_default', '#ff0000' ),
			'sanitize_callback'	=> 'sanitize_hex_color',
			'transport'			=> 'postMessage', // Refreshes instantly via js. See customizer.js. (default = refresh).
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'seb_color_picker', array(
			'label'			=> __( 'Color picker', 'storefront-extension-boilerplate' ),
			'description'	=> __( 'Here\'s an example color picker. In this instance it applies a background color to headings', 'storefront-extension-boilerplate' ),
			'section'		=> 'seb_section',
			'settings'		=> 'seb_color_picker',
			'priority'		=> 30,
		) ) );

		/**
		 * Select
		 */
		$wp_customize->add_setting( 'seb_select', array(
			'default' 			=> 'default',
			'sanitize_callback'	=> 'storefront_sanitize_choices',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'seb_select', array(
			'label'			=> __( 'Select', 'storefront-extension-boilerplate' ),
			'description'	=> __( 'Make a selection!', 'storefront-extension-boilerplate' ),
			'section'		=> 'seb_section',
			'settings'		=> 'seb_select',
			'type'			=> 'select', // To add a radio control, switch this to 'radio'.
			'priority'		=> 40,
			'choices'		=> array(
				'default'		=> 'Default',
				'non-default'	=> 'Non-default',
			),
		) ) );
	}

	/**
	 * Enqueue CSS and custom styles.
	 * @since   1.0.0
	 * @return  void
	 */
	public function seb_styles() {
		wp_enqueue_style( 'seb-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );

		$heading_background_color 	= storefront_sanitize_hex_color( get_theme_mod( 'seb_color_picker', apply_filters( 'seb_default_heading_background_color', '#ff0000' ) ) );

		$seb_style = '
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			background-color: ' . $heading_background_color . ';
		}';

		wp_add_inline_style( 'seb-styles', $seb_style );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since  1.0.0
	 */
	public function seb_customize_preview_js() {
		wp_enqueue_script( 'seb-customizer', plugins_url( '/assets/js/customizer.min.js', __FILE__ ), array( 'customize-preview' ), '1.1', true );
	}

	/**
	 * Storefront Extension Boilerplate Body Class
	 * Adds a class based on the extension name and any relevant settings.
	 */
	public function seb_body_class( $classes ) {
		$classes[] = 'storefront-extension-boilerplate-active';

		return $classes;
	}

	/**
	 * Layout
	 * Adjusts the default Storefront layout when the plugin is active
	 */
	public function seb_layout_adjustments() {
		$seb_checkbox 	= get_theme_mod( 'seb_checkbox', apply_filters( 'seb_checkbox_default', false ) );

		if ( true == $seb_checkbox ) {
			add_action( 'storefront_header', array( $this, 'seb_primary_navigation_wrapper' ), 45 );
			add_action( 'storefront_header', array( $this, 'seb_primary_navigation_wrapper_close' ), 65 );
		}
	}

	/**
	 * Primary navigation wrapper
	 * @return void
	 */
	function seb_primary_navigation_wrapper() {
		echo '<section class="seb-primary-navigation">';
	}

	/**
	 * Primary navigation wrapper close
	 * @return void
	 */
	function seb_primary_navigation_wrapper_close() {
		echo '</section>';
	}

} // End Class
