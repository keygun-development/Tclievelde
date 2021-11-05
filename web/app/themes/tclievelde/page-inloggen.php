<?php

    use Tclievelde\Tclievelde;

if (isset($_POST['inloggen'])) {
    $username = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $user = Tclievelde::getUser($username, $wachtwoord);
    $error = $user;
}

get_header();
require 'page.php';
?>
<div class="bg-blue">
    <div class="container section">
        <form method="post" class="col-6">
            <p>
                Gebruikersnaam:
            </p>
            <input name="gebruikersnaam" type="text" />
            <p>
                Wachtwoord:
            </p>
            <input name="wachtwoord" type="password" />
            <input type="submit" class="c-button__primary mt-5" name="inloggen" value="Verzenden" />
        </form>
        <?php if ($error) {
            echo '<p class="c-error__msg">'.$error.'</p>';
        } ?>
        <div class="col-10 mt-4">
            <p>
                Bent u uw gebruikersnaam of wachtwoord vergeten? Of komt u hier voor de eerste keer en u had al een account? Klik dan hieronder om uw toegang terug te krijgen.
            </p>
            <a class="c-button__primary col-4" href="/vergeten">
                Vergeten
            </a>
        </div>
    </div>
</div>
<?php
    get_footer();
?>