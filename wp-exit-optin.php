<?php
/**
 * @package WP Exit Optin
 */
/*
Plugin Name: WP Exit Optin
Plugin URI: http://ericwijaya.com/
Description: Popup optin box for people leaving your website. This is a marketing tools to get as many leads as possible.
Version: 0.0.1
Author: Eric Wijaya
Author URI: http://www.ericwijaya.com
License: GPLv2 or later
Text Domain: wpexitoptin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2016 Eric Wijaya.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'WPEXITOPTIN_VERSION', '0.0.1' );
define( 'WPEXITOPTIN__MINIMUM_WP_VERSION', '3.2' );
define( 'WPEXITOPTIN__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPEXITOPTIN__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'WpExitOptin', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'WpExitOptin', 'plugin_deactivation' ) );

require_once( WPEXITOPTIN__PLUGIN_DIR . 'class.wpexitoptin.php' );

add_action( 'init', array( 'WpExitOptin', 'init' ) );

if ( file_exists(  WPEXITOPTIN__PLUGIN_DIR . '/lib/cmb2/init.php' ) ) {
  require_once  WPEXITOPTIN__PLUGIN_DIR . '/lib/cmb2/init.php';
} elseif ( file_exists(  WPEXITOPTIN__PLUGIN_DIR . '/lib/CMB2/init.php' ) ) {
  require_once  WPEXITOPTIN__PLUGIN_DIR . '/lib/CMB2/init.php';
}
require_once( WPEXITOPTIN__PLUGIN_DIR . 'class.wpexitoptin-admin.php' );
wpexitoptin_admin();
