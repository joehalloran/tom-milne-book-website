<?php get_header(); ?>
	<div class="container">
	   	<div class="row">
	   		<div class="col-md-8 my-bookshelf-main-section">
	   			<?php while ( have_posts() ) : the_post(); ?>
	   			<h1 ><?php the_title(); ?></h1>
	   			<?php
				the_content();
				endwhile;
				?>
		        <hr />
			    <div class="row bookshelf">
			   		<?php 
			   		$randomPosts = getRandomBooks( 8 );
			   		foreach ( $randomPosts as $post_id ) : ?>
			   			<div class="col-sm-3 col-xs-6 book-preview" data-title="<?php echo esc_attr($post->post_title); ?>" data-author="<?php echo esc_attr(get_post_meta($post_id , 'book_author_surname', true)); ?>" data-rating="<?php echo esc_attr(reads_get_star_rating(get_the_ID())); ?>">
				   			<a href="<?php echo post_permalink($post_id); ?>">
				   				<?php echo get_the_post_thumbnail($post_id, 'full', array( 'class' => 'img-rounded book-thumbnail book-thumbnail-icon', 'data-id' => esc_attr($post_id), 'data-title' => esc_attr($post->post_title ))); ?>
					        </a>
				        </div><!-- /.book-preview -->
					<?php endforeach ?>
			    </div><!-- /.row -->
			</div><!-- /.my-bookshelf-main-section-->
		    <div class="col-md-4 my-bookshelf-sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?php _e('Browse by Genre', 'bookclub'); ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $categories = getAllCategoriesByParent( 'Genre' );
						if ( count( $categories ) > 0 ) {
							echo '<ul class="all-genre-links">';
							foreach ( $categories as $genre ) {
								$genreName = $genre->name;
								$genreLink = $genre->term_id;
								echo '<li><a href="'. esc_url( get_category_link( $genre->term_id ) ).'"' .' rel="category tag">'.esc_html($genreName)."</a></li> ";
							}
							echo '</ul>';
						}	
						?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?php _e('Browse by Age Rating', 'bookclub'); ?></h3>
                    </div>
                    <div class="panel-body">
                    	<?php getAgeCategoriesFrontPage() ?>
                    </div>
                </div>
            </div><!-- /.my-bookshelf-side-bar -->
        </div> <!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 8th Feb 2016 -->