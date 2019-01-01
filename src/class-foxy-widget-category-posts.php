<?php

class Foxy_Widget_Category_Posts extends WP_Widget {
	public $id = 'foxy-category-posts';

	public function __construct() {
		$widget_name    = __( 'Foxy Category Posts', 'foxy' );
		$widget_desc    = __( '', 'foxy' );
		$widget_options = array(
			'name'        => $widget_name,
			'description' => $widget_desc,
			'classname'   => $this->id,
		);

		parent::__construct( $this->id, $widget_name, $widget_options );
	}

	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo _e( 'Title' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? $instance['title'] : ''; ?>">
		</p>
		<?php
	}

	public function widget( $args, $instance ) {
		$real_estate_args = array(
			'post_type' => Foxy::real_estate()->post_type(),
		);
		/**
		 * Get real estate posts.
		 */
		$real_estates = new WP_Query( $real_estate_args );
		echo $args['before_widget']; // WPCS: XSS ok.
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title']; // WPCS: XSS ok.
		}
		$post_layout_style = 'card';
		// Foxy::post_category_layout( $post_layout_style , $real_estates );
		echo $args['after_widget']; // WPCS: XSS ok.
	}
}
