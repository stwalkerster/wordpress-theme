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
                    <span title="Gallery" class="glyphicon glyphicon-th-large"></span> <?php stw_posted_on(); ?>
                </p>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <?php if(comments_open() && ! post_password_required()) { comments_popup_link("Comments", 'Comments <span class="badge">1</span>', 'Comments <span class="badge">%</span>', ""); }?>
                    
                </div>
                <?php edit_post_link( 'Edit', '<div class="pull-right" style="margin: 0 1em">', '</div>' ); ?>
            </div>
        </div><!-- /row meta -->
           
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

        <div class="row" style="margin-top:2em;">
            <?php
                $catList = '';
                if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
                    $categories_list = get_the_category();
                    if(is_array($categories_list)) {
                        foreach ( $categories_list as $category ) {
                            $catList .= '<a href="'
                                . get_category_link( $category )
                                . '"><span class="label label-primary">' 
                                . $category->name 
                                . '</span></a> ';
                        }
                    }
                } 

                $tagList = '';
                if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) {
                    $tags_list = get_the_tags();
                    if(is_array($tags_list)) {
                        foreach ( $tags_list as $tag ) {
                            $tagList .= '<a href="'
                                . get_tag_link( $tag )
                                . '"><span class="label label-default">' 
                                . $tag->name 
                                . '</span></a> ';
                        }
                    }
                } 
                
                if($catList != '' && $tagList == '')
                {
                    echo '<div class="col-md-12">Categories: ' . $catList . '</div>';
                }
                if($catList == '' && $tagList != '')
                {
                    echo '<div class="col-md-12">Tags: ' . $tagList . '</div>';
                }
                
                if($catList != '' && $tagList != '')
                {
                    echo '<div class="col-md-6">Tags: ' . $tagList . '</div>';
                    echo '<div class="col-md-6">Categories: ' . $catList . '</div>';
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>