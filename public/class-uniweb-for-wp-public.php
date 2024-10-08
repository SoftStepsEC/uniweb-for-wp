<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ssec.shop/
 * @since      1.0.0
 *
 * @package    Uniweb_For_Wp
 * @subpackage Uniweb_For_Wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Uniweb_For_Wp
 * @subpackage Uniweb_For_Wp/public
 * @author     Shohei Tanaka <shoheit@ssec.shop>
 */
class Uniweb_For_Wp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		wp_enqueue_script( 'uniweb-js', 'https://sdk.hellouniweb.com/base/main.js', [], '1.0.5', ['strategy' => 'async'] );
		add_filter( 'script_loader_tag', [$this, 'uniweb_add_code'], 10, 2 );
	}

	public function uniweb_add_code( $tag, $handle ) {
		$account_code = get_option( 'uniweb-code' );
		if( empty( $account_code ) ) {
			return $tag;
		}

		if ( 'uniweb-js' !== $handle ) {
			return $tag;
		}
	
		return str_replace( ' src', sprintf( ' data-account="%s" src', esc_attr( $account_code ) ), $tag );
	}
}