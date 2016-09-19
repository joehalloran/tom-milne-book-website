<?php get_header(); ?> 
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	   		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   			<article>
	   				<h1><?php echo the_title(); ?><br /><small>
		        	<?php $authorName = get_rbc_authorName($post->ID); echo esc_html($authorName); ?></small></h1>
		        	<h2>Genre:<br /><small><?php get_genre($post->ID) ?></small></h2>
	   				<div class="row">
	   					<div class="col-sm-3 col-lg-2">
	   						<?php
	   						echo get_the_post_thumbnail($post_id, 'full', array( 'class' => 'img-responsive img-rounded book-thumbnail-in-post'));
	   						?>
	   					</div>
	   					<div class="col-sm-9 col-lg-10">
				        	<?php 
				        	the_content();
				        	age_recommended_images($post->ID);
				        	echo show_average_star_rating($post->ID);
				        	echo get_rbc_mp3link($post->ID);
				        	?>
				        </div>
		        	</div>
		        </article>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bookclub'); ?></p>
			<?php endif; ?>
			</div><!-- /.col -->
		</div><!-- /.row -->
		<?php recommended_books( $post->ID ); ?>
		<hr />
		<?php comments_template(); ?>
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 5th Feb 2016 -->