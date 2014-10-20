<div class="row">
    <div <?php post_class("col-xs-12") ?>>
            

           
        <div class="row">
            <div class="col-xs-12 item-content">
                <?php if ( is_search() ) : ?>
                    <?php the_excerpt(); ?>
                <?php else : ?>
                    <?php the_content( 'Continue reading <span class="meta-nav">&raquo;</span>' ); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . 'Pages:' . '</span>', 'after' => '</div>' ) ); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="post-meta muted">
                    <span title="Image" class="glyphicon glyphicon-picture"></span> <?php stw_posted_on(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
                </div>
            </div>
        </div><!-- /row meta -->
             
        
        
    </div>
</div>