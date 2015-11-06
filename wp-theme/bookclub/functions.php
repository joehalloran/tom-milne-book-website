<?php 

function wpbootstrap_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

add_theme_support( 'post-thumbnails' );

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
