<?php

/**
 * Join.chat Remove Brand
 *
 * Add Join.chat admin field for apply remove brand
 * and remove "Powered by Join.chat" if enabled.
 *
 * @version    2.0.0
 * @package    JoinChat Remove Brand
 * @author     Creame <hola@crea.me>
 */
if ( ! class_exists( 'JoinChatRemoveBrand' ) ) {
	class JoinChatRemoveBrand {

		/**
		 * Initialize the class and set init hook.
		 *
		 * @since    1.0.0
		 * @param    string $plugin_name       The name of this plugin.
		 * @param    string $version           The version of this plugin.
		 */
		public function __construct() {

			add_action( 'joinchat_run_pre', array( $this, 'init' ) );

		}

		/**
		 * Initialize all hooks
		 *
		 * @since    1.0.0
		 * @param    array $joinchat       JoinChat object.
		 * @return   void
		 */
		public function init( $joinchat ) {

			$loader = $joinchat->get_loader();

			$loader->add_filter( 'joinchat_extra_settings', $this, 'extra_settings' );
			$loader->add_filter( 'joinchat_tab_general_sections', $this, 'get_sections' );
			$loader->add_filter( 'joinchat_field_output', $this, 'field_output', 10, 3 );
			$loader->add_filter( 'joinchat_settings_validate', $this, 'settings_validate' );
			$loader->add_filter( 'joinchat_get_settings', $this, 'get_settings', 10, 2 );

		}

		/**
		 * Add "remove brand" extra setting default
		 *
		 * @since    1.0.0
		 * @param    array $extra       current settings.
		 * @return   array
		 */
		public function extra_settings( $extra ) {

			return array_merge( $extra, array( 'remove_brand' => 'no' ) );

		}

		/**
		 * Add "remove brand" setting for chat section
		 *
		 * @since    1.0.0
		 * @param    array $sections       sections and fields.
		 * @return   array
		 */
		public function get_sections( $sections ) {

			$sections['chat'] = array_merge( $sections['chat'], array( 'remove_brand' => __( 'Logo', 'creame-whatsapp-me' ) ) );

			return $sections;

		}

		/**
		 * "remove brand" field HTML output
		 *
		 * @since    1.0.0
		 * @since    2.0.0 change to radio fields
		 * @param    string $output       current field output.
		 * @param    string $field_id     current field id.
		 * @param    array  $settings     current joinchat settings.
		 * @return   string
		 */
		public function field_output( $output, $field_id, $settings ) {

			if ( 'remove_brand' === $field_id ) {

				$value = isset( $settings['remove_brand'] ) ? $settings['remove_brand'] : 'no';

				$output = '<fieldset><legend class="screen-reader-text"><span>' . __( 'Logo', 'creame-whatsapp-me' ) . '</span></legend>' .
					'<label><input id="joinchat_remove_brand" name="joinchat[remove_brand]" value="no" type="radio"' . checked( 'no', $value, false ) . '> ' .
					__( 'Powered by Join.chat', 'creame-whatsapp-me' ) . '</label><br>' .
					'<label><input id="joinchat_remove_brand" name="joinchat[remove_brand]" value="wa" type="radio"' . checked( 'wa', $value, false ) . '> ' .
					__( 'WhatsApp', 'creame-whatsapp-me' ) . '</label><br>' .
					'<label><input id="joinchat_remove_brand" name="joinchat[remove_brand]" value="yes" type="radio"' . checked( 'yes', $value, false ) . '> ' .
					__( 'None', 'creame-whatsapp-me' ) . '</label>' .
					'</fieldset>';

			}

			return $output;

		}

		/**
		 * "remove brand" setting validation
		 *
		 * @since    1.0.0
		 * @param    array $input       form input.
		 * @return   array
		 */
		public function settings_validate( $input ) {

			$valid                 = array( 'yes', 'no', 'wa' );
			$input['remove_brand'] = isset( $input['remove_brand'] ) && in_array( $input['remove_brand'], $valid ) ? $input['remove_brand'] : 'no';

			return $input;

		}

		/**
		 * Apply remove brand if set and clear setting
		 *
		 * @since    1.0.0
		 * @since    2.0.0 added 'whatsapp_brand'
		 * @param    array $settings       current settings.
		 * @return   array
		 */
		public function get_settings( $settings, $obj ) {

			if ( isset( $settings['remove_brand'] ) ) {
				if ( 'no' !== $settings['remove_brand'] ) {
					add_filter( 'joinchat_copy', '__return_false' );
				}
				if ( 'wa' === $settings['remove_brand'] ) {
					add_filter( 'joinchat_html_output', array( $this, 'whatsapp_brand' ) );
				}
				unset( $settings['remove_brand'] );
			}

			return $settings;

		}

		/**
		 * Insert WhatsApp logo in Chat Window header
		 *
		 * @since    2.0.0
		 * @param    string $output       current html otput.
		 * @return   string
		 */
		public function whatsapp_brand( $output ) {

			$from = strpos( $output, '<div class="joinchat__header">' );

			if ( false !== $from ) {
				$from   += strlen( '<div class="joinchat__header">' );
				$length  = strpos( $output, '<div class="joinchat__close"' ) - $from;
				$replace = '<span class="joinchat__copy" aria-label="WhatsApp"><svg viewBox="0 0 120 28" style="height:28px; vertical-align:-45%;">' .
					'<path d="M117.2 17c0 .4-.2.7-.4 1-.1.3-.4.5-.7.7l-1 .2c-.5 0-.9 0-1.2-.2l-.7-.7a3 3 0 0 1-.4-1 5.4 5.4 0 0 1 0-2.3c0-.4.2-.7.4-1l.7-.7a2 2 0 0 1 1.1-.3 2 2 0 0 1 1.8 1l.4 1a5.3 5.3 0 0 1 0 2.3zm2.5-3c-.1-.7-.4-1.3-.8-1.7a4 4 0 0 0-1.3-1.2c-.6-.3-1.3-.4-2-.4-.6 0-1.2.1-1.7.4a3 3 0 0 0-1.2 1.1V11H110v13h2.7v-4.5c.4.4.8.8 1.3 1 .5.3 1 .4 1.6.4a4 4 0 0 0 3.2-1.5c.4-.5.7-1 .8-1.6.2-.6.3-1.2.3-1.9s0-1.3-.3-2zm-13.1 3c0 .4-.2.7-.4 1l-.7.7-1.1.2c-.4 0-.8 0-1-.2-.4-.2-.6-.4-.8-.7a3 3 0 0 1-.4-1 5.4 5.4 0 0 1 0-2.3c0-.4.2-.7.4-1 .1-.3.4-.5.7-.7a2 2 0 0 1 1-.3 2 2 0 0 1 1.9 1l.4 1a5.4 5.4 0 0 1 0 2.3zm1.7-4.7a4 4 0 0 0-3.3-1.6c-.6 0-1.2.1-1.7.4a3 3 0 0 0-1.2 1.1V11h-2.6v13h2.7v-4.5c.3.4.7.8 1.2 1 .6.3 1.1.4 1.7.4a4 4 0 0 0 3.2-1.5c.4-.5.6-1 .8-1.6.2-.6.3-1.2.3-1.9s-.1-1.3-.3-2c-.2-.6-.4-1.2-.8-1.6zm-17.5 3.2l1.7-5 1.7 5h-3.4zm.2-8.2l-5 13.4h3l1-3h5l1 3h3L94 7.3h-3zm-5.3 9.1l-.6-.8-1-.5a11.6 11.6 0 0 0-2.3-.5l-1-.3a2 2 0 0 1-.6-.3.7.7 0 0 1-.3-.6c0-.2 0-.4.2-.5l.3-.3h.5l.5-.1c.5 0 .9 0 1.2.3.4.1.6.5.6 1h2.5c0-.6-.2-1.1-.4-1.5a3 3 0 0 0-1-1 4 4 0 0 0-1.3-.5 7.7 7.7 0 0 0-3 0c-.6.1-1 .3-1.4.5l-1 1a3 3 0 0 0-.4 1.5 2 2 0 0 0 1 1.8l1 .5 1.1.3 2.2.6c.6.2.8.5.8 1l-.1.5-.4.4a2 2 0 0 1-.6.2 2.8 2.8 0 0 1-1.4 0 2 2 0 0 1-.6-.3l-.5-.5-.2-.8H77c0 .7.2 1.2.5 1.6.2.5.6.8 1 1 .4.3.9.5 1.4.6a8 8 0 0 0 3.3 0c.5 0 1-.2 1.4-.5a3 3 0 0 0 1-1c.3-.5.4-1 .4-1.6 0-.5 0-.9-.3-1.2zM74.7 8h-2.6v3h-1.7v1.7h1.7v5.8c0 .5 0 .9.2 1.2l.7.7 1 .3a7.8 7.8 0 0 0 2 0h.7v-2.1a3.4 3.4 0 0 1-.8 0l-1-.1-.2-1v-4.8h2V11h-2V8zm-7.6 9v.5l-.3.8-.7.6c-.2.2-.7.2-1.2.2h-.6l-.5-.2a1 1 0 0 1-.4-.4l-.1-.6.1-.6.4-.4.5-.3a4.8 4.8 0 0 1 1.2-.2 8.3 8.3 0 0 0 1.2-.2l.4-.3v1zm2.6 1.5v-5c0-.6 0-1.1-.3-1.5l-1-.8-1.4-.4a10.9 10.9 0 0 0-3.1 0l-1.5.6c-.4.2-.7.6-1 1a3 3 0 0 0-.5 1.5h2.7c0-.5.2-.9.5-1a2 2 0 0 1 1.3-.4h.6l.6.2.3.4.2.7c0 .3 0 .5-.3.6-.1.2-.4.3-.7.4l-1 .1a21.9 21.9 0 0 0-2.4.4l-1 .5c-.3.2-.6.5-.8.9-.2.3-.3.8-.3 1.3s.1 1 .3 1.3c.1.4.4.7.7 1l1 .4c.4.2.9.2 1.3.2a6 6 0 0 0 1.8-.2c.6-.2 1-.5 1.5-1a4 4 0 0 0 .2 1H70l-.3-1v-1.2zm-11-6.7c-.2-.4-.6-.6-1-.8-.5-.2-1-.3-1.8-.3-.5 0-1 .1-1.5.4a3 3 0 0 0-1.3 1.2v-5h-2.7v13.4H53v-5.1c0-1 .2-1.7.5-2.2.3-.4.9-.6 1.6-.6.6 0 1 .2 1.3.6.3.4.4 1 .4 1.8v5.5h2.7v-6c0-.6 0-1.2-.2-1.6 0-.5-.3-1-.5-1.3zm-14 4.7l-2.3-9.2h-2.8l-2.3 9-2.2-9h-3l3.6 13.4h3l2.2-9.2 2.3 9.2h3l3.6-13.4h-3l-2.1 9.2zm-24.5.2L18 15.6c-.3-.1-.6-.2-.8.2A20 20 0 0 1 16 17c-.2.2-.4.3-.7.1-.4-.2-1.5-.5-2.8-1.7-1-1-1.7-2-2-2.4-.1-.4 0-.5.2-.7l.5-.6.4-.6v-.6L10.4 8c-.3-.6-.6-.5-.8-.6H9c-.2 0-.6.1-.9.5C7.8 8.2 7 9 7 10.7c0 1.7 1.3 3.4 1.4 3.6.2.3 2.5 3.7 6 5.2l1.9.8c.8.2 1.6.2 2.2.1.6-.1 2-.8 2.3-1.6.3-.9.3-1.5.2-1.7l-.7-.4zM14 25.3c-2 0-4-.5-5.8-1.6l-.4-.2-4.4 1.1 1.2-4.2-.3-.5A11.5 11.5 0 0 1 22.1 5.7 11.5 11.5 0 0 1 14 25.3zM14 0A13.8 13.8 0 0 0 2 20.7L0 28l7.3-2A13.8 13.8 0 1 0 14 0z"/></svg></span>';
				$output  = substr_replace( $output, $replace, $from, $length );
			}

			return $output;

		}
	}

	new JoinChatRemoveBrand();
}
