<?php

use Tclievelde\Tclievelde;

if (isset($_COOKIE['user'])) {
    $cookieuser = $_COOKIE["user"];
    $user = Tclievelde::getData("SELECT * FROM wp_users WHERE md5(user_login)='$cookieuser'");
    $user = $user->fetch_assoc();
}
?>
<div class="bg-blue">
    <div class="container section">
        <div class="d-flex flex-lg-row flex-column justify-content-between">
            <div class="<?php if (!empty(get_the_post_thumbnail())) {
                ?>col-lg-10 col-20 <?php
                        } else {
                            echo 'col-20';
                        } ?>">
                <h1>
                    <?php echo get_the_title(); ?>
                </h1>
                <?php
                if (get_page_uri() == 'reserveren') {
                    echo '<p class="col-lg-10 col-20">Welkom in het reserveringsportaal ' . $user['user_login'] .', kies hieronder uit een aantal opties om een nieuwe reservering aan te maken of alle reserveringen in te zien.</p>';
                }
                ?>
                <p>
                    <?php the_content(); ?>
                </p>
            </div>
            <?php if (!empty(get_the_post_thumbnail())) { ?>
            <div class="col-lg-6 col-20 ml-lg-4">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" />
            </div>
            <?php } ?>
        </div>
    </div>
</div>
