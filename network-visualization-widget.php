<?php

// Creates a widget to display content in right-hand column
class network_visualization_widget extends WP_Widget {

  function __construct() {
    parent::__construct(

    // The base ID of the widget widget
    'network_visualization_widget', 

    // The widget name as it will appear in the admin UI
    __('Network Visualization Widget', 'network_visualization_widget_domain'), 

    // The widget description as it will appear in the admin UI
    array( 'description' => __( 'Widget to display network visualization image and text in right-hand column', 'network_visualization_widget_domain' ), ) 
    );
  }

  // The widget front-end to be displayed in the HTML 
  public function widget( $args, $instance ) {

    // Tap into the post id of the currently displayed post
    global $post;
    $post_id = $post->ID;
   
    // Build up a query for the currently displayed post
    $query_args = array(
      'p' => $post_id, 
      'post_type' => 'any'
    );

    // Submit the query for the requested post
    $query = new WP_Query( $query_args );
    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
      $network_visualization_text = get_field('network_visualization_text', $post_id, true);
      $network_visualization_image = get_field('network_visualization_image', $post_id, true);    

      // Build up the widget html content to be displayed
      $network_visualization = "<div class='network-visualization-container'><div class='network-visualization-image'><img src='" . $network_visualization_image . "' /></div><div class='network-visualization-text'>" . $network_visualization_text . "</div></div>";
   
      // Fetch the title the user's given to the widget (if any)
      $title = apply_filters( 'widget_title', $instance['title'] );

      // The before and after widget arguments are defined by the user's theme
      echo $args['before_widget'];
      if ( ! empty( $title ) )

      // Add the widget title if the admin user has provided one
      echo $args['before_title'] . $title . $args['after_title'];

      // The following line creates the output to be displayed to site visitors
      echo __( $network_visualization, 'network_visualization_widget_domain' );
      echo $args['after_widget'];

    endwhile; endif;
    wp_reset_postdata();
  }
          
  // Register the widget for use 
  public function form( $instance ) {
  if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
  }
  else {
    $title = __( 'New title', 'network_visualization_widget_domain' );
  }
  // The widget admin form
  ?>
  <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  </p>
  <?php 
  }
      
  // Allow admins to update the widget content 
  public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  return $instance;
  }
} // Closes network_visualization class

// Register and load the network visualization widget
function network_visualization_load_widget() {
    register_widget( 'network_visualization_widget' );
}
add_action( 'widgets_init', 'network_visualization_load_widget' );

?>
