<?php

class Foxy_Widget_Posts extends WP_Widget {
	protected $class_name = 'foxy-posts';

	public function __construct() {
		$widget_name    = __( 'Foxy Posts', 'foxy' );
		$widget_desc    = __( '', 'foxy' );
		$widget_options = array(
			'name'        => $widget_name,
			'description' => $widget_desc,
			'classname'   => $this->class_name,
		);
		parent::__construct( 'foxy-posts', $widget_name, $widget_options );
	}

	public function form( $instance ) {
		$use_carousel = isset( $instance['use_carousel'] ) ? $instance['use_carousel'] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? $instance['title'] : ''; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Categories' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'category' ); ?>[]" id="<?php echo $this->get_field_id( 'category' ) ?>" multiple="multiple" class="widefat">
				<?php foreach( get_categories( array(
					'hide_empty' => false
				) ) as $category ): ?>
				<option value="<?php echo $category->term_id ?>"<?php selected(true, in_array($category->term_id, array_get( $instance, 'category', array(), true ) ) ) ?>><?php echo $category->name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php _e( 'Tags' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'tag' ); ?>[]" id="<?php echo $this->get_field_id( 'tag' ); ?>" class="widefat" multiple="multiple">
			<?php foreach( get_tags( array( 'hide_empty' => true ) ) as $tag ): ?>
				<option value="<?php echo $tag->term_id; ?>"<?php echo  selected(
					true,
					in_array( $tag->term_id, array_get( $instance, 'tag', array() ), true )
				) ?>><?php echo $tag->name; ?></option>
			<?php endforeach; ?>
			</select>
		</p>
		<?php
			Foxy_Admin_UI_Common::instance()
				->widget_post_common( $this, $instance );
		?>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'use_carousel' ); ?>" name="<?php echo $this->get_field_name( 'use_carousel' ); ?>" value="use" <?php checked( 'use', $use_carousel ); ?>>
			<label for="<?php echo $this->get_field_id( 'use_carousel' ); ?>"><?php _e( 'Use Carousel', 'foxy-real-estate' ); ?></label>
		</p>
		<?php
	}

	public function widget( $args, $instance ) {
		$post_args    = array(
			'post_type'      => 'post',
			'posts_per_page' => array_get( $instance, 'posts_per_page', 5, true ),
		);
		$category = array_get($instance, 'category', false);
		if ( ! empty( $category ) ) {
			$post_args['category__in'] = (array)$category;
		}
		$category = array_get($instance, 'tag', false);
		if ( ! empty( $tag ) ) {
			$post_args['tag__in'] = (array)$category;
		}

		$use_carousel = isset( $instance['use_carousel'] ) && $instance['use_carousel'] == 'use';

		Foxy::carousel_options( $use_carousel, $args, $instance );

		/**
		 * Get real estate posts.
		 */
		$posts = new WP_Query( $post_args );
		echo $args['before_widget']; // WPCS: XSS ok.
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title']; // WPCS: XSS ok.
		}
		$layout_args = array(
			'style'    => array_get( $instance, 'style' ),
			'carousel' => $use_carousel,
		);
		Foxy::post_layout( $layout_args, $posts, array_merge( $args, $instance ) );
		echo $args['after_widget']; // WPCS: XSS ok.
	}
}
