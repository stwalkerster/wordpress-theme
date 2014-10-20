
      <hr class="featurette-divider" />

      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; <?php echo date('Y') . ' ' . get_theme_mod('copyright-name'); ?> <?php wp_nav_menu( array( 
                    'theme_location' => 'footer-links',
                    'walker' => new StwFooterMenuWalker(),
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'fallback_cb' => 'stw_footer_nav_fallback'
                    ) ); ?></p>
      </footer>

      <?php wp_footer(); ?>
      
    </div><!-- /.container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap.min.js"></script>
  </body>
</html>
