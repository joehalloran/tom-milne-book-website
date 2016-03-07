<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset=<?php bloginfo('charset'); ?> >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php bloginfo('description'); ?> ">
    <meta name="author" content="Rosedale Primary school">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico">
    <?php /*<title><?php bloginfo('name'); wp_title(); ?></title> */ // Title tags applied through?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
  </head>

  <body>
    <div id="secondary-navbar">
      <?php bookclubLoginLogout() ?>
    	<?php mybookshelflink(); ?>
	  </div><!--/ #secondary-nav -->
    
  	<div class="container-fluid jumbotron">
  		<div class="container">
  			<div class="col-md-12">
	  			<h1>Rosendale Book Club</h1>
  			</div><!-- ./col -->
  		</div> <!-- /.container -->
  	</div> <!-- /.container-fluid -->
   
    <nav class="navbar navbar-inverse">
        <div class="container">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href=<?php echo home_url( '/' )?> ><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
	        </div> <!-- /.navbar-header -->
	        <div id="navbar" class="collapse navbar-collapse">
	        	<ul class="nav navbar-nav">
		            <li><a href=<?php echo home_url( '/' )."about" ?> ><?php esc_html_e('About', 'bookclub') ?></a></li>
		            <li><a href=<?php echo home_url( '/' )."nameplate-competition" ?> ><?php esc_html_e('Bookplate competition', 'bookclub') ?></a></li>
		            <li><a href=<?php echo home_url( '/' )."building-our-library-of-books" ?> ><?php esc_html_e('Building our library', 'bookclub') ?></a></li>
		            <li><a href=<?php echo home_url( '/' )."audio-books" ?> ><?php esc_html_e('Audio Books', 'bookclub') ?></a></li>
                <?php
                if ( is_user_logged_in() ) {
                    ?>
                    <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php esc_html_e('Testing', 'bookclub') ?><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href=<?php echo home_url( '/' )."test-post-page" ?> ><?php esc_html_e('All Books', 'bookclub') ?></a></li>
                        <li><a href=<?php echo home_url( '/' )."people" ?> ><?php esc_html_e('People', 'bookclub') ?></a></li>
                      </ul>
                    </li> <?php
                }
                ?>
		        </ul>
		        <ul class="nav navbar-nav navbar-right">
              <?php get_search_form() ?>
		        </ul>
	        </div><!--/.nav-collapse -->
        </div><!--/.container -->
    </nav>
    <!-- X 5th Feb 2016 -->