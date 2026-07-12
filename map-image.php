<?php
defined( 'ABSPATH' ) || die( 'Stop! You can not do this!' );

if ( ! isset( $options ) || ! is_array( $options ) ) {
	$options = Interactive_Divisional_Maps_BD::get_options();
}

$svg_url = plugins_url( 'assets/images/bangladesh.svg', __FILE__ );
?>

<div class="interactiveMapsBd" data-svg-url="<?= esc_url( $svg_url ) ?>"
	data-st1-color="<?= esc_attr( $options['st1_color'] ) ?>"
	data-st3-color="<?= esc_attr( $options['st3_color'] ) ?>"
	data-hover-color="<?= esc_attr( $options['hover_color'] ) ?>"
	data-barisal="<?= esc_url( $options['barisal'] ) ?>"
	data-chittagong="<?= esc_url( $options['chittagong'] ) ?>"
	data-dhaka="<?= esc_url( $options['dhaka'] ) ?>"
	data-khulna="<?= esc_url( $options['khulna'] ) ?>"
	data-mymensingh="<?= esc_url( $options['mymensingh'] ) ?>"
	data-rajshahi="<?= esc_url( $options['rajshahi'] ) ?>"
	data-rangpur="<?= esc_url( $options['rangpur'] ) ?>"
	data-sylhet="<?= esc_url( $options['sylhet'] ) ?>">
</div>
