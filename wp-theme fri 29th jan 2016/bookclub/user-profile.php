<?php 

// Option to redirect. Need to integrate with form processing
/* if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$location = $_SERVER['REQUEST_URI'];
	header("Location: {$location}");
	exit();
} */


$user = get_user_by( 'slug', get_query_var( 'user' ) );
global $current_user;
get_currentuserinfo();

function check_user_exists( $user ) {
	if ( !$user ) {
		global $wp_query;
	    $wp_query->set_404();
	    status_header( 404 );
	    get_template_part( 404 ); 
	    exit();
	}
};

function i_own_this_page( $user, $current_user ){
	if ($user == $current_user) {
		return true;
	} else {
		return false;
	}
};



function topFiveSubmit($topFive, $user_id) {
	// echo 'Started';
	if ($user_id) {
		// echo $user_id;
	} else {
		echo "no userid";
	}
	$saved_values = get_user_meta($user_id, 'my_top_five', true);
	if ( $saved_values ) { // if top five already exists
		update_user_meta( $user_id, 'my_top_five', $topFive ); 
	} else { //else make new 
		//$new_array = array($topFive);
		add_user_meta( $user_id, 'my_top_five', $topFive, true );
	} 
	
};

function getTopFive($user_id) {
	$saved_values = get_user_meta($user_id, 'my_top_five', true);
	//echo "run";
	//print_r $saved_values;
	if ( $saved_values ) { // if top five already exists
		return $saved_values; 
	}
};

//check that the user exists and that the /user/{username} section of the URL is valid
check_user_exists( $user );

//check to see that this page's owner is current user
$iHaveAccess = i_own_this_page( $user, $current_user );

//get books for my_bookshelf
$saved_values = get_user_meta($user->id, 'my_bookshelf', true);

//function to return bookshelf title to validate form submission
function get_book_titles($user_id, $books) {
	$bookshelf_titles = array();
	foreach ( $books as $post_id ) {
		$post = get_post($post_id); 
		$title = $post->post_title;
		$bookshelf_titles[] = $title;
	}
	return $bookshelf_titles;
};

// ################ POST RECIEVED ##################
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$bookOne = $_POST['bookOne'];
	$bookTwo = $_POST['bookTwo'];
	$bookThree = $_POST['bookThree'];
	$bookFour = $_POST['bookFour'];
	$bookFive = $_POST['bookFive'];
	$topFive = array($bookOne, $bookTwo, $bookThree, $bookFour, $bookFive);
	// foreach ($topFive as $key => $value) {
	// 	echo "<p>{$key} {$value}</p>";
	// }
	//print_r($user);
	$userid = $user->id;
	$book_titles = get_book_titles($user_id, $saved_values);
	$validation = TRUE;
	foreach ($topFive as $book) {
		if ( in_array($book, $book_titles) ) {
			echo "fine";
		} elseif ( $book == "" ) {
			echo "fine";
		} else {
			echo $book;
			echo "error - input not valid";
			echo "<br />";
			$validation = FALSE;
		}
	}
	// echo "user number is {$userid}<br />";
	if ($validation && $iHaveAccess) {
		topFiveSubmit($topFive, $userid);
		
	}
} 

get_header(); 

