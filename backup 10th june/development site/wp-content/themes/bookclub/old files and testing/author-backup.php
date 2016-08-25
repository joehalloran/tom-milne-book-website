<?php get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
		        <h1>Welcome</h1>
		        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		        <hr />
		        <div class="dropdown pull-right">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sort by<span class="caret"></span></button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><a href="#">Author</a></li>
						<li><a href="#">Title</a></li>
						<li><a href="#">Rating</a></li>
					</ul>
				</div>
		        <h2>All Books</h2>
	        </div><!-- /.col 12 -->
	    </div><!-- /.row -->
	   	<div class="row">
	   		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   			<p>POST LOOP</p>
				<?php
				//Gather comments for a specific page/post 
				$user = get_user_by( 'slug', get_query_var( 'author_name' ) );
				echo $user->ID;
				$comments = get_comments(array(
					'post_id' => get_the_ID(),
					'status' => 'approve',
					'author__in' => array($user) //Change this to the type of comments to be displayed
				));
				if ($comments) : ?>
					<div class="col-sm-3 book-preview text-center">
			   			<a href="<?php the_permalink(); ?>">
				        	<h3><?php the_title(); ?><br /><small><?php echo get_post_meta(get_the_ID(), 'book_author', true); ?></small></h3>
				        	<?php the_post_thumbnail('full', array( 'class' => 'img-responsive img-rounded')); ?>
				        </a>
			        </div><!-- /.col 3 -->
			    <?php else: ?> 
			    	<div class="col-sm-3 book-preview text-center"> 
			    	<p>No comments by this author</p>
			    	</div>
				<?php endif; ?>
			<?php endwhile; else: ?>
				<?php $user = get_user_by( 'slug', get_query_var( 'author_name' ) );
				echo $user->ID; ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>