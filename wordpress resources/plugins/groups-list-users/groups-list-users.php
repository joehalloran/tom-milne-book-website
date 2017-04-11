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
add_action( 'admin_menu', 'register_rosendale_reads_user_menu_page' );

if(isset($_GET['export'])) {
	add_action('admin_init', 'create_rosendale_users_csv', 1);
}

function register_rosendale_reads_user_menu_page() {

	add_menu_page(
		'Manage rosendale users',
		'Manage rosendale users', 
		'edit_users', 
		'manage-rosendale-users', 
		'create_rosendale_users_admin_page', 
		'dashicons-admin-users'
		);	
}

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

function create_rosendale_users_admin_page() {
	$all_group_ids = get_all_group_ids();
	$hiddenGroups = array("Class of 2015", "Class of 2016", "Former teachers", "Pupils leaving", "Registered", "guest", "Teachers");

	if ( isset($_GET['password-update-status']) && ($_GET['password-update-status']) == "success" ) {
		echo '<div class="notice notice-success is-dismissible"><p>Password reset successful</p></div>';
	} 
	elseif ( isset($_GET['password-update-status']) && ($_GET['password-update-status']) == "fail" ) {
		echo '<div class="notice notice-error is-dismissible"><p>Password reset fail</p></div>';
	} 


	foreach ($all_group_ids as $group_id) {
		$group = new Groups_Group($group_id);
		$groupName = $group->name;
		if ( !(in_array($groupName, $hiddenGroups) ) ) {
			echo "<h2 id='$groupName'>".$groupName."</h2>";
			echo '<a class="button-primary" style="margin-right: 20px;" href="' . admin_url( 'admin-post.php?action=print.csv&data=' ) . $group_id .'">Download login spreadsheet</a>';
			echo '<a class="button-primary" href="' . admin_url( 'admin-post.php?action=rosendale-password-reset&data=' ) . $group_id .'">Reset all passwords</a>';
		}
	}

}

add_action( 'admin_post_rosendale-password-reset', 'rosendale_reset_group_passwords');



function rosendale_reset_group_passwords() {
	// Get group data
	$group_id = $_REQUEST['data'];
	$group = new Groups_Group($group_id);

	// Open log file
	$logFile = fopen(plugin_dir_path( __FILE__ ).'log_file.txt', "a") or die("Unable to open log file!");

	// Do not reset these passwords
	$hiddenGroups = array("Class of 2015", "Class of 2016", "Former teachers", "Pupils leaving", "Registered", "guest", "Teachers");
	
	if ($group->name && !(in_array($group->name, $hiddenGroups)) ) {
		
		
		// Get all users		
		$users = $group->__get("users");
		usort( $users, 'sortGroupsUserByDisplayName' );
		if (count($users)>0) {
			foreach ($users as $group_user) {
				// Get user data
				$user = $group_user->user;
				$user_info = get_userdata($user->ID);
				$firstName = $user_info->user_firstname;
				$lastName = $user_info->user_lastname;
				// Generate user password string
				$password = strtolower(substr( $firstName , 0 , 1 ).substr( $lastName , 0 , 1 )).ord(strtoupper(substr( $firstName , 0 , 1 )));
				try {
					// Check if user is just subscriber (i.e. a pupil - we do not want to reset teacher passwords)
					if ( user_can($user->ID, 'edit_posts'))  {
						fwrite($logFile, "\nCould not reset password for: ". $firstName . " ". $lastName);
						fwrite($logFile, ". This user is admin or teacher.	");
					} else {
						wp_set_password( $password, $user->ID );
					}

				} catch (Exception $e) {
					fwrite($logFile, "\nCould not reset password for: ". $firstName . " ". $lastName);
				}
				
  			}
  			fclose($logFile);
  			header( 'Location: '. admin_url( 'admin.php?page=manage-rosendale-users&password-update-status=success'));
		} else {
			fwrite($logFile, "\nCould not find users in group:".$group->name);
			fclose($logFile);
			header( 'Location: '. admin_url( 'admin.php?page=manage-rosendale-users&password-update-status=fail'));
		}
	} else {
		fwrite($logFile, "\nCannot reset password for Group id# ". $group_id);
		// If group has a name (i.e. ID is valid add to name to error log msg)
		if ($group->name) {
			fwrite($logFile, ", group name". $group->name);
		}
		fclose($logFile);
		header( 'Location: '. admin_url( 'admin.php?page=manage-rosendale-users&password-update-status=fail'));
	}

}


add_action( 'admin_post_print.csv', 'generate_rosendale_csv' );

function generate_rosendale_csv() {

	$group_id = $_REQUEST['data'];
	$group = new Groups_Group($group_id);
	
	if ($group) {
		$groupName = $group->name;
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$groupName.'.csv');

		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		fputcsv($output, array('First name', 'Surname', 'Username', 'Password', 'Email'));
		$users = $group->__get("users");
		usort( $users, 'sortGroupsUserByDisplayName' );
		$rows = array();
		if (count($users)>0) {
			foreach ($users as $group_user) {
				$user = $group_user->user;
				// Do not include admins or teacher in the download
				if (!( user_can($user->ID, 'edit_posts'))){
					$user_info = get_userdata($user->ID);
					$firstName = $user_info->user_firstname;
					$lastName = $user_info->user_lastname;
					$password = strtolower(substr( $firstName , 0 , 1 ).substr( $lastName , 0 , 1 )).ord(strtoupper(substr( $firstName , 0 , 1 )));
					$user_output_data = array(
						ucwords($firstName),
						ucwords($lastName),
						$user_info->user_login,
						$password,
						$user_info->user_email,
					);
					array_push($rows, $user_output_data);	
	  			}
	  		}
		}
	}

	foreach ($rows as $row) {
		fputcsv($output, $row);
	}

}
?>