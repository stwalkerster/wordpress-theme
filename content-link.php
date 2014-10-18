<div class="row">
    <div <?php post_class("col-xs-12") ?>>

           
        <div class="row">
            <div class="col-xs-12 item-content lead">
                <?php the_content(); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <p class="post-meta muted">
                    <span title="Link" class="glyphicon glyphicon-globe"></span> <?php stw_posted_on(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
            </div>
        </div><!-- /row meta -->
    </div>
</div>