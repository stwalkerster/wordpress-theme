<?php
/*
    Template name: Showcase
*/

get_header(); 

$pageQuery = new WP_Query( array(
    'post_type' => array( 'page' ),
    'meta_key' => 'use_in_showcase',
    'meta_value' => '1',
    'posts_per_page' => 3,
    'orderby' => 'menu_order',
));
if( $pageQuery->have_posts() )
{
    ?><div class="row"><?php
    
    while( $pageQuery->have_posts() )
    {
        $pageQuery->the_post();
        ?>
        <div class="col-lg-4">
            <?php the_post_thumbnail( array(140,140), array('class' => 'img-circle') ); ?>
            <h2><?php echo get_the_title() ?></h2>
            <p><?php the_excerpt() ?></p>
            <p><a class="btn btn-default" href="<?php the_permalink() ?>" role="button">Read more &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <?php
    } // /while pageQuery->have_posts()
    ?></div><!-- /.row --><?php
}  // /if pageQuery->have_posts()

wp_reset_postdata();

$blogQuery = new WP_Query( array(
    'post__in' => get_option( 'sticky_posts' ),
    'post_status' => 'publish',
    'posts_per_page' => 10,
));

if( $blogQuery->have_posts() )
{
    $odd = true;
    while( $blogQuery->have_posts() )
    {
        $blogQuery->the_post();
        ?>
        <hr class="featurette-divider">
        
        <div class="row featurette">
            <?php if(!$odd) { ?>
            <div class="col-md-5">
            <?php the_post_thumbnail( array(500,500), array('class' => 'featurette-image img-responsive') ); ?> 
            </div>
            <?php } ?>

            <div class="col-md-7">
                <h2 class="featurette-heading"><?php echo get_the_title() ?></h2>
                <p class="lead"><?php the_excerpt() ?></p>
                <p><a class="btn btn-default" href="<?php the_permalink() ?>" role="button">Read more &raquo;</a></p>
            </div>
            <?php if($odd) { ?>
            <div class="col-md-5">
                <?php the_post_thumbnail( array(500,500), array('class' => 'featurette-image img-responsive') ); ?>
            </div>
            <?php } ?>
        </div>

        
        
        <?php
        
        $odd = !$odd;
    } // /while blogQuery->have_posts()
}  // /if blogQuery->have_posts()


wp_reset_postdata();

get_footer(); ?>