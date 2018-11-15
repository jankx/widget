<?php

class Foxy_Widget_Ads extends WP_Widget {
	protected $class_name = 'foxy-ads';

	public function __construct() {
		$widget_name    = __( 'Foxy Ads', 'foxy' );
		$widget_desc    = __( '', 'foxy' );
		$widget_options = array(
			'name'        => $widget_name,
			'description' => $widget_desc,
			'classname'   => $this->class_name,
		);
		parent::__construct( 'foxy-ads', $widget_name, $widget_options );
	}

	public function form( $instance ) {
		$ads_is_supported = apply_filters( 'foxy_ads_type_supports', array( 'html', 'adsendse', 'banner', 'link' ) );
		if ( ! isset( $instance['hide_title'] ) ) {
			$instance['hide_title'] = '';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? $instance['title'] : ''; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ads_type' ); ?>"><?php _e( 'Ads Type', 'foxy' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'ads_type' ); ?>" id="<?php echo $this->get_field_id( 'ads_type' ); ?>">
			</select>
		</p>
		<div class="ads-wrap">

		</div>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_title' ); ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_title' ); ?>" name="<?php echo $this->get_field_name( 'hide_title' ); ?>" value="yes"<?php echo checked( 'yes', $instance['hide_title'] ); ?>>
				<?php _e( 'Hide Title', 'foxy' ); ?>
			</label>
		</p>
		<?php
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) && empty( $instance['hide_title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo $args['after_widget'];
	}
}
