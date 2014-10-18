<?php get_header(); ?>
<div class="row">
    <div class="col-sm-12" id="content">
        <?php 
            if ( have_posts() ) {
                /* Start the Loop */
                while ( have_posts() ) { 
                    the_post();
        
                    get_template_part( 'content', get_post_format() );
                    
                    if( stw_has_more_posts() )
                    {
                        echo '<hr />';
                    }
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