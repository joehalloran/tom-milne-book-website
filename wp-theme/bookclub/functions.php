<?php 

function rosendalereads_scripts()
{
	// Deregister jquery to load in footer
	wp_deregister_script( 'jquery' );
    // Register and load jquery in footer
    wp_register_script( 'jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"), false, NULL, true );
    wp_enqueue_script( 'jquery' );
	// Register the script like this for a theme:
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '1.0.0', true );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'rosendale-reads-js',  get_template_directory_uri() . '/js/rosendalereads.js', array( 'jquery' ), '1.0.0', true );
	// Load our main stylesheet.
	wp_enqueue_style( 'rosendalereads-style', get_stylesheet_uri() );
	// Load google fonts stylesheet.
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Merriweather' );
}
add_action( 'wp_enqueue_scripts', 'rosendalereads_scripts' );



function bookclubLoginLogout() {
	$loginoutlink = wp_loginout($_SERVER['REQUEST_URI'], false );
	$loginout = substr_replace($loginoutlink, ' class="btn" role="button"', 2, 0);
	echo $loginout;
}

function mybookshelflink() {
	if ( is_user_logged_in() ) {
		global $current_user;
	    get_currentuserinfo();
	    echo '<a class="btn" role="button" href="'.get_author_posts_url( $current_user->ID).'">My Bookshelf</a>';
	}
}

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

add_action('wp_set_comment_status', 'add_book_to_bookshelf', 10, 2);


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



/*function display_all_books()
{	
	$myposts = get_posts();
	foreach ( $myposts as $post ) : setup_postdata( $post ); 
		echo get_the_ID();?>
		<p>Loop from function php</p>
		

			<div class="col-sm-3 book-preview text-center">
	   			<a href="<?php the_permalink(); ?>">
		        	<h3><?php the_title(); ?><br /><small><?php echo get_post_meta(get_the_ID(), 'book_author', true); ?></small></h3>
		        	<?php the_post_thumbnail('full', array( 'class' => 'img-responsive img-rounded')); ?>
		        </a>
	        </div><!-- /.col 3 -->
	    
		
	<?php endforeach; 
	wp_reset_postdata();
}*/

?>
