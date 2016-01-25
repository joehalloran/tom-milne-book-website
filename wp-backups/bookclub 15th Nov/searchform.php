<form action="<?php echo esc_url( home_url( '/' ) ) ?>" method="get" role="search" id="searchform" class="searchform navbar-form">
	<div class="form-group">
		<span class="sr-only">Search</span>
		<input type="search" name="s" id="s" value="<?php echo esc_attr( the_search_query() ); ?>" class="form-control" title="Search for:" placeholder="<?php echo esc_attr( 'Search…') ?>"/>
		<button type="submit" id="searchsubmit" value="<?php echo esc_attr('Search') ?>" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	</div>
</form>