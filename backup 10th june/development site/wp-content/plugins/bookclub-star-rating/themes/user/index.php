<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

function star_rating_theme_user($post_id, $user_ID)
	{
		$data_id = $post_id;
		$user_ID = $user_ID;
		
		// $totalstarvalue = (int)get_post_meta( $data_id, 'totalstarvalue', true );
		// if(empty($totalstarvalue)) $totalstarvalue = 0;

		// $totalstarcount = (int)get_post_meta( $data_id, 'totalstarcount', true );
		// if(empty($totalstarcount)) $totalstarcount = 1;
		
		$metaTitle = 'my_rating_'.strval($data_id);
		$rate = get_user_meta( $user_ID, $metaTitle , true );

		// $rate = $totalstarvalue/$totalstarcount;
		
		if($rate>5)
			{
				$rate = 5;
			}
			
		$rate = number_format($rate, 2);
		$rate_int = ceil($rate);
		
			
		$html = '';
		$html .= '<div  class="star-rating flat">';
		
		$i= 1;
		while($i<=5)
			{
				if($i <= $rate_int)
					{
						$html .= '<div class="star_'.$i.' static_stars static_over" starvalue="'.$i.'" ></div>';
					}
				else
					{
						$html .= '<div class="star_'.$i.' static_stars" starvalue="'.$i.'" ></div>';
					}
				
				
				$i++;
			}
		
		
		// $html .= '<div class="total_votes">'.$rate.'</div>';

		$html .= '</div>'; // end 
		

		return $html;

		
		
	}