
      <hr class="featurette-divider">

      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 Simon Walker. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a><?php 
            wp_nav_menu( array( 
                'theme_location' => 'footer-links',
                'container' => false,
                'items_wrap' => '%3$s',
                ) ); ?></p>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/docs.min.js"></script>
    
    <?php wp_footer(); ?>
  </body>
</html>
