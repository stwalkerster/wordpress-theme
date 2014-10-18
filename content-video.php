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
                    <span title="Video" class="glyphicon glyphicon-film"></span> <?php stw_posted_on(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
            </div>
        </div><!-- /row meta -->
           
        <div class="row">
            <div class="col-xs-12 item-content">
                <?php the_content( ); ?>
            </div>
        </div>
    </div>
</div>