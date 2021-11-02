<?php
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
        <div class="row">
            <a href="?gebruikersnaam" class="c-button__primary">
                Gebruikersnaam vergeten
            </a>
            <a href="?wachtwoord" class="c-button__primary ml-5">
                Wachtwoord vergeten
            </a>
        </div>
    </div>
</div>
<?php
    get_footer();
?>