?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	        	<h1>Welcome <?php echo $user->first_name; ?></h1>
		        <?php $booksRead = count($saved_values);
		        echo "You have read {$booksRead} books.";
		        ?>
		        <hr />
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
			   		if ($saved_values) {
				   		foreach ( $saved_values as $post_id ) : 
				   			$post = get_post($post_id); ?>
				   			<div class="col-sm-3 book-preview" data-title="<?php echo $post->post_title; ?>" data-author="<?php echo get_post_meta($post_id , 'book_author_surname', true) ?>">
					   			<a href="<?php echo post_permalink($post_id); ?>">
					   				<?php echo get_the_post_thumbnail($post_id, 'full', array( 'class' => 'img-responsive img-rounded book-thumbnail', 'data-id' => $post_id, 'data-title' => $post->post_title )); ?>
						        	<h3 style="display: none;"><?php echo $post->post_title; ?><br /><small><?php echo get_post_meta($post_id, 'book_author_firstname', true); echo ' '; echo get_post_meta($post_id, 'book_author_surname', true); ?></small></h3>
						        </a>
						        <p class="excerpt" style="display: none;"><?php echo get_excerpt_by_id($post_id); ?><br />
						        <a href="<?php echo post_permalink($post_id); ?>">More</a></p>
					        </div><!-- /.book-preview -->
			        	<?php endforeach;
			        } ?>
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
                    <div class="panel-heading" id="top-five-books">
                        <h3>My Top 5 Books</h3>
                    </div>
                    <div class="panel-body">
                    	<?php 
                    	if ( $iHaveAccess ) {
	                    	$pageURL =  get_bloginfo('url').esc_attr($_SERVER['REQUEST_URI']); ?>
	                        <form method="post" action="<?php echo htmlspecialchars($pageURL);?>" class="top-five-books">
	                        	<?php $userid = $user->id; 
	                        	$topFiveBooksGet = getTopFive($userid);
	                        	$bookOneGet = $topFiveBooksGet[0];
	                        	$bookTwoGet = $topFiveBooksGet[1];
	                        	$bookThreeGet = $topFiveBooksGet[2];
	                        	$bookFourGet = $topFiveBooksGet[3];
	                        	$bookFiveGet = $topFiveBooksGet[4]; ?>
	                        	
	                        	<div class="book_input">
	                        		<span>1.</span><input disabled id="bookOne" name="bookOne" type="text" value="<?php echo $bookOneGet; ?>">
	                        	</div>
	                            <div class="book_input">
	                            	<span>2.</span><input disabled id="bookTwo" name="bookTwo" type="text" value="<?php echo $bookTwoGet; ?>">
	                            </div>
	                            <div class="book_input">
		                            <span>3.</span><input disabled id="bookThree" name="bookThree" type="text" value="<?php echo $bookThreeGet; ?>">
	                            </div>
	                            <div class="book_input">
		                            <span>4.</span><input disabled id="bookFour" name="bookFour" type="text" value="<?php echo $bookFourGet; ?>">
	                            </div>
	                            <div class="book_input">
	                            	<span>5.</span><input disabled id="bookFive" name="bookFive" type="text" value="<?php echo $bookFiveGet; ?>">
	                            </div>
	                            <input id="saveTopFive" type="submit" value="Save" class="btn btn-default btn-red">
	                            <a class="btn btn-default btn-red" id="cancelTopFive" href="<?php echo htmlspecialchars($pageURL) ?>" role="button">Cancel</a>
		                    </form>
	                        <button id="editTopFive" type="button" class="btn btn-default btn-red">Edit my Top 5</button>
                        <?php 
                    	} else {
                        $userid = $user->id;
                    	$topFiveBooksGet = getTopFive($userid); ?>
                    	<ol>
                    		<?php 
                    		if ($topFiveBooksGet) {
	                    		foreach($topFiveBooksGet as $book) {
	                    			echo "<li class='book_input'>".$book."</li>";
	                    		} 
	                    	} else {
	                    		echo "<li class='book_input'></li><li class='book_input'></li><li class='book_input'></li><li class='book_input'></li><li class='book_input'></li>";
	                    	}

	                    	?>
                    	</ol>
                   		<?php } ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>View Options</h3>
                    </div>
                    <div class="panel-body">
                        <h3>Book Size</h3>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="listView" type="button" class="btn btn-default">List</button>
                            <button id="iconView" type="button" class="btn btn-default btn-red">Icons</button>
                        </div>
                        <h3>Book Shelf</h3>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="bookShelfOn" type="button" class="btn btn-default">On</button>
                            <button id="bookShelfOff" type="button" class="btn btn-default btn-red">Off</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.my-bookshelf-side-bar -->
        </div> <!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>