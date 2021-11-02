<?php

/**
 * @param WP_Post $article
 */
function tclievelde_hero_article(WP_Post $article)
{
    ?>
    <div onclick="window.location = '<?php echo get_permalink($article) ?>'">
        <h3><?php echo get_the_title($article); ?></h3>
        <?php echo $article->post_content; ?>
    </div>
    <?php
}
