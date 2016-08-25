<?php
/*
Plugin Name: Star Rating
Plugin URI: 
Description: 
Version: 1.0
Author: paratheme
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

define('star_rating_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('star_rating_plugin_dir', plugin_dir_path( __FILE__ ) );
define('star_rating_wp_url', 'http://wordpress.org/plugins/star-rating/' );
define('star_rating_pro_url', '' );
define('star_rating_demo_url', '' );
define('star_rating_conatct_url', 'http://paratheme.com/contact' );
define('star_rating_qa_url', 'http://paratheme.com/qa' );
define('star_rating_plugin_name', 'Star Rating' );
define('star_rating_share_url', 'http://wordpress.org/plugins/star-rating/' );


require_once( plugin_dir_path( __FILE__ ) . 'includes/star-rating-functions.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/star-rating-shortcodes.php');


//Themes php files
require_once( plugin_dir_path( __FILE__ ) . 'themes/flat/index.php');




function star_rating_init_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('star_rating_js', plugins_url( '/js/star-rating-scripts.js' , __FILE__ ) , array( 'jquery' ));	
		
		wp_localize_script('star_rating_js', 'star_rating_ajax', array( 'star_rating_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('star_rating_style', star_rating_plugin_url.'css/style.css');
		
		//ParaAdmin framwork
		wp_enqueue_style('ParaAdmin', star_rating_plugin_url.'ParaAdmin/css/ParaAdmin.css');	
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));	
		
		// Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'star_rating_color_picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

		
		// Style for themes
		wp_enqueue_style('star-rating-style-flat', star_rating_plugin_url.'themes/flat/style.css');



		
	}
add_action("init","star_rating_init_scripts");




register_activation_hook(__FILE__, 'star_rating_activation');


function star_rating_activation()
	{
		$star_rating_version= "1.0";
		update_option('star_rating_version', $star_rating_version); //update plugin version.
		
		$star_rating_customer_type= "free"; //customer_type "free"
		update_option('star_rating_customer_type', $star_rating_customer_type); //update plugin version.
	}





add_action('admin_menu', 'star_rating_menu_init');



function star_rating_menu_settings(){
	include('star-rating-settings.php');	
}

function star_rating_menu_init()
	{
		add_menu_page(__('star-rating','star-rating'), __('Star Rating','author_box'), 'manage_options', 'star_rating_menu_settings', 'star_rating_menu_settings');

	}





?>