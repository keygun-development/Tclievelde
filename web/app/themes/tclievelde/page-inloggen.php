<?php

    use Tclievelde\Tclievelde;

if (isset($_COOKIE['user'])) {
    header('location: /reserveren');
}

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
        <form method="post" class="col-md-6">
            <p>
                Emailadres:
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
    </div>
</div>
<?php
    get_footer();
?>
