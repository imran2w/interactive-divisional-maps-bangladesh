<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Interactive_Divisional_Maps_BD_Settings {
	public static function register_settings() {
		register_setting(
			'interactive_divisional_maps_bd_settings',
			Interactive_Divisional_Maps_BD::OPTION_NAME,
			array(
				'sanitize_callback' => array( 'Interactive_Divisional_Maps_BD', 'sanitize_options' ),
			)
		);

		add_settings_section(
			'interactive_divisional_maps_bd_section',
			__( 'Map Options', 'interactive-divisional-maps-bangladesh' ),
			'__return_false',
			'interactive_divisional_maps_bd'
		);

		add_settings_section(
			'interactive_divisional_maps_bd_links_section',
			__( 'Division Links', 'interactive-divisional-maps-bangladesh' ),
			'__return_false',
			'interactive_divisional_maps_bd'
		);

		add_settings_field(
			'st1_color',
			__( 'River Line Color', 'interactive-divisional-maps-bangladesh' ),
			array( __CLASS__, 'render_st1_color_field' ),
			'interactive_divisional_maps_bd',
			'interactive_divisional_maps_bd_section'
		);

		add_settings_field(
			'st3_color',
			__( 'Division Color', 'interactive-divisional-maps-bangladesh' ),
			array( __CLASS__, 'render_st3_color_field' ),
			'interactive_divisional_maps_bd',
			'interactive_divisional_maps_bd_section'
		);

		add_settings_field(
			'hover_color',
			__( 'Division Hover Color', 'interactive-divisional-maps-bangladesh' ),
			array( __CLASS__, 'render_hover_color_field' ),
			'interactive_divisional_maps_bd',
			'interactive_divisional_maps_bd_section'
		);

		foreach ( Interactive_Divisional_Maps_BD::division_keys() as $division ) {
			add_settings_field(
				$division,
				ucfirst( $division ),
				array( __CLASS__, 'render_division_field' ),
				'interactive_divisional_maps_bd',
				'interactive_divisional_maps_bd_links_section',
				$division
			);
		}
	}

	public static function add_settings_page() {
		add_options_page(
			__( 'Interactive Divisional Maps', 'interactive-divisional-maps-bangladesh' ),
			__( 'Divisional Maps', 'interactive-divisional-maps-bangladesh' ),
			'manage_options',
			'interactive-divisional-maps-bangladesh',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	public static function render_st1_color_field() {
		$options = Interactive_Divisional_Maps_BD::get_options();
		?>
		<input type="color" name="<?php echo esc_attr( Interactive_Divisional_Maps_BD::OPTION_NAME ); ?>[st1_color]" value="<?php echo esc_attr( $options['st1_color'] ); ?>" />
		<p class="description"><?php esc_html_e( 'Changes river-line fill color.', 'interactive-divisional-maps-bangladesh' ); ?></p>
		<?php
	}

	public static function render_st3_color_field() {
		$options = Interactive_Divisional_Maps_BD::get_options();
		?>
		<input type="color" name="<?php echo esc_attr( Interactive_Divisional_Maps_BD::OPTION_NAME ); ?>[st3_color]" value="<?php echo esc_attr( $options['st3_color'] ); ?>" />
		<p class="description"><?php esc_html_e( 'Changes division fill color.', 'interactive-divisional-maps-bangladesh' ); ?></p>
		<?php
	}

	public static function render_hover_color_field() {
		$options = Interactive_Divisional_Maps_BD::get_options();
		?>
		<input type="color" name="<?php echo esc_attr( Interactive_Divisional_Maps_BD::OPTION_NAME ); ?>[hover_color]" value="<?php echo esc_attr( $options['hover_color'] ); ?>" />
		<p class="description"><?php esc_html_e( 'Changes division hover fill color.', 'interactive-divisional-maps-bangladesh' ); ?></p>
		<?php
	}

	public static function render_division_field( $division ) {
		$options = Interactive_Divisional_Maps_BD::get_options();
		?>
		<input class="regular-text" type="text" name="<?php echo esc_attr( Interactive_Divisional_Maps_BD::OPTION_NAME ); ?>[<?php echo esc_attr( $division ); ?>]" value="<?php echo esc_attr( $options[ $division ] ); ?>" />
		<p class="description"><?php esc_html_e( 'Enter a URL or # to keep the default.', 'interactive-divisional-maps-bangladesh' ); ?></p>
		<?php
	}

	public static function render_settings_page() {
		$avatar_url = get_avatar_url(
			'imran4dev@gmail.com',
			array(
				'size' => 72,
			)
		);

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Interactive Divisional Maps', 'interactive-divisional-maps-bangladesh' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'interactive_divisional_maps_bd_settings' );
				do_settings_sections( 'interactive_divisional_maps_bd' );
				submit_button();
				?>
			</form>
			<div class="card" style="max-width: 640px; margin-top: 16px; padding: 16px;">
				<h2 style="margin-top: 0;"><?php esc_html_e( 'Author', 'interactive-divisional-maps-bangladesh' ); ?></h2>
				<div style="display: flex; gap: 14px; align-items: center;">
					<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php esc_attr_e( 'Author avatar', 'interactive-divisional-maps-bangladesh' ); ?>" width="72" height="72" style="border-radius: 50%;" />
					<div>
						<p style="margin: 0 0 10px;"><?php esc_html_e( 'Built by ALI IMRAN.', 'interactive-divisional-maps-bangladesh' ); ?></p>
						<p style="margin: 0; display: flex; align-items: center; gap: 12px;">
							<a href="<?php echo esc_url( 'https://imran.link/' ); ?>" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'Website', 'interactive-divisional-maps-bangladesh' ); ?>">
								<span class="dashicons dashicons-admin-site-alt3" aria-hidden="true"></span>
							</a>
							<a href="<?php echo esc_url( 'https://profiles.wordpress.org/imran2w/' ); ?>" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'WordPress Profile', 'interactive-divisional-maps-bangladesh' ); ?>">
								<span class="dashicons dashicons-wordpress" aria-hidden="true"></span>
							</a>
							<a href="<?php echo esc_url( 'https://facebook.com/imran2w' ); ?>" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'Facebook', 'interactive-divisional-maps-bangladesh' ); ?>">
								<span class="dashicons dashicons-facebook" aria-hidden="true"></span>
							</a>
							<a href="<?php echo esc_url( 'https://www.linkedin.com/in/imran2w/' ); ?>" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'LinkedIn', 'interactive-divisional-maps-bangladesh' ); ?>">
								<span class="dashicons dashicons-linkedin" aria-hidden="true"></span>
							</a>
							<a href="<?php echo esc_url( 'https://github.com/imran2w' ); ?>" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'GitHub', 'interactive-divisional-maps-bangladesh' ); ?>">
								<span class="dashicons dashicons-editor-code" aria-hidden="true"></span>
							</a>
							<a href="<?php echo esc_url( 'mailto:imran4dev@gmail.com' ); ?>" title="<?php esc_attr_e( 'Email', 'interactive-divisional-maps-bangladesh' ); ?>">
								<span class="dashicons dashicons-email-alt" aria-hidden="true"></span>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}
}

Interactive_Divisional_Maps_BD_Settings::init();
