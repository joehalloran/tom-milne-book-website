<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	        	<h1><?php _e('All 100 books', 'bookclub'); ?></h1>
		        <p class="lead"><?php _e('Browse all the books in the bookclub.', 'bookclub'); ?></p>
		        <hr />
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<div class="col-md-8 my-bookshelf-main-section">
	   			<div class="row">
	   				<div class="col-md-12">
	   					<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?php _e('Sort by','bookclub'); ?><span class="caret"></span></button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li><a id="authorSort" href="#"><?php _e('Author', 'bookclub'); ?></a></li>
								<li><a id="titleSort" href="#"><?php _e('Title', 'bookclub'); ?></a></li>
								<li><a id="ratingSort" href="#"><?php _e('Rating', 'bookclub'); ?></a></li>
							</ul>
						</div>
			        </div>
			    </div><!-- /.row -->
			    <div class="row bookshelf">
			   		<?php 
			   		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			   			<div class="col-sm-12 book-preview" data-title="<?php esc_attr(the_title(), 'bookclub'); ?>" data-author="<?php echo esc_attr(get_post_meta(get_the_ID(), 'book_author_surname', true)); ?>" data-rating="<?php echo esc_attr(reads_get_star_rating(get_the_ID())); ?>">
				   			<a href="<?php the_permalink(); ?>">
				   				<?php the_post_thumbnail('full', array( 'class' => 'img-rounded book-thumbnail book-thumbnail-list')); ?>
					        	<h3><?php the_title(); ?><br /><small><?php $authorName = get_rbc_authorName(get_the_ID()); echo esc_html($authorName);?></small></h3>
					        </a>
					        <p class="excerpt"><?php echo get_the_excerpt();?>
					        <br />
					        <a href="<?php the_permalink(); ?>"><?php _e('More', 'bookclub') ?></a></p>
					        <?php age_recommended_images(get_the_ID()); ?>
					        <?php 
					        //echo do_shortcode( '[star_rating themes="static" id="'.get_the_ID().'"]' ); 
					        echo show_average_star_rating(get_the_ID());
				        	?>
				        </div><!-- /.book-preview -->
					<?php endwhile; else: ?>
						<p><?php _e('Sorry, no posts matched your criteria.', 'bookclub'); ?></p>
					<?php endif; ?>
			    </div><!-- /.row -->
			</div><!-- /.my-bookshelf-main-section-->
		    <div class="col-md-4 my-bookshelf-sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?php _e('View Options', 'bookclub'); ?></h3>
                    </div>
                    <div class="panel-body">
                        <h3><?php _e('Book Size', 'bookclub'); ?></h3>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="listView" type="button" class="btn btn-default btn-red"><?php _e('List', 'bookclub'); ?></button>
                            <button id="iconView" type="button" class="btn btn-default"><?php _e('Icons' , 'bookclub'); ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.my-bookshelf-side-bar -->
        </div> <!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 8th Feb 2016 -->