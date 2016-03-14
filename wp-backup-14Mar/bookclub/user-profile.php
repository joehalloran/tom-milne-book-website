<?php 

// FOR MY BOOKSHELF PAGES

$user = get_user_by( 'slug', get_query_var( 'user' ) );
global $current_user;
get_currentuserinfo();

// check if the user (as defined by the url slug /user/{$username}) actually exists and url is valid
function check_user_exists( $user ) {
	if ( !$user ) {
		global $wp_query;
	    $wp_query->set_404();
	    status_header( 404 );
	    get_template_part( 404 ); 
	    exit();
	}
};

// check if current user is the page owner
function i_own_this_page( $user, $current_user ){
	if ($user == $current_user) {
		return true;
	} else {
		return false;
	}
};


// submit top five to database
function topFiveSubmit($topFive, $user_id) {
	if ( !$user_id ) { // trigger error if user_id not supplied
		trigger_error('Invalid Userid supplied when updating top 5 in database', E_USER_WARNING);
	}
	$saved_values = get_user_meta($user_id, 'my_top_five', true);
	if ( $saved_values ) { // if top five already exists
		update_user_meta( $user_id, 'my_top_five', $topFive ); 
	} else { //else make new 
		add_user_meta( $user_id, 'my_top_five', $topFive, true );
	} 
	
};

// get top five books from database
function getTopFive($user_id) {
	$saved_values = get_user_meta($user_id, 'my_top_five', true);
	if ( $saved_values ) { 
		return $saved_values; 
	}
};

// ############# NO LONGER NECESSARY #############################

// //function to return bookshelf title to validate form submission
// function get_book_titles($user_id, $books) {
// 	$bookshelf_titles = array();
// 	if ( $books ) {
// 		foreach ( $books as $post_id ) {
// 			$post = get_post($post_id); 
// 			$title = $post->post_title;
// 			$bookshelf_titles[] = $title;
// 		}
// 	}
// 	return $bookshelf_titles;
// };

//check that the user exists and that the /user/{username} section of the URL is valid
check_user_exists( $user );

//check to see that this page's owner is current user
$iHaveAccess = i_own_this_page( $user, $current_user );

// Get user ID (based this is used is several places in this page
$userid = $user->id;

//get books for my_bookshelf
$saved_values = get_user_meta($userid, 'my_bookshelf', true);

// // ################ OLD VALIDATION - TOO STRICT DUE TO ESC HTML NOT MATCHING BOOK TITLE ##################

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// 	$bookOne = $_POST['bookOne'];
// 	$bookTwo = $_POST['bookTwo'];
// 	$bookThree = $_POST['bookThree'];
// 	$bookFour = $_POST['bookFour'];
// 	$bookFive = $_POST['bookFive'];
// 	$topFive = array($bookOne, $bookTwo, $bookThree, $bookFour, $bookFive);
// 	$book_titles = get_book_titles($user_id, $saved_values);
// 	$validation = TRUE;
// 	foreach ($topFive as $book) {
// 		if ( in_array($book, $book_titles) ) {
// 			// echo "fine";
// 		} elseif ( $book == "" ) {
// 			// echo "fine";
// 		} else {
// 			trigger_error('Invalid book title for Top Five books submit, book: '. $book. ', userid:'. $userid, E_USER_WARNING);
// 			$validation = FALSE;
// 		}
// 	}
// 	// echo "user number is {$userid}<br />";
// 	if ($validation && $iHaveAccess) {
// 		topFiveSubmit($topFive, $userid);
// 		$pageURL =  get_bloginfo('url').esc_attr($_SERVER['REQUEST_URI']);
// 		header("Location: ".$pageURL );
// 		exit();
		
// 	}

// } 

// ################ POST RECIEVED ##################
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$bookOne = sanitize_text_field( $_POST['bookOne'] );
	$bookTwo = sanitize_text_field( $_POST['bookTwo'] );
	$bookThree = sanitize_text_field( $_POST['bookThree'] );
	$bookFour = sanitize_text_field( $_POST['bookFour'] );
	$bookFive = sanitize_text_field( $_POST['bookFive'] );
	$topFive = array($bookOne, $bookTwo, $bookThree, $bookFour, $bookFive);
	// $book_titles = get_book_titles($user_id, $saved_values);
	$validation = TRUE;
	foreach ($topFive as $book) {
		if ( is_string($book) && ( mb_strlen($book) < 50 ) ) {
			// echo "fine"; 
		} elseif ( $book == "" ) {
			// echo "fine";
		} else {
			trigger_error('Invalid book title for Top Five books submit, book: '. $book. ', userid:'. $userid, E_USER_WARNING);
			$validation = FALSE;
		}
	}
	// echo "user number is {$userid}<br />";
	if ($validation && $iHaveAccess) {
		topFiveSubmit($topFive, $userid);
		$pageURL =  get_bloginfo('url').esc_attr($_SERVER['REQUEST_URI']);
		header("Location: ".$pageURL );
		exit();
		
	}

} 


get_header(); 

