<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php bloginfo('template_url'); ?>/blocks-16.ico">

    <title>Carousel Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="<?php bloginfo('template_url'); ?>/carousel.css" rel="stylesheet">
    
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
  <body>