<?php

class WpExitOptin {

	private static $initiated = false;
	
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;

		if ( self::load_exit_popup() ) {

			add_action( 'wp_enqueue_scripts', array( 'WpExitOptin', 'wpexitoptin_scripts' ) );

			add_action( 'wp_footer', array( 'WpExitOptin', 'wpexitoptin_html' ) );

		}
		
	}

	private static function load_exit_popup() {
		if ( is_user_logged_in() ) {
			return false;
		}
		return true;
	}

	public static function wpexitoptin_html() {
		$title = wpexitoptin_get_option('_wpexitoptin_title');
		if ( empty( $title ) ) {
			$title = 'Leaving so Soon?';
		}
		$description = wpexitoptin_get_option('_wpexitoptin_description');
		$form = wpexitoptin_get_option('_wpexitoptin_form');

		$html = '<div id="ouibounce-modal">
			<div class="underlay"></div>
			<div class="modal">
			<div class="modal-title">
			<h3>'.$title.'</h3>
			</div>
			<div class="modal-body">' . $description;
		$html .= do_shortcode($form);
		$html .= '
			</div>
			<div class="modal-footer">
			<p>no thanks</p>
			</div>
			</div>
			</div>';
		echo $html;
	}


	public static function wpexitoptin_scripts() {
		wp_enqueue_style( 'ouibounce-style', WPEXITOPTIN__PLUGIN_URL . '/lib/ouibounce/ouibounce.min.css' );
		wp_enqueue_script( 'ouibounce-script', WPEXITOPTIN__PLUGIN_URL . '/lib/ouibounce/ouibounce.min.js', array('jquery'), '1.0.0', true );
		if ( wp_is_mobile() ) {
			wp_enqueue_script( 'wpexitoptin-script', WPEXITOPTIN__PLUGIN_URL . '/js/mobile.js', array('jquery'), '0.0.1', true );
		} else {
			wp_enqueue_script( 'wpexitoptin-script', WPEXITOPTIN__PLUGIN_URL . '/js/scripts.js', array('jquery'), '0.0.1', true );
		}
	}


	private static function bail_on_activation( $message, $deactivate = true ) {
?>
<!doctype html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<style>
* {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}
p {
	margin-top: 1em;
	font-size: 18px;
}
</style>
<body>
<p><?php echo esc_html( $message ); ?></p>
</body>
</html>
<?php
		if ( $deactivate ) {
			$plugins = get_option( 'active_plugins' );
			$wpexitoptin = plugin_basename( WPEXITOPTIN__PLUGIN_DIR . 'wp-exit-optin.php' );
			$update  = false;
			foreach ( $plugins as $i => $plugin ) {
				if ( $plugin === $wpexitoptin ) {
					$plugins[$i] = false;
					$update = true;
				}
			}

			if ( $update ) {
				update_option( 'active_plugins', array_filter( $plugins ) );
			}
		}
		exit;
	}

	
	/**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation() {
		if ( version_compare( $GLOBALS['wp_version'], WPEXITOPTIN__MINIMUM_WP_VERSION, '<' ) ) {
			load_plugin_textdomain( 'wpexitoptin' );
			
			$message = '<strong>'.sprintf(esc_html__( 'WP Exit Optin %s requires WordPress %s or higher.' , 'wpexitoptin'), WPEXITOPTIN_VERSION, WPEXITOPTIN__MINIMUM_WP_VERSION ).'</strong> '.sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version, or <a href="%2$s">downgrade to version 2.4 of the WpExitOptin plugin</a>.', 'wpexitoptin'), 'https://codex.wordpress.org/Upgrading_WordPress', 'http://wordpress.org/extend/plugins/wpexitoptin/download/');

			WpExitOptin::bail_on_activation( $message );
		}
	}

	/**
	 * Removes all connection options
	 * @static
	 */
	public static function plugin_deactivation( ) {
		return 1;
	}
	
	
}