<?php
/*
Template Name: Directory
*/

get_header(); ?>
	<div class="container">
  		<div class="row">   
	        <div class="col-md-10 col-md-offset-1">

	        	
		    	<?php
				
		    	if (is_user_logged_in()) {
					groups_users_list_groups();
				} else {
					echo '<p>'._e("This information is only available to logged in users", 'bookclub'). '</p>';
				}

				?>
		    </div>
	    </div><!-- /.row -->
    </div><!-- /.container -->
<?php get_footer(); ?>
<!-- X 5th Feb 2016 -->