<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
		        <h1>Welcome</h1>
		        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		        <hr />
		        <div class="dropdown pull-right">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sort by<span class="caret"></span></button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><a href="#">Author</a></li>
						<li><a href="#">Title</a></li>
						<li><a href="#">Rating</a></li>
					</ul>
				</div>
		        <h2>All Books</h2>
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	        	<h1><?php the_title(); ?></h1>
	        	<?php the_content(); ?>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>