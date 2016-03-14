<?php get_header(); ?>
	<div class="container">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post(); ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2 class="entry-title"><?php the_title(); ?></h2>
		    </div>
		</div><!-- /.row -->
  		<div class="row">   
	        <div class="col-md-10 col-md-offset-1">

	        	
		    	<?php
				

				the_content();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				// End the loop.
				endwhile;
				?>
		    </div>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>