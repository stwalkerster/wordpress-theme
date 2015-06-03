<?php
/**
 * Template Name: Books page template
 * Description: A Page Template that adds the alternate sidebar to pages
 */

get_header(); ?>

                <div id="primary">
                        <div id="content" role="main">

                                <?php while ( have_posts() ) : the_post(); ?>

                                        <?php get_template_part( 'content', 'page' ); ?>
<div class="entry-content"><table><thead><tr>
        <th>Title</th>
        <th>Author</th>
        <th>Series</th>
</tr></thead><tbody>
<?php

$calibredata = new SimpleXMLElement(get_post_meta(get_the_ID(), 'calibre-data', true));
foreach($calibredata as $record)
{
        echo '<tr><td>' . $record->title . '</td><td>' . $record->authors->author . '</td><td /></tr>';
}


?>
</tbody></table></div>
                                        <?php comments_template( '', true ); ?>

                                <?php endwhile; // end of the loop. ?>

                        </div><!-- #content -->
                </div><!-- #primary -->
<?php get_footer(); ?>
