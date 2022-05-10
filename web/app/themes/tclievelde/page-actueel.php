<?php
get_header();

require 'page.php';

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$query = new WP_Query([
    'posts_per_page' => 2,
    'post_status' => 'publish',
    'paged' => $paged,
    'post_type' => 'post'
]);

$articles = 0;

$recent_articles = wp_get_recent_posts($query, 'OBJECT');

while ($query->have_posts()) :
    $query->the_post();
    $articles++;
    ?>
        <div class="<?php if ($articles % 2 == 0) {
            echo "bg-blue";
                    } else {
                        echo "bg-white";
                    } ?>">
            <div class="container section">
                <a href="<?php echo the_permalink(); ?>">
                    <div class="d-md-flex flex-md-row flex-column">
                        <div class="col-md-5 col-20">
                            <?php if (has_post_thumbnail()) { ?>
                                <img class="c-news__image" src="<?php echo the_post_thumbnail_url('full') ?>" />
                            <?php } else { ?>
                                <img class="c-news__image" src="/app/themes/tclievelde/assets/images/300x200.jpg" />
                            <?php } ?>
                        </div>
                        <div class="col-md-14 col-20 news__content">
                            <h2 class="c-news__heading">
                                <?php echo the_title(); ?>
                            </h2>
                            <div class="article-post-content">
                                <p>
                                    <?php echo the_excerpt(); ?>
                                </p>
                            </div>
                            <?php foreach (get_the_category(get_the_ID()) as $category) { ?>
                            <div class="c-article__content-date">
                                <?php
                                    echo $category->name;
                                ?>
                            </div>
                            <?php } ?>
                            <div class="c-article__content-date">
                                <?php
                                echo get_the_date();
                                ?>
                            </div>
                            <div class="c-article__content-date">
                                Door: <?php echo get_the_author(); ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php
endwhile;
?>
<div class="bg-blue d-flex justify-content-center c-pagination">
    <?php
    proa_pagination($query, true);
    ?>
</div>
<?php

wp_reset_postdata();

?>
<?php
get_footer();
?>