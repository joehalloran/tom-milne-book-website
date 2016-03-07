<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	   		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	        	<h1><?php echo the_title(); ?><br /><small>
	        	<?php $author_name = get_post_meta(get_the_ID(), 'book_author_firstname', true)." ".get_post_meta(get_the_ID(), 'book_author_surname', true);
	        	echo esc_html($author_name); ?></small></h1>
	        	<h2>Genre:<br /><small><?php get_genre(get_the_ID()) ?></small></h2>
	        	<?php the_content();
	        	age_recommended_images(get_the_ID());
	        	echo do_shortcode( '[star_rating themes="flat" id="'.get_the_ID().'"]' ); 
	        	?>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bookclub'); ?></p>
			<?php endif; ?>
			</div><!-- /.col -->
		</div><!-- /.row -->
			<hr />
			<?php comments_template(); ?>
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 5th Feb 2016 -->