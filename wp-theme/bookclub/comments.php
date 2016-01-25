<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to generate_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package GeneratePress
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="row">

	<div class="col-md-9">

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'generate' ); ?></p>
	<?php endif; ?>

	
	<?php

	$commenter = wp_get_current_commenter();
	$fields = array(
		'author' => '<div class="form-group"><label for="author">Name:</label><input class="form-control" placeholder="' . __( 'What is your name?','generate' ) . ' *" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"/></div> <!-- /.form-group -->',
		'email' => '<div class="form-group"><label for="email">Email (optional):</label><input class="form-control" placeholder="' . __( 'What is your email?','generate' ) . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" /></div> <!-- /.form-group -->',
	);

	$defaults = array(
		'fields'		=> apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field' => '<div class="form-group"><label for="comment">Comment:</label><textarea class="form-control" id="comment" name="comment" rows="8" placeholder="' . __( 'Leave your recommendation','generate' ) . ' *" aria-required="true"></textarea></p></div> <!-- /.form-group -->',
		'must_log_in' 	=> '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%1$s">logged in</a> to post a comment.','generate' ), wp_login_url( get_permalink() ) ) . '</p>',
		'logged_in_as'	=> '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','generate' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( get_permalink() ) ) . '</p>',
		'comment_notes_before' => null,
		'comment_notes_after'  => null,
		'class_submit'		   => 'btn btn-red',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => apply_filters( 'generate_leave_comment', __( 'Recommend your book here','generate' ) ),
		'title_reply_to'       => apply_filters( 'generate_leave_reply', __( 'Leave a Reply to %s','generate' ) ),
		'cancel_reply_link'    => apply_filters( 'generate_cancel_reply', __( 'Cancel reply','generate' ) ),
		'label_submit'         => apply_filters( 'generate_post_comment', __( 'Post Comment','generate' ) ),
	);
	comment_form($defaults); 
	?>
	<p>This survey will be open for two weeks, closing on Friday 18th December 2015.</p>

	<hr />
	

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _nx( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title'),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="sr-only"><?php _e('Comment navigation', 'generate' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'generate'  ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'generate' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use generate_comment() to format the comments.
				 * If you want to override this in a child theme, then you can
				 * define generate_comment() and that will be used instead.
				 * See generate_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 
					'style' => 'ol',
					'reply_text' => 'Reply to this comment'
				) );			?>
		</ol><!-- .comment-list -->

		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="sr-only"><?php _e( 'Comment navigation', 'generate' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'generate' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'generate' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

		


	<?php endif; // have_comments() ?>

	

	</div><!-- .col -->

</div><!-- #comments .row -->