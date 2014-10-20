<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?php wp_title("&raquo;", true, "RIGHT"); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="<?php bloginfo('stylesheet_url'); echo '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" rel="stylesheet" />
    
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
                    'theme_location' => 'header-menu' ,
                    'container_class' => 'navbar-collapse collapse',
                    'menu_class' => 'nav navbar-nav',
                    'walker' => new StwNavMenuWalker(),
                    'fallback_cb' => 'stw_nav_fallback'
                    ) ); ?>
          </div>
        </div>

      </div>
    </div>


    <!-- Header images
    ================================================== -->
    <div class="carousel">
      <div class="carousel-inner">
        <div class="item active">
          <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
          <div class="container">
            <div class="carousel-caption">
              <p><?php bloginfo('description'); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->
    <div class="container marketing"> <!-- this is closed in footer.php -->
