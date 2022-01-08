<?php

foreach (get_the_category($post) as $category) {
    $params = [
        'category_name' => $category->name,
        'numberposts' => 3,
        'post_status' => 'publish',
        'orderby'   => 'rand',
    ];
}

$recent_articles = wp_get_recent_posts($params, 'OBJECT');

get_header();
?>
<div class="bg-blue">
    <div class="container section">
        <h1>
            <?php echo get_the_title(); ?>
        </h1>
        <p>
            <?php echo get_the_content(); ?>
        </p>
        <div class="divider mt-5"></div>
        <div class="mt-5">
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                <div class="d-flex">
                    <?php echo get_avatar(get_the_author_meta('ID')) ?>
                    <div class="d-flex flex-column justify-content-end ml-5">
                        <h2 class="m-0">
                            Auteur
                        </h2>
                        <p class="m-0">
                            <?php echo get_the_author(); ?>
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="mt-5">
            <h2>
                Gerelateerde artikelen
            </h2>
            <div class="col-20">
                <?php foreach ($recent_articles as $article) { ?>
                    <div class="c-article__related mb-4">
                        <a href="<?php echo $article->guid; ?>">
                            <div class="d-flex col-20">
                                <div class="col-6">
                                    <?php if (get_the_post_thumbnail_url($article)) { ?>
                                        <img class="c-news__image" src="<?php echo get_the_post_thumbnail_url($article, 'original'); ?>" />
                                    <?php } else { ?>
                                        <img class="c-news__image" src="/app/themes/tclievelde/assets/images/300x200.jpg" />
                                    <?php } ?>
                                </div>
                                <div class="ml-5 col-14">
                                    <h2 class="c-news__heading">
                                        <?php echo $article->post_title; ?>
                                    </h2>
                                    <div class="article-post-content">
                                        <p>
                                            <?php echo get_the_excerpt($article); ?>
                                        </p>
                                    </div>
                                    <?php foreach (get_the_category($article) as $category) { ?>
                                        <div class="c-article__content-date">
                                            <?php
                                            echo $category->name;
                                            ?>
                                        </div>
                                    <?php } ?>
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
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
    get_footer();
?>
