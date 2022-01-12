<?php

use Tclievelde\Tclievelde;

$newreservation = false;
$errmsg = '';
$availability = '';

if (isset($_COOKIE['user'])) {
    $cookieuser = $_COOKIE["user"];
    $user = Tclievelde::getData("SELECT * FROM wp_users WHERE md5(user_login)='$cookieuser'");
    $user = $user->fetch_assoc();
} else {
    header('location: /inloggen');
}

$reserveringen = Tclievelde::getData("SELECT * FROM reserveringen");

if (isset($_GET['newreservation'])) {
    $res = Tclievelde::getData("SELECT * FROM reserveringen");
    if ($res->num_rows > 0) {
        while ($rest = $res->fetch_assoc()) {
            if ($user['voornaam'].'-'.$user['lidnummer'] !== $rest['Lidnummer'] && $user['voornaam'].'-'.$user['lidnummer'] !== $rest['Medespeler1'] && $user['voornaam'].'-'.$user['lidnummer'] !== $rest['Medespeler2'] && $user['voornaam'].'-'.$user['lidnummer'] !== $rest['Medespeler3']) {
                $newreservation = true;
            } else {
                $newreservation = false;
                $errmsg = 'U kunt maar 1 keer reserveren';
            }
        }
    } else {
        $newreservation = true;
    }
}

if (isset($_POST['aanmaken'])) {
    $baan = $_POST['baan'];
    $datum = date('d-m-Y', strtotime($_POST['date']));
    $tijd = $_POST['time'];
    $lidnummer = $_POST['speler1'] ?? 0;
    if ($lidnummer !== 0) {
        $lidnummer = Tclievelde::getData("SELECT * FROM users WHERE '$lidnummer' = users.gebruikersnaam");
        $lidnummer = $lidnummer->fetch_assoc();
        $lidnummer = $lidnummer['voornaam'].'-'.$lidnummer['lidnummer'];
    }
    $medespeler1 = $_POST['speler2'] ?? 0;
    if ($medespeler1 !== 0) {
        $medespeler1 = Tclievelde::getData("SELECT * FROM users WHERE '$medespeler1' = users.gebruikersnaam");
        $medespeler1 = $medespeler1->fetch_assoc();
        $medespeler1 = $medespeler1['voornaam'].'-'.$medespeler1['lidnummer'];
    }
    $medespeler2 = $_POST['speler3'] ?? 0;
    if ($medespeler2 !== 0) {
        $medespeler2 = Tclievelde::getData("SELECT * FROM users WHERE '$medespeler2' = users.gebruikersnaam");
        $medespeler2 = $medespeler2->fetch_assoc();
        $medespeler2 = $medespeler2['voornaam'].'-'.$medespeler2['lidnummer'];
    }
    $medespeler3 = $_POST['speler4'] ?? 0;
    if ($medespeler3 !== 0) {
        $medespeler3 = Tclievelde::getData("SELECT * FROM users WHERE '$medespeler3' = users.gebruikersnaam");
        $medespeler3 = $medespeler3->fetch_assoc();
        $medespeler3 = $medespeler3['voornaam'].'-'.$medespeler3['lidnummer'];
    }
    $lidn1 = Tclievelde::getData("SELECT Medespeler1 FROM reserveringen WHERE Medespeler1 = '$lidnummer'");
    $lidn2 = Tclievelde::getData("SELECT Medespeler2 FROM reserveringen WHERE Medespeler2 = '$lidnummer'");
    $lidn3 = Tclievelde::getData("SELECT Medespeler3 FROM reserveringen WHERE Medespeler3 = '$lidnummer'");
    $m11 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler1 = '$medespeler1'");
    $m12 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler1 = '$medespeler2'");
    $m13 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler1 = '$medespeler3'");
    $m21 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler2 = '$medespeler1'");
    $m22 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler2 = '$medespeler2'");
    $m23 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler2 = '$medespeler3'");
    $m31 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler3 = '$medespeler1'");
    $m32 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler3 = '$medespeler2'");
    $m33 = Tclievelde::getData("SELECT * FROM reserveringen WHERE Medespeler3 = '$medespeler3'");
    $allreserveringlidnummers = Tclievelde::getData("SELECT Lidnummer FROM reserveringen");
    if ($medespeler1 !== 0) {
        $availability = checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, null);
    } else if ($medespeler2 !== 0) {
        $availability = checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, null);
    } else if ($medespeler3 !== 0) {
        $availability = checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, null);
    }
    if (!$availability) {
        $insert = Tclievelde::insertData("INSERT INTO reserveringen (Lidnummer, Baan, Medespeler1, Medespeler2, Medespeler3, Datum, Tijd) VALUES ('$lidnummer', '$baan', '$medespeler1', '$medespeler2', '$medespeler3', '$datum', '$tijd')");
        header('location: /reserveren');
    }
}

