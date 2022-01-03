<?php
get_header();

require 'page.php';

$params = [
    'numberposts' => 10,
    'post_status' => 'publish',
];

$articles = 0;

$recent_articles = wp_get_recent_posts($params, 'OBJECT');
dd($recent_articles);
foreach ($recent_articles as $article) {
    if (!empty(get_post_field('afbeelding', $article))) {
        $articles++;
        ?>
        <div class="<?php if ($articles % 2 == 0) {
            echo "bg-blue";
                    } else {
                        echo "bg-white";
                    } ?>">
            <div class="container section">
                <a href="<?php echo $article->guid; ?>">
                    <div class="row">
                        <div class="col-5">
                            <img class="c-news__image" src="<?php echo get_field('afbeelding', $article)['url']; ?>" />
                        </div>
                        <div class="col-14 ml-4 news__content">
                            <h2 class="c-news__heading">
                                <?php echo $article->post_title; ?>
                            </h2>
                            <?php echo $article->post_content ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php
    }
}
?>
<?php
get_footer();
?>