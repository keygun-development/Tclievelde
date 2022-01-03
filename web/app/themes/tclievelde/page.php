<?php

use Tclievelde\Tclievelde;

if (isset($_COOKIE['user'])) {
    $cookieuser = $_COOKIE["user"];
    $user = Tclievelde::getData("SELECT * FROM users WHERE md5(gebruikersnaam)='$cookieuser'");
    $user = $user->fetch_assoc();
}
?>
<div class="bg-blue">
    <div class="container section">
        <div class="row justify-content-between">
            <div class="col-10">
                <h1>
                    <?php echo get_the_title(); ?> bla
                </h1>
                <?php
                if (get_page_uri() == 'reserveren') {
                    echo '<p>Welkom ' . $user['voornaam'] . ', reserveren kan hieronder.</p>';
                }
                ?>
                <p>
                    <?php echo get_field('tekst'); ?>
                </p>
            </div>
            <div class="col-6 ml-4">
                <?php if (!empty(get_field('afbeelding'))) { ?>
                    <img src="<?php echo get_field('afbeelding')['url']; ?>" />
                <?php } ?>
            </div>
        </div>
    </div>
</div>