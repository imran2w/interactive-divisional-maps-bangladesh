<?php

if ( ! class_exists( 'WP_Widget' ) ) {
	return;
}

class Interactive_Divisional_Maps_BD_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'bd_divisional_maps',
			__( 'Interactive Divisional Maps', 'interactive-divisional-maps-bangladesh' ),
			array(
				'description' => __( 'Displays Interactive Divisional Maps of Bangladesh', 'interactive-divisional-maps-bangladesh' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		$options = Interactive_Divisional_Maps_BD::get_options();
		$title   = apply_filters( 'widget_title', $options['title'], $instance, $this->id_base );

		echo $args['before_widget'];
		if ( '' !== $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
		echo Interactive_Divisional_Maps_BD::render_shortcode();
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$options = Interactive_Divisional_Maps_BD::get_options();
		?>
		<p class="description"><?php esc_html_e( 'These settings are global and apply to all widget instances.', 'interactive-divisional-maps-bangladesh' ); ?></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'interactive-divisional-maps-bangladesh' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $options['title'] ); ?>" />
		</p>
		<p><strong><u><?php esc_html_e( 'Division Links', 'interactive-divisional-maps-bangladesh' ); ?></u></strong></p>
		<?php foreach ( array( 'barisal', 'chittagong', 'dhaka', 'khulna', 'mymensingh', 'rajshahi', 'rangpur', 'sylhet' ) as $division ) : ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $division ) ); ?>"><?php echo esc_html( ucfirst( $division ) . ':' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( $division ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $division ) ); ?>" value="<?php echo esc_attr( $options[ $division ] ); ?>" />
			</p>
		<?php endforeach; ?>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return $old_instance;
		}

		$raw_input  = is_array( $new_instance ) ? $new_instance : array();
		$merged_raw = wp_parse_args( $raw_input, Interactive_Divisional_Maps_BD::get_options() );
		$sanitized  = Interactive_Divisional_Maps_BD::sanitize_options( $merged_raw );
		update_option( Interactive_Divisional_Maps_BD::OPTION_NAME, $sanitized );

		return $sanitized;
	}
}
