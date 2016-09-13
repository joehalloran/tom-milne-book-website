<?php

/*
Plugin Name: Rosendale Reads Manage Classes
Plugin URI:  
Description: Creates a directory page for all pupils
Version:     1.0
Author:      Joe Halloran
Author URI:  
License:     GPL2
 
Rosendale Reads Manage Classes is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Rosendale Reads Manage Classes is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Rosendale Reads Manage Classes. If not, see {License URI}.
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page() {

	add_menu_page(
		'Comments by Class',
		'Comments by Class', 
		'moderate_comments', 
		'comments-by-class', 
		'classes_front_page', 
		'dashicons-star-filled');

	add_submenu_page(
        'comments-by-class',
        'Comments by Class',
        'Comments by Class',
        'moderate_comments',
        'comments-by-class'
    );	

	$allGroups = get_all_groups();

	foreach ($allGroups as $group) {
		$name = $group->name;
		$id = $group->group_id;
		add_submenu_page(
	        'comments-by-class',
	        $name,
	        $name,
	        'moderate_comments',
	        'comments-by-class-'.$name,
	        function() use ($id) { get_comments_by_user($id); }
	    );
	}
}


function get_comments_by_user($id) {	
	$group_id = $id; 
	$all_user_ids = groups_list_all_member_user_ids($group_id);
	// echo "<br /> ";
	// print_r($all_user_ids);
	echo '<div class="wrap">';
	echo '<div id="comments-form">';
	$tableHeader = comments_by_class_table_header();
	echo $tableHeader;
	foreach ($all_user_ids as $userid) {
		$args = array(
			'user_id' => $userid, // use user_id
			'status' => 'hold'
		);
		$comments = get_comments($args);
		foreach($comments as $comment) :
			echo '<tr id="" class="comment unapproved">';
			echo '<td class="author column-author" data-colname="Author"><strong>' . $comment->comment_author . '</strong></td>';
			echo '<td class="comment column-comment column-primary" data-colname="Comment"><p>'.$comment->comment_content.'</p><p>';
			echo t5_comment_mod_links( '', $comment->comment_ID );
			//echo custom_get_comments_links($comment);
			echo '</p></td>';
			echo '<td class="response column-response" data-colname="In Response To">';
			$postid = $comment->comment_post_ID;
			$reponse_to_column = comments_response_to($postid);
			echo $reponse_to_column;
			echo '</tr>';
		endforeach;
	}
	$tableFooter = comments_by_class_table_footer();
	echo $tableFooter;
	echo '</div>';
	echo '</div>';

}

// function custom_get_comments_links($comment) {
// 	WP_Comments_List_Table::handle_row_actions ( $comment, 'main', 'main' );
// }

function t5_comment_mod_links( $link, $id ) {

	// Delete comment link
	$delete_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "delete-comment_$id" ) );
	$url = home_url( '/' )."wp-admin/comment.php?c=$id";
	$delete_url = esc_url( $url . "&action=trashcomment&$delete_nonce" );
	$link .=  '<a class="" href="'.$delete_url.'" >Delete comment</a> | ';

    // Spam comment link
	$url = home_url( '/' )."wp-admin/comment.php?c=$id";
	$spam_url = esc_url( $url . "&action=spamcomment&$delete_nonce" );
	$link .=  '<a class="" href="'.$spam_url.'" >Spam comment</a> | ';

	// Edit comment link
	$url = home_url( '/' )."wp-admin/comment.php?";
	$edit_url = esc_url( $url . "action=editcomment&c=$id" );
	$link .=  '<a class="" href="'.$edit_url.'" >Edit comment</a> | ';

    // Approve comment link
	$approve_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "approve-comment_$id" ) );
	$url = home_url( '/' )."wp-admin/comment.php?c=$id";
	$approve_url = esc_url( $url . "&action=approvecomment&$approve_nonce" );
	$link .=  '<a class="" href="'.$approve_url.'" >Approve comment</a>';

    return $link;
}

function classes_front_page() {
	$allGroups = get_all_groups();

	foreach ($allGroups as $group) {
		$name = $group->name;
		$id = $group->group_id;
		$group_link = get_admin_url().'admin.php?page=comments-by-class-'.$name;
		$output = '<a href="'.$group_link.'"><h2>'.$name.'</h2></a>';
		echo $output;	    
	}
	
}


function groups_list_all_member_user_ids($group_id) {
	$output = array();
	$group = new Groups_Group($group_id);
	if ($group) {
		$users = $group->__get("users");
		if (count($users)>0) {
			foreach ($users as $group_user) {
				$user = $group_user->user;
				$user_info = $user->ID;
				array_push($output, $user_info);
			}
		}
	}
	return $output;
}

function comments_by_class_table_header() {
	$line1 = '<table class="wp-list-table widefat fixed striped comments"><thead>';
	$line2 = '<tr><th scope="col" id="author" class="manage-column column-author">Author</th>';
	$line3 = '<th scope="col" id="comment" class="manage-column column-comment column-primary">Comment</th>';
	$line4 = '<th scope="col" id="response" class="manage-column column-response">In Response To</th>';
	$line5 = '</tr>';
	$line6 = '</thead>';
	$line7 = '<tbody id="the-comment-list" data-wp-lists="list:comment">';
	$output = $line1.$line2.$line3.$line4.$line5.$line6.$line7;
	return $output;

}

function comments_response_to( $postid ) {
	$post_of_comment = get_post( $postid ); 
	$title = '<p><strong>'.$post_of_comment->post_title.'</strong></p>';
    $viewLink = '<a href="'.esc_url( get_permalink($postid) ).'">View Post</a></li>';
    $output = $title.$viewLink;
    return $output;
}

function comments_by_class_table_footer() {
	$line1 = '</tbody><tfoot><tr>';
	$line2 = '<th scope="col" id="author" class="manage-column column-author">Author</th>';
	$line3 = '<th scope="col" id="comment" class="manage-column column-comment column-primary">Comment</th>';
	$line4 = '</tr></tfoot>';
	$output = $line1.$line2.$line3.$line4;
	return $output;
}
?>