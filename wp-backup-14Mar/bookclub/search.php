<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	        	<h2><small><?php _e('Search results for: ', 'bookclub'); ?></small><?php echo esc_html(get_search_query()); ?></h2>
		        <hr />
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<?php 
	   		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   			<div class="col-sm-12 book-preview" data-title="<?php esc_attr(the_title(), 'bookclub'); ?>" data-author="<?php esc_attr(get_post_meta(get_the_ID(), 'book_author_surname', true)); ?>">
		   			<a href="<?php the_permalink(); ?>">
		   				<?php the_post_thumbnail('full', array( 'class' => 'img-rounded book-thumbnail book-thumbnail-list')); ?>
			        	<h3><?php the_title(); ?><br /><small><?php $authorName = get_post_meta(get_the_ID(), 'book_author_firstname', true). ' '. get_post_meta(get_the_ID(), 'book_author_surname', true); echo esc_html($authorName);?></small></h3>
			        </a>
			        <p class="excerpt"><?php echo get_the_excerpt();?><br />
			        <a href="<?php the_permalink(); ?>"><?php _e('More', 'bookclub') ?></a></p>
			        <?php age_recommended_images(get_the_ID()); ?>
			        <?php 
				        $averageRating  = reads_get_star_rating(get_the_ID());
		        	?>
				        </div><!-- /.book-preview -->
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bookclub'); ?></p>
			<?php endif; ?>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 8th feb 2016 -->