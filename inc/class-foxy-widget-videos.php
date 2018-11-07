<?php

class Foxy_Widget_Videos extends WP_Widget {
	protected $class_name = 'foxy-videos';

	public function __construct() {
		$widget_name    = __( 'Foxy Videos', 'foxy' );
		$widget_desc    = __( '', 'foxy' );
		$widget_options = array(
			'name'        => $widget_name,
			'description' => $widget_desc,
			'classname'   => $this->class_name,
		);

		parent::__construct( $this->class_name, $widget_name, $widget_options );
	}

	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? $instance['title'] : ''; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'video_url' ); ?>"><?php _e( 'Video URL', 'foxy' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'video_url' ); ?>" name="<?php echo $this->get_field_name( 'video_url' ); ?>" value="<?php echo isset( $instance['video_url'] ) ? $instance['video_url'] : ''; ?>">
		</p>
		<?php
	}

	public function widget( $args, $instance ) {
		if ( empty( $instance['video_url'] ) ) {
			return;
		}

		echo $args['before_widget'];
		if ( ! empty($instance['title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		Foxy::ui()->tag(array(
			'class' => 'video-embebd',
		));
		$options = array();
		$embed = new Foxy_Embed( $instance['video_url'], $options );
		$embed->content();
		echo '</a>';
		echo $args['after_widget'];
	}
}
