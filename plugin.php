<?php
/**
 * Plugin Name: zM USA BMX Stats
 * Plugin URI: --
 * Description: Display various stats from USA BMX
 * Version: 0.1-beta
 * Author: Zane M. Kolnik
 * Author URI: http://zanematthew.com/
 * License: GPL
 */


define( 'ZM_USABMX_STATS_VERSION', '0.1-beta' );
define( 'ZM_USABMX_STATS_OPTION', 'zm_usa_bmx_stats_version' );

require_once 'functions.php';
require_once 'shortcode.php';

/**
 * When the plugin is activated we check if there is a previously
 * installed version. If there is we do nothing but return. If not
 * we update the version number.
 */
function zm_usa_bmx_stats_activation() {

    if ( get_option( ZM_USABMX_STATS_OPTION ) &&
         get_option( ZM_USABMX_STATS_OPTION ) > ZM_USABMX_STATS_VERSION ){
        return;
    }

    update_option( ZM_USABMX_STATS_OPTION, ZM_USABMX_STATS_VERSION );
}
register_activation_hook( __FILE__, 'zm_usa_bmx_stats_activation' );


/**
 * When the plugin is deactivated we remove our version number.
 */
function zm_usa_bmx_stats_deactivation(){
    delete_option( ZM_USABMX_STATS_OPTION );
}
register_deactivation_hook( __FILE__, 'zm_usa_bmx_stats_deactivation' );