<div class="row">
    <div <?php post_class("col-xs-12") ?>>    
           
        <div class="row">
            <div class="col-xs-12 item-content lead">
                <?php the_content( ); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <p class="post-meta muted">
                    <span title="Status" class="glyphicon glyphicon-asterisk"></span> <?php stw_posted_on(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <?php if(comments_open() && ! post_password_required()) { comments_popup_link("Comments", 'Comments <span class="badge">1</span>', 'Comments <span class="badge">%</span>', ""); }?>
                    
                </div>
                <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
            </div>
        </div><!-- /row meta -->
        <div class="clearfix"></div>
    </div>
</div>