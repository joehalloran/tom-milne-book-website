<?php
/*
Template Name: Vote Now
*/

get_header(); ?>
	<div class="container">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
		?>
		<div class="row">
			<div class="col-md-12">
				<h2 class="entry-title"><?php the_title(); ?></h2>
			</div>
		</div>
  		<div class="row">   
  			<div class="col-sm-3 col-sm-push-9 col-md-2 col-md-push-10">
  				<div>
	  				<a class="btn btn-lg btn-default btn-red disabled vote-now-sidebar-button" href="https://www.surveymonkey.co.uk/r/L2W7DM2" target="_blank" role="button"><?php _e('Vote here', 'bookclub') ?></a>
	  			</div>
	    	</div>
	        <div class="col-sm-9 col-sm-pull-3 col-md-10 col-md-pull-2">
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
<!-- X 5th Feb 2016 -->