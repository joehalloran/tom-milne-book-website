<?php get_header(); ?> 
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	   		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	        	<h1><?php echo the_title(); ?><br /><small>
	        	<?php $authorName = get_rbc_authorName(get_the_ID()); echo esc_html($authorName); ?></small></h1>
	        	<h2>Genre:<br /><small><?php get_genre(get_the_ID()) ?></small></h2>
	        	<?php 
	        	echo get_the_post_thumbnail($post_id, 'full', array( 'class' => 'img-responsive img-rounded book-thumbnail-in-post'));
	        	the_content();
	        	age_recommended_images(get_the_ID());
	        	//echo do_shortcode( '[star_rating themes="static" id="'.get_the_ID().'"]' ); 
	        	echo show_average_star_rating(get_the_ID());
	        	?>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bookclub'); ?></p>
			<?php endif; ?>
			</div><!-- /.col -->
		</div><!-- /.row -->
		<?php recommended_books( get_the_ID() ); ?>
		<hr />
		<?php comments_template(); ?>
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 5th Feb 2016 -->