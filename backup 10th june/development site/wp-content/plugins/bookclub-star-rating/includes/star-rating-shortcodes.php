<?php




if ( ! defined('ABSPATH')) exit; // if direct access 










function star_rating_display($atts) {
	
		$atts = shortcode_atts(
			array(
				'id' => "", //author id
				'themes' => "flat", //author id				

				), $atts);


			$post_id = $atts['id'];
			$themes = $atts['themes'];

			$html = '';

			if($themes== "flat")
				{
					$html.= star_rating_theme_flat();
				}

			if($themes== "static")
				{
					$html.= star_rating_theme_static();
				}
			

			return $html;



		}

add_shortcode('star_rating', 'star_rating_display');




function user_star_rating_display($atts) {
	
		$atts = shortcode_atts(
			array(
				'id' => "", 
				'user' => "",
				'themes' => "user", 
				), $atts);


			$post_id = $atts['id'];
			$user_ID = $atts['user'];
			$themes = $atts['themes'];
			

			$html = '';

			if($themes == "user")
				{
					$html.= star_rating_theme_user( $post_id, $user_ID );
				}
			
			//return '<h3>'. is_string($user_ID).'length:'.mb_strlen($user_ID).'</h3><h4>id:'.$post_id.' user: '.$user_ID. ' theme: '.$themes.'</h4>';
			return $html;



		}

add_shortcode('user_star_rating', 'user_star_rating_display');












