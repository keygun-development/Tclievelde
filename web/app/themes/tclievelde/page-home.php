<?php
    get_header();
    require 'page.php';
    $params = [
        'numberposts' => 2,
        'post_status' => 'publish',
    ];

    $recent_articles = wp_get_recent_posts($params, 'OBJECT');
    ?>
<div class="container section">
    <div class="py-5">
        <h2>
            Recente artikelen
        </h2>
        <div class="mt-5 d-flex">
            <?php
            foreach ($recent_articles as $article) {
                ?>
                <a href="<?php echo get_permalink($article); ?>">
                    <div class="c-article__img" style="background-image: url('<?php echo get_the_post_thumbnail_url($article, 'original'); ?>');">
                        <div class="c-article__overlay"></div>
                        <div class="c-article__content">
                            <h2>
                                <?php echo $article->post_title; ?>
                            </h2>
                            <div class="c-article__content-text">
                                <p>
                                    <?php echo get_field('show_article_text', $article); ?>
                                </p>
                            </div>
                            <div class="c-article__content-date">
                                <?php
                                    $date = new DateTime($article->post_date);
                                    echo $date->format('Y-m-d');
                                ?>
                            </div>
                            <div class="c-article__content-date">
                                Door: <?php echo get_the_author(); ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <div class="d-flex justify-content-end">
            <a href="/actueel">
                Bekijk meer artikelen
            </a>
        </div>
    </div>
</div>
<?php
    get_footer();
?>