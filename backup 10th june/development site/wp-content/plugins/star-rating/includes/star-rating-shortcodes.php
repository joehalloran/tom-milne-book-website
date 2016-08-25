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
			

			return $html;



		}

add_shortcode('star_rating', 'star_rating_display');
















