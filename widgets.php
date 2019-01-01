<?php
/**
 * Foxy widgets for theme framework
 *
 * @package Foxy/Widgets
 * @author Puleeno Nguyen <puleeno@gmail.com>
 * @link https://wpclouds.com
 */

define( 'FOXY_WIDGETS_LOADER_FILE', __FILE__ );
$widgets_dir = dirname( FOXY_WIDGETS_LOADER_FILE );

spl_autoload_register(
	function( $class_name ) use ( $widgets_dir ) {
		$widget_file = sprintf( '%s/src/class-%s.php', $widgets_dir, preg_replace( '/_/', '-', sanitize_title( $class_name ) ) );
		if ( file_exists( $widget_file ) ) {
			require_once $widget_file;
		}
	}
);

add_action( 'widgets_init', 'foxy_load_widgets' );

/**
 * Load foxy widgets via action hook
 *
 * @return void
 */
function foxy_load_widgets() {
	$supported_widgets = apply_filters(
		'foxy_widgets',
		array(
			'Foxy_Widget_Posts',
			'Foxy_Widget_Category_Posts',
			'Foxy_Widget_Ads',
			'Foxy_Widget_Videos',
		)
	);
	foreach ( $supported_widgets as $widget_class ) {
		if ( class_exists( $widget_class ) ) {
			register_widget( $widget_class );
		}
	}
}
