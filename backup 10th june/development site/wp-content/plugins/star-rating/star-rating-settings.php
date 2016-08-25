<?php	


if ( ! defined('ABSPATH')) exit; // if direct access 



if(empty($_POST['star_rating_hidden']))
	{

	

	
	
		
	}
else
	{	
		if($_POST['star_rating_hidden'] == 'Y') {
			//Form data sent

	

	
	
			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p></div>
	
			<?php
			} 
	}
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(star_rating_plugin_name.' Settings')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="star_rating_hidden" value="Y">
        <?php settings_fields( 'star_rating_plugin_options' );
				do_settings_sections( 'star_rating_plugin_options' );
			
		?>

    <div class="para-settings up-paratheme-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Short-Codes</li>
            <li nav="2" class="nav2">Help & Upgrade</li>
        </ul> <!-- tab-nav end -->   
    
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
				
				<div class="option-box">
                    <p class="option-title">Short-code for php file</p>
                    <p class="option-info">Short-code inside loop by dynamic post id you can use anywhere inside loop or single.php</p>
                    <pre>&#60;?php<br />echo do_shortcode( '&#91;star_rating themes="flat" id="'.get_the_ID().'"&#93;' ); <br />?&#62;</pre>

                </div>
				
				<div class="option-box">
                    <p class="option-title">Short-code for content</p>
                    <p class="option-info">Short-code inside content for fixed post id you can use anywhere inside content.</p>
                    <pre>[star_rating themes="flat"]</pre>

                </div>
                
            </li>
            
            
			<li style="display: none;" class="box2 tab-box active">
				
				<div class="option-box">
                    <p class="option-title">Need Help ?</p>
                    <p class="option-info">Feel free to Contact with any issue for this plugin, Ask any question via forum <a href="http://paratheme.com/qa/">http://paratheme.com/qa/</a> <strong style="color:#139b50;">(free)</strong><br />
                    
                    

	<?php
    
    $star_rating_customer_type = get_option('star_rating_customer_type');
    $star_rating_version = get_option('star_rating_version');
    

    if($star_rating_customer_type=="free")
        {
    
            echo 'You are using <strong> '.$star_rating_customer_type.' version  '.$star_rating_version.'</strong> of <strong>'.star_rating_plugin_name.'</strong>, To get more feature you could try our premium version. ';
            
            echo '<a href="'.star_rating_pro_url.'">'.star_rating_pro_url.'</a>';
            
        }
    elseif($star_rating_customer_type=="pro")
        {
    
            echo 'Thanks for using <strong> premium version  '.$star_rating_version.'</strong> of <strong>'.star_rating_plugin_name.'</strong> ';	
            
            
        }
    
     ?>       

                    
                    </p>
                    

                </div>

           
           	</li>
            
			

            
            
        </ul>
    
    
		
    </div>






<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>


</div> <!-- end wrap -->
