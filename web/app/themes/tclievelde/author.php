<?php
get_header();
$curr_auth = get_user_by('id', $author);

$args = array(
    'author'        =>  $author,
    'orderby'       =>  'post_date',
    'posts_per_page' => 10
);
?>
<div class="bg-blue">
    <div class="container section">
        <div>
            <h1>
                Auteur
            </h1>
            <div class="d-flex mt-3">
                <?php echo get_avatar(get_the_author_meta('ID')) ?>
                <div class="d-flex align-items-end ml-3">
                    <h2 class="m-0">
                        <?php if ($curr_auth->user_firstname) { ?>
                            <?php echo $curr_auth->user_firstname . ' ' . $curr_auth->user_lastname; ?>
                        <?php } else { ?>
                            <?php echo $curr_auth->display_name; ?>
                        <?php } ?>
                    </h2>
                </div>
            </div>
            <div class="mt-5">
                <?php
                foreach (get_posts($args) as $post) {
                    ?>
                    <div class="mt-5">
                        <a href="<?php echo get_permalink($post); ?>">
                            <div class="d-flex flex-md-row flex-column">
                                <div class="col-md-5">
                                    <?php if (get_the_post_thumbnail_url($post)) { ?>
                                        <img class="c-news__image" src="<?php echo get_the_post_thumbnail_url($post, 'original'); ?>" />
                                    <?php } else { ?>
                                        <img class="c-news__image" src="/app/themes/tclievelde/assets/images/300x200.jpg" />
                                    <?php } ?>
                                </div>
                                <div class="col-md-14 ml-md-4 news__content">
                                    <h2 class="c-news__heading">
                                        <?php echo $post->post_title; ?>
                                    </h2>
                                    <div class="article-post-content">
                                        <p>
                                            <?php echo get_the_excerpt($post); ?>
                                        </p>
                                    </div>
                                    <?php foreach (get_the_category($post) as $category) { ?>
                                        <div class="c-article__content-date">
                                            <?php
                                            echo $category->name;
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <div class="c-article__content-date">
                                        <?php
                                        $date = new DateTime($post->post_date);
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
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
