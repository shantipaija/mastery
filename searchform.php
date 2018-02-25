<?php
/**
 * The template for displaying search forms in mastery
 *
 * @package mastery
 */
?>

<form role="search" method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="input-group">
    <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'mastery' ); ?></label>
    <input type="text" class="form-control search-query" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'mastery' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'mastery' ); ?>" />

    <span class="input-group-btn">
      <button type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'mastery' ); ?>"><span class="fa fa-search"></span></button>
    </span>
  </div>
</form>
