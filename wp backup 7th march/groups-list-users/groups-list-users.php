<?php
/*
 Plugin Name: Groups List Users
Plugin URI: http://www.eggemplo.com
Description: List users of a group.
Author: Antonio Blanco
Version: 1.0
Author URI: http://www.eggemplo.com
*/
add_shortcode('groups_users_list_groups', 'groups_users_list_groups');
add_shortcode('get_all_groups', 'get_all_groups');

function get_all_groups (  ) {
	global $wpdb;
	
	$groups_table = _groups_get_tablename( 'group' );
	
	return $wpdb->get_results( "SELECT * FROM $groups_table ORDER BY name" );
}

function get_all_group_ids( ) {
	$allGroups = get_all_groups();
	$output = array() ;
	foreach ($allGroups as $group) {
		$id = $group->group_id;
		array_push($output, $id);
		// $name = $group->name;
		// echo $id." ".$name."<br />";
	}
	// print_r($output);
	return $output;
}


function groups_users_list_groups() {
	$all_group_ids = get_all_group_ids();
	foreach ($all_group_ids as $group_id) {
		//echo "TRUE <br />";
		$group = new Groups_Group($group_id);
		$groupName = $group->name;
		echo "<h2>".$groupName."</h2>";
		//print_r($group);
		if ($group) {
			//echo "TRUE <br />";
			$users = $group->__get("users");
			if (count($users)>0) {
				foreach ($users as $group_user) {
					$user = $group_user->user;
					$user_info = get_userdata($user->ID);
      				//echo $user_info->ID
					echo '<a href="'.get_bloginfo('url')."/user/". $user_info-> user_login .'">'. $user_info-> user_firstname .  " " . $user_info-> user_lastname . "</a><br />";
      			}
			}
		}
	}
}
?>