get_header();
require 'page.php';
?>
<div class="bg-blue">
    <div class="container section">
    <?php
    if ($user['isAdmin']) {
        ?>
        <h2>
            Admin controls
        </h2>
        <div class="d-flex">
            <a href="/wp/wp-admin" class="c-button__primary">
                Adminpaneel
            </a>
            <a href="?afschermen" class="c-button__primary ml-4">
                Baan afschermen
            </a>
        </div>
        <?php
    }
    ?>
        <div class="d-inline-block mt-5">
            <h2>
                Inzicht
            </h2>
            <a class="c-button__primary" href="/reservering">
                Reservering
            </a>
        </div>

        <div class="mt-5">
            <?php if ($newreservation) { ?>
                <h2>
                    Nieuwe reservering
                </h2>
                <div class="c-match__newmatch-wrapper">
                    <form method="post" class="c-match__newmatch">
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
                        <p>
                            Baan:
                        </p>
                        <select name="baan">
                            <option>
                                Baan 1
                            </option>
                            <option>
                                Baan 2
                            </option>
                        </select>
                        <p>
                            Datum en tijd:
                        </p>
                        <div>
                            <input type="date" name="date" />
                            <select name="time">
                                <option>09:00-10:00</option>
                                <option>10:00-11:00</option>
                                <option>11:00-12:00</option>
                                <option>12:00-13:00</option>
                                <option>13:00-14:00</option>
                                <option>14:00-15:00</option>
                                <option>15:00-16:00</option>
                                <option>16:00-17:00</option>
                                <option>17:00-18:00</option>
                                <option>18:00-19:00</option>
                                <option>19:00-20:00</option>
                                <option>20:00-21:00</option>
                                <option>21:00-22:00</option>
                                <option>22:00-23:00</option>
                                <option>23:00-00:00</option>
                            </select>
                        </div>
                        <div id="players" class="d-flex flex-wrap c-match__players-select mt-3">
                            <div class="col-20">
                                <p>
                                    Geselecteerde spelers:
                                </p>
                                <div name="spelerswij" id="allspelers" class="d-flex flex-column c-match__allwij">

                                </div>
                            </div>
                        </div>
                        <p id="errmsg" class="c-error__msg"></p>
                        <input type="submit" class="c-button__primary mt-3" value="Aanmaken" name="aanmaken" />
                    </form>
                </div>
            <?php } else { ?>
                <div class="d-flex align-items-end">
                    <h2 class="m-0">
                        Alle reserveringen
                    </h2>
                    <a href="?newreservation" class="c-button__primary ml-5">
                        Nieuwe reservering
                    </a>
                </div>
                <div class="c-match__wrapper mt-5">
                    <?php
                    while ($reservering = $reserveringen->fetch_assoc()) {
                        ?>
                        <div class="c-match__single">
                            <p>
                                <b>Datum en tijd:</b><br> <?php echo $reservering['Datum'].' '.$reservering['Tijd']; ?>
                            </p>
                            <p>
                                <b>Baan:</b> <?php echo $reservering['Baan']; ?>
                            </p>
                            <div class="d-flex justify-content-between">
                                <p>
                                    <?php echo $reservering['Lidnummer']; ?>
                                </p>
                                <p>
                                    <?php echo $reservering['Medespeler1']; ?>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>
                                    <?php echo $reservering['Medespeler2']; ?>
                                </p>
                                <p>
                                    <?php echo $reservering['Medespeler3']; ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }?>
                </div>
            <?php } if ($errmsg) {
                echo '<p class="c-error__msg">'.$errmsg.'</p>';
            } if ($availability) {
                echo '<p class="c-error__msg">'.$availability.'</p>';
            }?>
        </div>
    </div>
</div>
<?php
get_footer();

