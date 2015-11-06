<?php get_header();
$user = get_user_by( 'slug', get_query_var( 'author_name' ) );?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
		        <h1><?php echo $user->first_name; ?>'s Bookshelf</h1>
		        <hr />
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<div class="col-md-8 my-bookshelf-main-section">
	   			<div class="dropdown pull-right">
    				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sort by<span class="caret"></span></button>
    				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    					<li><a href="#" id="authorSort" class="ascending">Author</a></li>
    					<li><a href="#" id="titleSort">Title</a></li>
    					<li><a href="#" id="ratingSort">My Rating</a></li>
    				</ul>
    			</div>
    			<h2><?php echo $user->first_name; ?>'s Books<br /><small>You have read X / 100 Books</small></h2>
		   		<?php
		   		$userid = array($user->id);
				$allposts = get_posts();
				foreach ( $allposts as $post ) : setup_postdata( $post ); 
					//echo $userid;
					$comments = get_comments(array(
						'post_id' => get_the_ID(),
						'status' => 'approve',
						'author__in' => $userid //Change this to the type of comments to be displayed
					));
					if ($comments) : ?>
					<div class="col-sm-4 book-preview text-center">
				   			<a href="<?php the_permalink(); ?>">
					        	<h4><?php the_title(); ?><br /><small><?php echo get_post_meta(get_the_ID(), 'book_author', true); ?></small></h4>
					        	<?php the_post_thumbnail('full', array( 'class' => 'img-responsive img-rounded')); ?>
					        </a>
				        </div><!-- /.book-preview -->
				<?php endif; ?> 
				<?php endforeach; 
				wp_reset_postdata();?>
			</div><!-- /.my-bookshelf-main-section-->
            <div class="col-md-4 my-bookshelf-sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>My Top 5 Books</h3>
                    </div>
                    <div class="panel-body">
                        <ol class="top-ten-books">
                            <li>Title Goes Here</li>
                            <li>Title Goes Here</li>
                            <li>Title Goes Here</li>
                            <li>Title Goes Here</li>
                            <li>Title Goes Here</li>
                        </ol>
                        <a class="btn btn-default pull-right" href="#" role="button">Edit my top 5</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>View Options</h3>
                    </div>
                    <div class="panel-body">
                        <h4>Book Size</h4>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="smallBookSize" type="button" class="btn btn-default">Small</button>
                            <button id="largeBookSize" type="button" class="btn btn-default btn-red">Large</button>
                        </div>
                        <h4>Book Shelf</h4>
                         <div class="btn-group" role="group" aria-label="...">
                            <button id="shelfBackgroundOn" type="button" class="btn btn-default">On</button>
                            <button id="shelfBackgroundOff" type="button" class="btn btn-default btn-red">Off</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.my-bookshelf-side-bar -->
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>