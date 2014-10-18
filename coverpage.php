<?php
/*
    Template name: Cover Page
*/
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php wp_title() ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">
    <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/cover.css" rel="stylesheet">
    
    <?php wp_head();
    
    if(is_admin_bar_showing() ) {
    ?>
    <style type="text/css" media="screen">
        .navbar-wrapper { margin-top: 52px !important; }
        @media screen and ( max-width: 782px ) {
            .navbar-wrapper { margin-top: 66px !important; }
        }
    </style>
    <?php } ?>
    
    <style type="text/css" media="screen">
        body {
            background-image: url('<?php header_image(); ?>');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body <?php body_class( ); ?>>
      <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
            </div>
            <?php wp_nav_menu( array( 
                    'theme_location' => 'cover-menu' ,
                    'container_class' => 'navbar-collapse collapse',
                    'menu_class' => 'nav navbar-nav'
                    ) ); ?>
          </div>
        </div>

      </div>
    </div>
    
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">
        <?php the_post(); ?>

          <div class="inner cover">
            <h1 class="cover-heading"><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>

          <div class="mastfoot">
            <div class="inner">
                <p>&copy; <?php echo date('Y') . ' ' . get_theme_mod('copyright-name'); ?> <?php wp_nav_menu( array( 
                    'theme_location' => 'footer-links',
                    'walker' => new StwFooterMenuWalker(),
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'fallback_cb' => 'stw_footer_nav_fallback'
                    ) ); ?></p>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap.min.js"></script>
    <?php wp_footer(); ?>
  </body>
</html>
