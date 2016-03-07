    <footer class="footer">
      <div class="container">
      	<div class="col-md-6">
      		<?php /*<h4>Categories</h4> /* TO DO: ADD _e(, bookclub) to list.
	        <ul class="list-inline">
                <li>
                    <a href="#">All</a>
                </li>
                <li class="footer-menu-divider">⋅</li>
                <li>
                    <a href="#about">Action</a>
                </li>
                <li class="footer-menu-divider">⋅</li>
                <li>
                    <a href="#services">Adventure</a>
                </li>
                <li class="footer-menu-divider">⋅</li>
                <li>
                    <a href="#contact">Comedy</a>
                </li>
            </ul> */ ?>
        </div><!-- /.col -->
        <div class="col-md-6">
            <?php $year = date("Y"); ?>
	        <p class="pull-right"><?php printf(__('&copy Rosendale Primary School %d', 'bookclub'), $year); ?></p>
        </div><!-- /.col -->
      </div><!-- /.container -->
    </footer>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="js/ie10-viewport-bug-workaround.js"></script> -->
    <?php wp_footer(); ?>
  </body>
</html>
<!-- X 5th Feb 2016 -->