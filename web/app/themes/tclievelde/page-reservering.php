<?php

use Tclievelde\Tclievelde;

$edit = false;

$cookieuser = $_COOKIE["user"];
$user = Tclievelde::getData("SELECT * FROM users WHERE md5(gebruikersnaam)='$cookieuser'");
$user = $user->fetch_assoc();

$reserveringen = Tclievelde::getData("SELECT * FROM reserveringen");

$mijnreservering = null;

while ($reservering = $reserveringen->fetch_assoc()) {
    if ($reservering['Lidnummer'] == $user['voornaam'].' - '.$user['lidnummer'] || $reservering['Medespeler1'] == $user['voornaam'].' - '.$user['lidnummer'] || $reservering['Mederspeler2'] == $user['voornaam'].' - '.$user['lidnummer'] || $reservering['Medespeler3'] == $user['voornaam'].' - '.$user['lidnummer']) {
        $mijnreservering = $reservering;
    }
}

if (isset($_GET['edit'])) {
    $reservering = $_GET['edit'];
    $reservering = Tclievelde::getData("SELECT * FROM reserveringen WHERE Id=".$reservering);
    if ($reservering->num_rows > 0) {
        $edit = true;
        $reservering = $reservering->fetch_assoc();
        $id = $reservering['Id'];
        $lidnummer = $reservering['Lidnummer'];
        $baan = $reservering['Baan'];
        $speler1 = $reservering['Medespeler1'];
        $speler2 = $reservering['Medespeler2'];
        $speler3 = $reservering['Medespeler3'];
        $datum = $reservering['Datum'];
        $tijd = $reservering['Tijd'];
    }
}

get_header();
require 'page.php';
?>
<div class="bg-blue">
    <div class="container section">
        <?php
        if ($edit) {
            ?>
            <div class="c-match__newmatch">
                <form method="post">
                    <p>
                        Zoek naar spelers:
                    </p>
                    <input type="text" id="searchbar" />
                    <div class="c-match__player-selector mt-3">
                        <?php
                        $spelers = Tclievelde::getData("SELECT * FROM users");
                        while ($lid = $spelers->fetch_assoc()) {
                            ?>
                            <div class="c-match__single-player <?php if ($lid['gebruikersnaam'] == $user['gebruikersnaam']) {
                                echo 'active-player no-deselect';
                                                               } ?>">
                                <p>
                                    <?php echo $lid['gebruikersnaam']; ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                </form>
            </div>
            <?php
        } else {
            ?>
        <div class="c-match__single">
            <p>
                <b>
                    Datum en tijd:
                </b>
                <br>
            <?php echo $mijnreservering['Datum'].' '.$mijnreservering['Tijd']; ?>
            </p>
            <p>
                <b>
                    Baan:
                </b>
            <?php echo $mijnreservering['Baan']; ?>
            </p>
            <div class="d-flex justify-content-between">
                <p>
                <?php echo $mijnreservering['Lidnummer']; ?>
                </p>
                <p>
                <?php echo $mijnreservering['Medespeler1']; ?>
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <p>
                <?php echo $mijnreservering['Medespeler2']; ?>
                </p>
                <p>
                <?php echo $mijnreservering['Medespeler3']; ?>
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <a href="?edit=<?php echo $mijnreservering['Id'] ?>">
                    Bewerken
                </a>
                <a href="?delres=<?php echo $mijnreservering['Id'] ?>">
                    Verwijderen
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
get_footer();

