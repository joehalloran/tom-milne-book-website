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

// Note: Display_name is the sort property (rather than first name & surname) as display name is only value available in built in groups->__get('users') array
function sortGroupsUserByDisplayName( $a, $b ) {
	// Convert to lowercase to order alphatically regardless of case.
	$nameA = strtolower($a->display_name);
	$nameB = strtolower($b->display_name);
    return ($nameA == $nameB) ? 0 : ($nameA > $nameB ) ? 1 : -1;
}



function groups_users_list_groups() {
	$all_group_ids = get_all_group_ids();
	$hiddenGroups = array("Class of 2015", "Class of 2016", "Former teachers", "Pupils leaving", "Registered", "guest");
	echo '<div class="col-sm-3 col-lg-2" style="border-right: 1px solid #eee;"><h2>All Classes</h2>';
	foreach ($all_group_ids as $group_id) {
		$group = new Groups_Group($group_id);
		$groupName = $group->name;
		
		if ( !(in_array($groupName, $hiddenGroups) ) ) {
			echo '<p><a href="#'.$groupName.'">'.$groupName."</a></p>";
		}

	}
	echo '<a href="#" style="position: fixed;">top</a>';
	echo '</div><div class="col-sm-9 col-lg-10">';
	foreach ($all_group_ids as $group_id) {
		//echo "TRUE <br />";
		$group = new Groups_Group($group_id);
		$groupName = $group->name;
		if ( !(in_array($groupName, $hiddenGroups) ) ) {
			echo "<h2 id='$groupName'>".$groupName."</h2>";
			if ($group) {
				$users = $group->__get("users");
				usort( $users, 'sortGroupsUserByDisplayName' );
				if (count($users)>0) {
					echo '<div class="row">';
					$totalInGroup = count($users);
					$firstThird = round( ($totalInGroup / 3) , 0);
					$secondThird = $firstThird * 2;
					$i = 1;
					echo '<div class="col-sm-4 col-xs-6">';
					foreach ($users as $group_user) {
						$user = $group_user->user;
						$user_info = get_userdata($user->ID);
	      				//echo $user_info->ID
						echo '<a href="'.get_bloginfo('url')."/user/". $user_info->user_login .'">'. ucwords(strtolower($user_info->user_firstname)) .  " " . ucwords(strtolower($user_info->user_lastname)) . "</a><br />";
						if ($i == $firstThird || $i == $secondThird) {
							echo '</div><div class="col-sm-4 col-xs-6">';
						}
						$i++;
	      			}
	      			echo '</div><!--/.col-->';
	      			echo '</div><!--/.row-->';
				}
			}
		}
	}
	echo '</div>';
}
?>
