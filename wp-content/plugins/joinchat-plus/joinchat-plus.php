<?php
/*
Plugin Name: Join.chat +
Plugin URI: https://joinchat.chat/en/addons/plus/
Description: Advanced features for <strong>Join.chat</strong>.
Version: 1.1.0
Author: Creame
Author URI: https://crea.me
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'WPINC' ) || exit;


add_action( 'plugins_loaded', 'joinchat_plus_load_plugin' );

/**
 * Initialize plugin
 *
 * Load text domain, check dependencies and start admin or public functionalities
 *
 * @since    1.0.0
 * @return   void
 */
function joinchat_plus_load_plugin() {

	$plugin_name    = 'joinchat-plus';
	$plugin_version = '1.1.0';
	$joinchat_min   = '4.0.0';
	$update_key     = '5ea6f8d3d497a8500b8193bf';

	if ( is_admin() ) {
		// Load plugin translations (only needed for admin)
		load_plugin_textdomain( $plugin_name, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Check plugin updates
		require plugin_dir_path( __FILE__ ) . 'includes/plugin_update_check.php';
		new PluginUpdateChecker_2_0( "https://kernl.us/api/v1/updates/$update_key/", __FILE__, $plugin_name, 24 );
	}

	if ( defined( 'WHATSAPPME_VERSION' ) ) {

		add_action( 'admin_notices', 'joinchat_plus_wame_to_joinchat' );

	} elseif ( ! defined( 'JOINCHAT_VERSION' ) ) {

		add_action( 'admin_notices', 'joinchat_plus_joinchat_required' );

	} elseif ( ! version_compare( JOINCHAT_VERSION, $joinchat_min, '>=' ) ) {

		add_action( 'admin_notices', 'joinchat_plus_joinchat_out_of_date' );

	} else {

		require plugin_dir_path( __FILE__ ) . 'includes/class-joinchat-remove-brand.php';

	}

}

/**
 * Join.chat required admin notice
 *
 * @since    1.0.0
 * @return   void
 */
function joinchat_plus_joinchat_required() {
	echo '<div class="error"><p>' .
		__( 'You need to install and activate <strong>Join.chat</strong> in order to use <strong>Join.chat +</strong>', 'joinchat-plus' ) .
		'</p></div>';
}

/**
 * Join.chat outdated admin notice
 *
 * @since    1.0.0
 * @return   void
 */
function joinchat_plus_joinchat_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path    = 'creame-whatsapp-me/joinchat.php';
	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );

	echo '<div class="error"><p>' .
		__( '<strong>Join.chat +</strong> require a newer version of <strong>Join.chat</strong>.', 'joinchat-plus' ) .
		sprintf( ' <a href="%s">%s</a>', $upgrade_link, __( 'Update now', 'joinchat-plus' ) ) .
		'</p></div>';
}

/**
 * WAme to Join.chat outdated admin notice
 *
 * @since    1.0.0
 * @return   void
 */
function joinchat_plus_wame_to_joinchat() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path    = 'creame-whatsapp-me/whatsappme.php';
	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );

	echo '<div class="error"><p>' .
		__( '<strong>Join.chat +</strong> require to update WAme to the new <strong>Join.chat</strong>.', 'joinchat-plus' ) .
		sprintf( ' <a href="%s">%s</a>', $upgrade_link, __( 'Update now', 'joinchat-plus' ) ) .
		'</p></div>';
}
