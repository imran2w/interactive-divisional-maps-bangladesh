<?php
/*
Plugin Name: Interactive Divisional Maps Bangladesh
Plugin URI: https://imran.link/
Description: Display an interactive map of Bangladesh with 8 clickable divisional regions.
Author: ALI IMRAN
Version: 2.0.0
Author URI: http://facebook.com/imran2w
*/

/*
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or ( at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of ERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA. Online: http://www.gnu.org/licenses/gpl.txt;
*/

// Bismillah...

defined( 'ABSPATH' ) || die( 'Stop! You can not do this!' );

class Interactive_Divisional_Maps_BD {
	const OPTION_NAME = 'bd_divisional_maps_options';

	/**
	 * Division option keys.
	 *
	 * @return array<int, string>
	 */
	public static function division_keys() {
		return array( 'barisal', 'chittagong', 'dhaka', 'khulna', 'mymensingh', 'rajshahi', 'rangpur', 'sylhet' );
	}

	/**
	 * Default plugin options.
	 *
	 * @return array<string, string>
	 */
	public static function default_options() {
		return array(
			'title'      => 'বাংলাদেশের মানচিত্র',
			'st1_color'  => '#787878',
			'st3_color'  => '#367445',
			'hover_color'=> '#9A1515',
			'barisal'    => '#',
			'chittagong' => '#',
			'dhaka'      => '#',
			'khulna'     => '#',
			'mymensingh' => '#',
			'rajshahi'   => '#',
			'rangpur'    => '#',
			'sylhet'     => '#',
		);
	}

	/**
	 * Get plugin options merged with defaults.
	 *
	 * @return array<string, string>
	 */
	public static function get_options() {
		$saved = get_option( self::OPTION_NAME, array() );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}

		return wp_parse_args( $saved, self::default_options() );
	}

	/**
	 * Sanitize map options from raw input.
	 *
	 * @param array<string, mixed> $raw Raw input values.
	 * @return array<string, string>
	 */
	public static function sanitize_options( $raw ) {
		$current   = self::get_options();
		$sanitized = array();

		$sanitized['title'] = isset( $raw['title'] ) ? sanitize_text_field( wp_unslash( (string) $raw['title'] ) ) : $current['title'];
		$st1_color = isset( $raw['st1_color'] ) ? sanitize_hex_color( wp_unslash( (string) $raw['st1_color'] ) ) : '';
		$sanitized['st1_color'] = $st1_color ? $st1_color : $current['st1_color'];
		$color = isset( $raw['st3_color'] ) ? sanitize_hex_color( wp_unslash( (string) $raw['st3_color'] ) ) : '';
		$sanitized['st3_color'] = $color ? $color : $current['st3_color'];
		$hover = isset( $raw['hover_color'] ) ? sanitize_hex_color( wp_unslash( (string) $raw['hover_color'] ) ) : '';
		$sanitized['hover_color'] = $hover ? $hover : $current['hover_color'];

		foreach ( self::division_keys() as $division ) {
			$value = isset( $raw[ $division ] ) ? esc_url_raw( wp_unslash( (string) $raw[ $division ] ) ) : '';
			$sanitized[ $division ] = '' !== $value ? $value : $current[ $division ];
		}

		return $sanitized;
	}

	public static function render_shortcode() {
		$options = self::get_options();
		wp_enqueue_script(
			'interactive-divisional-maps-bd-map',
			plugins_url( 'assets/js/map-image.js', __FILE__ ),
			array(),
			'2.0.0',
			true
		);

		ob_start();
		include plugin_dir_path( __FILE__ ) . 'map-image.php';
		return ob_get_clean();
	}

	public static function register_widget() {
		register_widget( 'Interactive_Divisional_Maps_BD_Widget' );
	}


	public static function init() {
		add_shortcode( 'interactive_divitional_maps_bd', array( __CLASS__, 'render_shortcode' ) ); // backward compatibility
		add_shortcode( 'interactive_divisional_maps_bd', array( __CLASS__, 'render_shortcode' ) );
		add_action( 'widgets_init', array( __CLASS__, 'register_widget' ) );
	}
}

require_once plugin_dir_path( __FILE__ ) . 'widget.php';

if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'settings.php';
}

Interactive_Divisional_Maps_BD::init();
