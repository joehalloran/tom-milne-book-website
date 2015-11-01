<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Rosendale book club</title>

    <!-- Stylesheets -->
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">

    <!-- Google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>
  </head>

  <body>
    <div id="secondary-navbar">
    	<a class="btn" href="#" role="button">Login</a>
    	<a class="btn" href="mybookshelf.html" role="button">My Bookshelf</a>
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
	            <a class="navbar-brand" href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> </a>
	        </div> <!-- /.navbar-header -->
	        <div id="navbar" class="collapse navbar-collapse">
	        	<ul class="nav navbar-nav">
	            	<li class="dropdown">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
			            <ul class="dropdown-menu">
				            <li><a href="#">Action</a></li>
				            <li><a href="#">Comedy</a></li>
				            <li><a href="#">Fantasy</a></li>
				            <li><a href="#">Mystery</a></li>
				            <li><a href="#">Folk Tails</a></li>
			            </ul>
		            </li>
		            <li><a href="#about">People</a></li>
		        </ul>
		        <ul class="nav navbar-nav navbar-right">
		           	<form class="navbar-form" role="search">
						<div class="form-group">
			    			<input type="text" class="form-control" placeholder="Search">
		  				</div>
		  				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</form>
	            </ul>
	        </div><!--/.nav-collapse -->
        </div><!--/.container -->
    </nav>