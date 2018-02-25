<?php

/**
 * Social  Widget
 * mastery
 */
class mastery_Social_Widget extends WP_Widget {

	function __construct() {

					  $widget_ops = array(
						  'classname' => 'mastery-social',
						  'description' => esc_html__( 'mastery Social Widget' ,'mastery' ),
					  );
		  parent::__construct( 'mastery-social', esc_html__( 'mastery Social Widget','mastery' ), $widget_ops );

	}

	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Follow us' , 'mastery' );

		echo $args['before_widget'];
		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

		/**
		 * Widget Content
		 */ ?>

		<!-- social icons -->
		<div class="social-icons sticky-sidebar-social">

			<?php mastery_social_icons(); ?>

		</div><!-- end social icons --><?php

		echo $args['after_widget'];
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Follow us' , 'mastery' );
		} ?>

	  <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ','mastery' ) ?></label>

	  <input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
						  name="<?php echo $this->get_field_name( 'title' ); ?>"
						  id="<?php $this->get_field_id( 'title' ); ?>"
						  class="widefat" />
	  </p><?php
	}

}
?>
