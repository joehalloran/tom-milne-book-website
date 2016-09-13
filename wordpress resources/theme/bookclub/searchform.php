<?php ;?>
<form action="<?php echo esc_url( home_url( '/' ) ) ?>" method="get" role="search" id="searchform" class="searchform navbar-form">
	<div class="form-group">
		<span class="sr-only"><?php _e('Search', 'bookclub'); ?></span>
		<input type="search" name="s" id="s" value="<?php echo esc_attr(the_search_query()); ?>" class="form-control" title="<?php esc_attr_e('Search for:', 'bookclub'); ?>" placeholder="<?php esc_attr_e( 'Search…', 'bookclub'); ?>"/>
		<button type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'bookclub'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	</div>
</form>
<?php ;?>
<!-- X 5th Feb 2016 -->