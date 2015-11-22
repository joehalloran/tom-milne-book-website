<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	        	<h2><small>Search results for: </small><?php echo get_search_query(); ?>	</h2>
		        <hr />
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<?php 
	   		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   			<div class="col-sm-3 book-preview text-center">
		   			<a href="<?php the_permalink(); ?>">
			        	<h3><?php the_title(); ?><br /><small><?php echo get_post_meta(get_the_ID(), 'book_author', true); ?></small></h3>
			        	<?php the_post_thumbnail('full', array( 'class' => 'img-responsive img-rounded')); ?>
			        </a>
		        </div><!-- /.col 3 -->
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>