?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-12">
	        	<?php
	        	if ($iHaveAccess) {
	        		?><h1><?php echo __('Welcome', 'bookclub').' '.$user->first_name; ?></h1>
        		<?php } else {
        			?><h1><?php echo __('Welcome to', 'bookclub').' '.$user->first_name."'s bookshelf"; ?></h1>
		        <?php 
		        }
		        if ( $saved_values ) {
		        	$booksRead = count($saved_values);
			        printf( esc_html( _n('You have read %d book.', 'You have read %d books', $booksRead, 'bookclub') ), $booksRead);
				} else {
			    	_e('You have read 0 books.', 'bookclub');
			    }
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
								<li><a id="authorSort" href="#"><?php _e('Author', 'bookclub'); ?></a></li>
								<li><a id="titleSort" href="#"><?php _e('Title', 'bookclub'); ?></a></li>
								<li><a id="ratingSort" href="#"><?php _e('Rating', 'bookclub'); ?></a></li>
							</ul>
						</div>
			        </div>
			    </div><!-- /.row -->
			    <div class="row bookshelf">
			   		<?php 
			   		if ($saved_values) {
				   		foreach ( $saved_values as $post_id ) : 
				   			$post = get_post($post_id); ?>
				   			<div class="col-sm-3 col-xs-6 book-preview" data-title="<?php echo esc_attr($post->post_title); ?>" data-author="<?php echo esc_attr(get_post_meta($post_id , 'book_author_surname', true)); ?>" data-rating="<?php echo esc_attr(reads_get_star_rating(get_the_ID())); ?>">
					   			<a href="<?php echo post_permalink($post_id); ?>">
					   				<?php echo get_the_post_thumbnail($post_id, 'full', array( 'class' => 'img-rounded book-thumbnail book-thumbnail-icon', 'data-id' => esc_attr($post_id), 'data-title' => esc_attr($post->post_title ))); ?>
						        	<h2 style="display: none;"><?php echo $post->post_title; ?><br /><small><?php $authorName = get_post_meta($post_id, 'book_author_firstname', true) . ' ' . get_post_meta($post_id, 'book_author_surname', true); echo esc_html($authorName);?></small></h2>
						        </a>
						        <?php
						        $args = array('user_id'=> $userid, 'parent'=> 0, 'orderby' => 'comment_date' , 'order'=>'ASC', 'post_id' => $post_id, 'status'=>'approve' ); 
						        $all_user_comments = get_comments( $args ); 
						        if ($all_user_comments) {
						        	echo '<div class="user-comments">';
						        	$i = 0;
							        foreach ( $all_user_comments as $comment ) {
							        	if ( $i == 0) {
							        		echo '<h3 style="display: none;">'.__('My Review','bookclub').'</h3>';
							        		echo '<p style="display: none;" class="excerpt">'.$comment->comment_content.'</p>';
							        		
							        	} elseif ( $i == 1 ) {
							        		echo '<h3 style="display: none;">'.__('My other comments', 'bookclub').'</h3>';
							        		echo '<p style="display: none; color: #337ab7;" class="excerpt"><strong><span>'.$i.'. </span>'.__('Comment on:', 'bookclub').' </strong><em>'.$comment->comment_date.'</em></p>';
								        	echo '<p style="display: none;" class="excerpt">'.$comment->comment_content.'</p>'; 
							        	} else {
								        	echo '<p style="display: none; color: #337ab7;" class="excerpt"><strong><span>'.$i.'. </span>'.__('Comment on:', 'bookclub').' </strong><em>'.$comment->comment_date.'</em></p>';
								        	echo '<p style="display: none;" class="excerpt comment-content">'.$comment->comment_content.'</p>'; 	
							        	}
							        	get_mybookshelf_replies( $post_id, $comment->comment_ID );
							        	echo '<hr style="display: none;"/>';
							        	$i++;
							        }
							        echo '</div>';
						        }
						        ?>
					        </div><!-- /.book-preview -->
			        	<?php endforeach;
			        } ?>
			    </div><!-- /.row -->
			</div><!-- /.my-bookshelf-main-section-->
		    <div class="col-md-4 my-bookshelf-sidebar">
		    	<div class="panel panel-default">
                    <div class="panel-heading" id="top-five-books">
                        <h3><?php _e('My Top 5 Books', 'bookclub'); ?></h3>
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
	                        		<span>1.</span><input disabled id="bookOne" name="bookOne" type="text" value="<?php echo $bookOneGet; ?>" data-toggle="tooltip" data-placement="left" title="Drag and drop book cover images to change your top 5.">
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
	                            <input id="saveTopFive" type="submit" value="Save" class="btn btn-default btn-red" >
	                            <a class="btn btn-default btn-red" id="cancelTopFive" href="<?php echo htmlspecialchars($pageURL) ?>" role="button"><?php _e('Cancel', 'bookclub'); ?></a>
		                    </form>
	                        <button id="editTopFive" type="button" class="btn btn-default btn-red"><?php _e('Edit my Top 5', 'bookclub'); ?></button>
                        <?php 
                    	} else {
                        $userid = $user->id;
                    	$topFiveBooksGet = getTopFive($userid); ?>
                    	<ol>
                    		<?php 
                    		if ($topFiveBooksGet) {
	                    		foreach($topFiveBooksGet as $book) {
	                    			echo '<li class="book_input">'.$book."</li>";
	                    		} 
	                    	} else {
	                    		echo '<li class="book_input"></li><li class="book_input"></li><li class="book_input"></li><li class="book_input"></li><li class="book_input"></li>';
	                    	}
	                    	?>
                    	</ol>
                    	<?php } ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?php _e('View Options', 'bookclub'); ?></h3>
                    </div>
                    <div class="panel-body">
                    	<h3><?php _e('Book Shelf', 'bookclub'); ?></h3>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="bookShelfOn" type="button" class="btn btn-default"><?php _e('On', 'bookclub'); ?></button>
                            <button id="bookShelfOff" type="button" class="btn btn-default btn-red"><?php _e('Off', 'bookclub'); ?></button>
                        </div>
                        <h3><?php _e('Book Size', 'bookclub'); ?></h3>
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="listView" type="button" class="btn btn-default disabled"><?php _e('List', 'bookclub'); ?></button>
                            <button id="iconView" type="button" class="btn btn-default btn-red disabled"><?php _e('Icons', 'bookclub'); ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.my-bookshelf-side-bar -->
        </div> <!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>