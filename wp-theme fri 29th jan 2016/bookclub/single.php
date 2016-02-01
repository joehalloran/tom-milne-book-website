<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	   		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	        	<h1><?php the_title(); ?><br /><small><?php echo get_post_meta(get_the_ID(), 'book_author_firstname', true)." ".get_post_meta(get_the_ID(), 'book_author_surname', true);; ?></small></h1>
	        	<h2>Genre:<br /><small><?php get_genre(get_the_ID()) ?></small></h2>
	        	<?php the_content(); ?>
	        	<?php age_recommended_images(get_the_ID()); ?>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			</div><!-- /.col -->
		</div><!-- /.row -->
			<hr />
			<?php comments_template(); ?>
    </div><!-- /.container -->
<?php get_footer(); ?>