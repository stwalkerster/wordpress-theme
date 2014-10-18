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
    
            <article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title">Nothing was found!</h1>
                </header><!-- .entry-header -->
    
                <div class="entry-content">
                    <p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-0 -->
    
        <?php } ?>

    </div>
  </div>

<?php get_footer(); ?>