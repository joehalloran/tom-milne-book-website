<?php get_header(); 

function topFiveSubmit() {
};

$user = get_user_by( 'slug', get_query_var( 'user' ) );?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	        	<h1>Welcome <?php echo $user->first_name; ?></h1>
		        <p class="lead">TEST TEST Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		        <hr />
		        <?php $saved_values = get_user_meta($user->id, 'my_bookshelf', true);
		        $booksRead = count($saved_values);
		        echo "You have read {$booksRead} books.";
		        /* foreach ( $saved_values as $post_id ) :
		        	echo $post_id.'-';
		        	$post = get_post($post_id);
		        	echo $post->post_title;
		        endforeach; */
		        ?>
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<div class="col-md-8 my-bookshelf-main-section">
	   			<div class="row">
	   				<div class="col-md-12">
	   					<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sort by<span class="caret"></span></button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li><a id="authorSort" href="#">Author</a></li>
								<li><a id="titleSort" href="#">Title</a></li>
								<li><a href="#">Rating</a></li>
							</ul>
						</div>
				        <h2>All Books</h2>
			        </div>
			    </div><!-- /.row -->
			    <div class="row bookshelf">
			   		<?php 
			   		foreach ( $saved_values as $post_id ) : 
			   			$post = get_post($post_id); ?>
			   			<div class="col-sm-12 book-preview" data-title="<?php echo $post->post_title; ?>" data-author="<?php echo get_post_meta($post_id , 'book_author_surname', true) ?>">
				   			<a href="<?php echo post_permalink($post_id); ?>">
				   				<?php echo get_the_post_thumbnail($post_id, 'full', array( 'class' => 'img-responsive img-rounded book-thumbnail', 'data-id' => $post_id, 'data-title' => $post->post_title )); ?>
					        	<h3><?php echo $post->post_title; ?><br /><small><?php echo get_post_meta($post_id, 'book_author_firstname', true); echo ' '; echo get_post_meta($post_id, 'book_author_surname', true); ?></small></h3>
					        </a>
					        <p class="excerpt"><?php echo get_excerpt_by_id($post_id); ?><br />
					        <a href="<?php echo post_permalink($post_id); ?>">More</a></p>
				        </div><!-- /.book-preview -->
		        	<?php endforeach; ?>
			   		<? /* if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			   			<div class="col-sm-12 book-preview" data-title="<?php the_title(); ?>" data-author="<?php echo get_post_meta(get_the_ID(), 'book_author_surname', true) ?>">
				   			<a href="<?php the_permalink(); ?>">
				   				<?php the_post_thumbnail('full', array( 'class' => 'img-responsive img-rounded book-thumbnail')); ?>
					        	<h3><?php the_title(); ?><br /><small><?php echo get_post_meta(get_the_ID(), 'book_author_firstname', true); echo ' '; echo get_post_meta(get_the_ID(), 'book_author_surname', true); ?></small></h3>
					        </a>
					        <p class="excerpt"><?php echo get_the_excerpt();?><br />
					        <a href="<?php the_permalink(); ?>">More</a></p>
				        </div><!-- /.book-preview -->
					<?php endwhile; else: ?>
						<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; */ ?> 
			    </div><!-- /.row -->
			</div><!-- /.my-bookshelf-main-section-->
		    <div class="col-md-4 my-bookshelf-sidebar">
		    	<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>My Top 5 Books</h3>
                    </div>
                    <div class="panel-body">
                        <ol class="top-five-books">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ol>
                        <button id="editTopFive" type="button" class="btn btn-default btn-red">Edit my Top 5</button>
                        <button id="saveTopFive" type="button" class="btn btn-default btn-red">Save</button>
                        <button id="cancelTopFive" type="button" class="btn btn-default btn-red">Cancel</button>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>View Options</h3>
                    </div>
                    <div class="panel-body">
                        <h3>Book Size</h3>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="listView" type="button" class="btn btn-default btn-red">List</button>
                            <button id="iconView" type="button" class="btn btn-default">Icons</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.my-bookshelf-side-bar -->
        </div> <!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>