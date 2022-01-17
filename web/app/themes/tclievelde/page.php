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
        <div class="row justify-content-between">
            <div class="<?php if (!empty(get_the_post_thumbnail())) {
                ?>col-10 <?php
                        } else {
                            echo 'col-20';
                        } ?>">
                <h1>
                    <?php echo get_the_title(); ?>
                </h1>
                <?php
                if (get_page_uri() == 'reserveren') {
                    echo '<p>Welkom ' . $user['user_login'] . ', reserveren kan hieronder.</p>';
                }
                ?>
                <p>
                    <?php the_content(); ?>
                </p>
            </div>
            <?php if (!empty(get_the_post_thumbnail())) { ?>
            <div class="col-6 ml-4">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" />
            </div>
            <?php } ?>
        </div>
    </div>
</div>
