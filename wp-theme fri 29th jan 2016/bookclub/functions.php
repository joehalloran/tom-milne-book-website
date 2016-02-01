<?php 

###### Function to load additional scripts ######
function rosendalereads_scripts() {
	// Deregister jquery to load in footer
	wp_deregister_script( 'jquery' );
    // Register and load jquery in footer
    wp_register_script( 'jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"), false, NULL, true );
    // Enqueue Jquery UI scripts:
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-draggable');
    wp_enqueue_script('jquery-ui-droppable');
	// Enqueue bootstrap javascript
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '1.0.0', true );
	// Enqueue custom css:
	wp_enqueue_script( 'rosendale-reads-js',  get_template_directory_uri() . '/js/rosendalereads.js', array( 'jquery' ), '1.0.0', true );
	// Load main stylesheet:
	wp_enqueue_style( 'rosendalereads-style', get_stylesheet_uri() );
	// Load google fonts stylesheet.
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Merriweather' );
}
add_action( 'wp_enqueue_scripts', 'rosendalereads_scripts' );

// Enqueue Jquery UI scripts:
// function enqueue_jqueryUI_scripts() {
//     wp_enqueue_script('jquery-ui-core');
//     wp_enqueue_script('jquery-ui-draggable');
//     wp_enqueue_script('jquery-ui-droppable');
// };


########## Function to create Login / logout button at top of page #########
function bookclubLoginLogout() {
	$loginoutlink = wp_loginout($_SERVER['REQUEST_URI'], false );
	$loginout = substr_replace($loginoutlink, ' class="btn" role="button"', 2, 0);
	echo $loginout;
}

########## Function to create My bookshelf button at top of page #########
function mybookshelflink() {
	if ( is_user_logged_in() ) {
		global $current_user;
	    get_currentuserinfo();
	    echo '<a class="btn" role="button" href="'.get_bloginfo('url')."/user/".$current_user->user_login.'">My Bookshelf</a>';
	}
}

####### Theme set-up function #############
if ( ! function_exists( 'rosendalereads_setup' ) ) :
/**
 * Sets up theme defaults.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 */
function rosendalereads_setup() {

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );


	// Nav menus are 'hard coded in header.php using bootstrap .nav class
	// register_nav_menu('primary', 'Primary'); 
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'rosendalereads_setup' );

############## Custom redirect after comments posted ############
function custom_comment_redirect() {
	return site_url("/thank-you-for-your-comment/"); // Requires URL of redirect page 
	// TO DO: Auto-create this page if it doesn't already exist
}
add_filter('comment_post_redirect', 'custom_comment_redirect');


######### Function to return age recommended images #########
function age_recommended_images( $post_id ) {
	$ageRatings = get_the_category( $post_id );
	if ($ageRatings) {
		foreach($ageRatings as $rating) {
		    if ($rating->name == '9+') {
		    	echo '<img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/9-logo.png">';
		    	break;
		    }
		    elseif ($rating->name == '7+') {
		    	echo '<img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/7-logo.png">';
		    	break;
		    }
		    elseif ($rating->name == '5+') {
		    	echo '<img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/5-logo.png">';
		    	break;
		    }
		    elseif ($rating->name == 'u') {
		    	echo '<img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/u-logo.png">';
		    	break;
		    }
	   	} //end foreach
	}//end if
}

###### Return Genres ############
function get_genre($post_id) {
	$genres = get_the_category ( $post_id );
	foreach($genres as $genre) {
		$parent = $genre->parent;
		if ($parent == get_cat_ID( "Genre" )) { //if a Genre category
			$genreName = $genre->name;
			echo "<a href=".site_url("/category/age-recommendation/{$genreName}/").' rel="category tag">'.$genreName."</a>, ";
		} //endif
	}//end genre
	//TO DO: Autocreate Genres on theme install
}

#### Shorten post excerpts #####
function custom_excerpt_length() {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Function to add post to user's 'my bookshelf' array saved in wp-user-meta database.
function add_book_to_bookshelf($comment_ID, $status) {	
	if ( $status == 'approve' ) {
		$comment_object = get_comment($comment_ID);
		$user_id = $comment_object->user_id;
		$post_id = $comment_object->comment_post_ID;
		if ( get_post_type( $post_id ) == 'post' ) { // if is post, not page or other.
			$saved_values = get_user_meta($user_id, 'my_bookshelf', true);
			if ( $saved_values ) { // if array already exists
				if ( !in_array($post_id, $saved_values) ) { // if not in array add value
					$saved_values[] = $post_id;
					update_user_meta( $user_id, 'my_bookshelf', $saved_values ); 
				}
			} else { //else make new 
				$new_array = array($post_id);
				add_user_meta( $user_id, 'my_bookshelf', $new_array, true );
			} 
		} // endif get_post_type
	} //endif status == approve
}

// Add to book to user's bookshelf if comment approved.
add_action('wp_set_comment_status', 'add_book_to_bookshelf', 10, 2);

// Get excerpt by id
function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 40; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    $the_excerpt = $the_excerpt;

    return $the_excerpt;
}


// Create the query var so that WP catches the custom /member/username url
function userpage_rewrite_add_var( $vars ) {
    $vars[] = 'user';
    return $vars;
}
add_filter( 'query_vars', 'userpage_rewrite_add_var' );

// Create the rewrites
function userpage_rewrite_rule() {
    add_rewrite_tag( '%user%', '([^&]+)' );
    add_rewrite_rule(
        '^user/([^/]*)/?',
        'index.php?user=$matches[1]',
        'top'
    );
}
add_action('init','userpage_rewrite_rule');

// Catch the URL and redirect it to a template file
function userpage_rewrite_catch() {
    global $wp_query;

    if ( array_key_exists( 'user', $wp_query->query_vars ) ) {
        include (TEMPLATEPATH . '/user-profile.php');
        exit;
    }
}
add_action( 'template_redirect', 'userpage_rewrite_catch' );


?>
