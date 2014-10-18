<?php get_header(); ?>
<div class="row">
    <div class="col-sm-12" id="content">
        <?php 
            if ( have_posts() ) {
                /* Start the Loop */
                while ( have_posts() ) { 
                    the_post();
        
                    ?>
                    <div class="row">
                        <div <?php post_class("col-xs-12") ?>>
                            <div class="page-header">
                                <h1>
                                    <?php the_title(); ?>
                                </h1>
                            </div>
                                
                            <div class="row">
                                <div class="col-md-6 col-md-offset-6">
                                    <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
                                </div>
                            </div><!-- /row meta -->
                            
                            <div class="row">
                                <div class="col-xs-12 item-content">
                                    <?php the_content( 'Continue reading <span class="meta-nav">&raquo;</span>' ); ?>
                                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . 'Pages:' . '</span>', 'after' => '</div>' ) ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                
                stw_pager();
            }
            else
            {
            ?>
    
                <div class="row">
                    <div id="post-0" class="col-xs-12 post no-results not-found">
                        <div class="page-header">
                            <h1>
                                Nothing was found!
                            </h1>
                        </div>
                           
                        <div class="row">
                            <div class="col-xs-12 item-content">
                                <p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                    </div>
                </div>
    
        <?php } ?>

    </div>
</div>

<?php get_footer(); ?>