<div class="row">
    <div <?php post_class("col-xs-12") ?>>
        <div class="page-header">
            <h1>
                <?php the_title(); ?>            
                <?php if ( is_sticky() ) : ?>
                    <small><span class="label label-info">Featured</span></small>
                <?php endif; ?>
            </h1>
        </div>
            
        <div class="row">
            <div class="col-md-6">
                <p class="post-meta muted">
                    <span title="Chat" class="glyphicon glyphicon-bullhorn"></span> <?php stw_posted_on(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
            </div>
        </div><!-- /row meta -->
           
        <div class="row">
            <div class="col-xs-12 item-content">
                <?php if ( is_search() ) : ?>
                    <pre><?php the_excerpt(); ?></pre>
                <?php else : ?>
                    <pre><?php the_content( 'Continue reading <span class="meta-nav">&raquo;</span>' ); ?></pre>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . 'Pages:' . '</span>', 'after' => '</div>' ) ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>