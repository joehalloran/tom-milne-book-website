<?php
/*
Template Name: Directory
*/

get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-10 col-md-offset-1">

	        	
		    	<?php
				// Start the loop.
				// function get_all_groups (  ) {
				// 	global $wpdb;
					
				// 	$groups_table = _groups_get_tablename( 'group' );
					
				// 	return $wpdb->get_results( "SELECT * FROM $groups_table ORDER BY name" );
				// }

				//groups_users_list_group( array(0=>1, 1=>2) )	;
				// $allGroups = get_all_group_ids();
				// print_r($allGroups);
				// $output = '<ul>';
				// foreach ($allGroups as $group)  {
				// 	$output .= '<li>' . $group->name . '</li>';
				// }
				// $output .= '</ul>';
				// echo $output;
		    	if (is_user_logged_in()) {
					groups_users_list_groups();
				} else {
					echo "<p>This information is only available to logged in users</p>";
				}

				// foreach ($allGroups as $group) {
				// 	/// GET USERSS?????
				// 	$group = new Groups_Groups( 1 );
				// 	$users = $group->users;	
				// 	print_r($users);
				// }

				// $allUsers = get_users();
				// foreach ($allUsers as $user) {
				// 	echo '<p>' . esc_html( $user->display_name ) . '</p>';
				// }
				?>
		    </div>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>