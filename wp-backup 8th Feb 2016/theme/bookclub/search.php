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
	   			<div class="col-sm-3 book-preview text-center">
		   			<a href="<?php the_permalink(); ?>">
			        	<h3><?php the_title(); ?><br /><small><?php $authorName = get_post_meta(get_the_ID(), 'book_author_firstname', true). ' '. get_post_meta(get_the_ID(), 'book_author_surname', true); echo esc_html($authorName);?></small></h3>
			        	<?php the_post_thumbnail('full', array( 'class' => 'img-responsive img-rounded search-results-image')); ?>
			        </a>
		        </div><!-- /.col 3 -->
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bookclub'); ?></p>
			<?php endif; ?>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 8th feb 2016 -->