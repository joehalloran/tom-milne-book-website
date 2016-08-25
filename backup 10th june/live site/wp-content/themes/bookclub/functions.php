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
    wp_enqueue_script('jquery-effects-shake');
	// Enqueue bootstrap javascript
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '1.0.0', true );
	// Enqueue custom css:
	wp_enqueue_script( 'rosendale-reads-js',  get_template_directory_uri() . '/js/rosendalereads.js', array( 'jquery' ), '1.0.3', true );
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
	    echo '<a class="btn" role="button" href="'.get_bloginfo('url')."/user/".$current_user->user_login.'">'.__('My Bookshelf', 'bookclub').'</a>';
	}
}

########## Function to create My bookshelf button at top of page #########
function teacherDashboard() {
	if ( current_user_can( 'moderate_comments' ) ) {
	    echo '<a class="btn" role="button" href="'.get_bloginfo('url')."/wp-admin/".'">'.__('Dashboard', 'bookclub').'</a>';
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

########### Redirect after to Home page on logout ##########
add_action('wp_logout',create_function('','wp_redirect(home_url());exit();'));




######### Function to return age recommended images #########
function age_recommended_images( $post_id ) {
	$ageRatings = get_the_category( $post_id );
	if ($ageRatings) {
		foreach($ageRatings as $rating) {
		 	if ($rating->name == '11+') {
		 		$category_id = get_cat_ID( '11+' );
			    // Get the URL of this category
			    $category_link = get_category_link( $category_id );
		    	echo '<a href="'. esc_url( $category_link ) .'" title="11"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/11-logo.png"></a>';
		    	break;
		    }
		    elseif ($rating->name == '9+') {
		    	$category_id = get_cat_ID( '9+' );
			    // Get the URL of this category
			    $category_link = get_category_link( $category_id );
		    	echo '<a href="'. esc_url( $category_link ) .'" title="9"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/9-logo.png"></a>';
		    	break;
		    }
		    elseif ($rating->name == '7+') {
		    	$category_id = get_cat_ID( '7+' );
			    // Get the URL of this category
			    $category_link = get_category_link( $category_id );
		    	echo '<a href="'. esc_url( $category_link ) .'" title="7"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/7-logo.png"></a>';
		    	break;
		    }
		    elseif ($rating->name == 'u') {
		    	$category_id = get_cat_ID( 'u' );
			    // Get the URL of this category
			    $category_link = get_category_link( $category_id );
		    	echo '<a href="'. esc_url( $category_link ) .'" title="u"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/u-logo.png"></a>';
		    	break;
		    }
	   	} //end foreach
	}//end if
}

###### Return Genres ############
function get_genre($post_id) {
	$output = [];
	$categories = get_the_category ( $post_id );
	foreach($categories as $category) {
		$parent =$category->parent;
		if ($parent == get_cat_ID( "Genre" )) { //if a Genre category
			$genreName = $category->name;
			$output[] = '<a href="'. esc_url( get_category_link( $category->term_id ) ).'"' .' rel="category tag">'.esc_html($genreName).'</a>';
		} //endif
	}//end foreach
	if ( count($output > 1 )) {
		$i = 1;
		while ($i < count($output) ) {
			$output[$i] = ', '.$output[$i];
			$i = $i+1; 
		}
	}
	foreach ( $output as $item ) {
		echo $item;
	}

}

###### Return All Genre Links for Index Page ###
function getAllCategoriesByParent( $parent ) {
    $categories = get_categories( array(
	    'orderby' => 'name',
	    'order'   => 'ASC',
	    'parent'  => get_cat_ID( $parent ),
	) );
	return $categories;
}

##### Get Category Links for front page ######
function getAgeCategoriesFrontPage() {
	
	// Get the URL of this category
	$category_id = get_cat_ID( 'u' );
    $category_link = get_category_link( $category_id );
	echo '<a href="'. esc_url( $category_link ) .'" title="u"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/u-logo.png"></a>';
	
	// Get the URL of this category
	$category_id = get_cat_ID( '7+' );
    $category_link = get_category_link( $category_id );
	echo '<a href="'. esc_url( $category_link ) .'" title="7"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/7-logo.png"></a>';
	
	// Get the URL of this category 
	$category_id = get_cat_ID( '9+' );
    $category_link = get_category_link( $category_id );
	echo '<a href="'. esc_url( $category_link ) .'" title="9"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/9-logo.png"></a>';

	// Get the URL of this category
	$category_id = get_cat_ID( '11+' );
    $category_link = get_category_link( $category_id );
	echo '<a href="'. esc_url( $category_link ) .'" title="11"><img class="img-responsive age-logo" src="'.get_template_directory_uri().'/img/11-logo.png"></a>';
}

###### Return Author Name ############
function get_rbc_authorName($post_id) {
	$authorName = get_post_meta($post_id, 'book_author_firstname', true). ' '. get_post_meta($post_id, 'book_author_surname', true);
	$secondAuthor = get_post_meta($post_id, 'second_book_author_firstname', true). ' '. get_post_meta($post_id, 'second_book_author_surname', true);

	if ( mb_strlen( $secondAuthor ) > 1 ) {
		$authorName = $authorName . ', ' . $secondAuthor;
	}//end if
	return $authorName;
}

###### Return recommended books ############
function recommended_books($post_id) {
	$recommended_book = get_post_meta($post_id, 'recommended_book', true);
	if ( mb_strlen( $recommended_book ) > 1 ) {
		$output = '
		<div class="row">
			<div class="recommended_book">
				<div class="panel panel-default">
                    <div class="panel-body">
	                    <p>'.esc_html($recommended_book).'</p>'.
                    '</div>
                </div> <!-- /.panel -->
            </div> <!-- /.recommend-->
        </div> <!-- /.row -->
		';
		echo $output;
	}//end if
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

    //$the_excerpt = $the_excerpt;

    return $the_excerpt;
}

// get replies to comments for custom bookshelf layout
function get_mybookshelf_replies( $post_id, $parent) {
	$args=array('parent'=> $parent, 'orderby' => 'comment_date' , 'order'=>'ASC', 'post_id' => $post_id, 'status'=>'approve' ); 
	$all_child_comments = get_comments( $args );
	if ($all_child_comments) {
		echo '<div class="replies"><h3 style="display: none;">'.__('Replies to this comment', 'bookclub').'</h3>';
    	foreach ( $all_child_comments as $comment ) {
    		echo '<p style="display: none; color: #337ab7;" class="excerpt"><strong>'.__('Comment on:', 'bookclub').' </strong><em>'.$comment->comment_date.'</em></p>';
    		echo '<p style="display: none; color: #337ab7;" class="excerpt"><strong>'.__('Reply from:', 'bookclub').' </strong><em>'.$comment->comment_author.'</em></p>';
    		echo '<p style="display: none;" class="excerpt">'.$comment->comment_content.'</p>';
    	}
    	echo '</div>';
	}
};

// remove inline width and height attributes for thumbnail images
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

//Custom get star rating (NB REQUIRES STAR RATING MODULE https://wordpress.org/plugins/star-rating/)
function reads_get_star_rating( $post_id ) {
	$starCount = intval( get_post_meta( $post_id, 'totalstarcount', true ) );
	$starValue = intval( get_post_meta( $post_id, 'totalstarvalue', true ) );
	if ( $starCount && $starValue ) {
		$averageRating  = $starValue / $starCount;
		$averageRating = round($averageRating, 4, PHP_ROUND_HALF_UP);
		return $averageRating;
	} else {
		return false;
	}
}

function getRandomBooks( $num ){
	$args = array(
		'posts_per_page'   => 100,
		'orderby'          => 'title',
		'order'            => 'ASC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
	);
	$posts_array = get_posts( $args );
	$randomPosts = array_rand($posts_array, $num);
	$posts = [];
	foreach ( $randomPosts as $key ) {
		$post = $posts_array[$key];
		$posts[] = $post->ID;
	}
	return $posts;

}

//Remove pages from search results
function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}

add_filter('pre_get_posts','SearchFilter');


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

/**
 * Extend WordPress search to include custom fields
 *
 * http://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
   
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

// X 8th feb 2016
?>