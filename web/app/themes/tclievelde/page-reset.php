<?php

use Tclievelde\Tclievelde;

$error = '';

if (isset($_POST['submit_password'])) {
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];
    $email = $_POST['email'];
    if ($pass1 !== $pass2) {
        $error = 'De wachtwoorden komen niet overeen';
    } else if (strlen($pass1) < 7) {
        $error = 'Uw wachtwoord moet minimaal 7 tekens bevatten';
    } else {
        Tclievelde::insertData("UPDATE users SET wachtwoord='$pass1' WHERE email='$email'");
        header('location: /inloggen');
    }
}

if ($_GET['key'] && $_GET['reset']) {
    $email = $_GET['key'];
    $pass = $_GET['reset'];
    $getuser = Tclievelde::getData("SELECT email,wachtwoord FROM users where md5(email)='$email' and md5(wachtwoord)='$pass'");
    if ($getuser->num_rows > 0) {
        get_header();
        require 'page.php';
        ?>
        <div class="bg-blue">
            <div class="container section">
                <form class="col-6" method="post">
                    <input type="hidden" name="email" value="<?php print_r($getuser->fetch_assoc()['email']);?>">
                    <p>Nieuw wachtwoord:</p>
                    <input id="password1" type="password" name='password1' required>
                    <p>Herhaal wachtwoord:</p>
                    <input id="password2" type="password" name='password2' required>
                    <input class="c-button__primary mt-4" type="submit" name="submit_password">
                </form>
                <?php
                if ($error) {
                    echo '<p class="c-error__msg">'.$error.'</p>';
                }
                ?>
            </div>
        </div>
        <?php
    } else {
        require '404.php';
    }
    ?>
    <?php
}
    get_footer();
?>
