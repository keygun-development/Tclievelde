<?php

use Tclievelde\Tclievelde;

$edit = false;
$errmsg = '';
$error = false;
$availability = '';

$cookieuser = $_COOKIE["user"];
$user = Tclievelde::getData("SELECT * FROM users WHERE md5(gebruikersnaam)='$cookieuser'");
$user = $user->fetch_assoc();

$reserveringen = Tclievelde::getData("SELECT * FROM reserveringen");

$mijnreservering = null;

while ($reservering = $reserveringen->fetch_assoc()) {
    if ($reservering['Lidnummer'] == $user['voornaam'].'-'.$user['lidnummer'] || $reservering['Medespeler1'] == $user['voornaam'].'-'.$user['lidnummer'] || $reservering['Medespeler2'] == $user['voornaam'].'-'.$user['lidnummer'] || $reservering['Medespeler3'] == $user['voornaam'].'-'.$user['lidnummer']) {
        $mijnreservering = $reservering;
    }
}

if (!$mijnreservering) {
    header('location: reserveren');
}

if (isset($_GET['delres'])) {
    $id = $_GET['delres'];
    Tclievelde::insertData("DELETE FROM reserveringen WHERE Id=".$id);
    header('location: reserveren');
}

if (isset($_GET['edit'])) {
    $reservering = $_GET['edit'];
    $reservering = Tclievelde::getData("SELECT * FROM reserveringen WHERE Id=".$reservering);
    if ($reservering->num_rows > 0) {
        $edit = true;
        $reservering = $reservering->fetch_assoc();
        $resid = $reservering['Id'];
        $lidnummer = $reservering['Lidnummer'];
        $baan = $reservering['Baan'];
        $speler1 = $reservering['Medespeler1'];
        $speler2 = $reservering['Medespeler2'];
        $speler3 = $reservering['Medespeler3'];
        $datum = $reservering['Datum'];
        $tijd = $reservering['Tijd'];
    }
}

if (isset($_POST['opslaan'])) {
    $id = $_POST['id'];
    $lidnummer = $_POST['speler1'];
    $medespeler1 = $_POST['speler2'] ?? 0;
    if ($medespeler1 !== 0) {
        $medespelertje1 = Tclievelde::getData("SELECT * FROM users");
        while ($mede1 = $medespelertje1->fetch_assoc()) {
            if ($mede1['voornaam'].'-'.$mede1['lidnummer'] === $_POST['speler2']) {
                $medespeler1 = $_POST['speler2'];
            }
        }
    }

    $medespeler2 = $_POST['speler3']?? 0;
    if ($medespeler2 !== 0) {
        $medespelertje2 = Tclievelde::getData("SELECT * FROM users");
        while ($mede2 = $medespelertje2->fetch_assoc()) {
            if ($mede2['voornaam'].'-'.$mede2['lidnummer'] === $_POST['speler3']) {
                $medespeler2 = $_POST['speler3'];
            }
        }
    }

    $medespeler3 = $_POST['speler4']?? 0;
    if ($medespeler3 !== 0) {
        $medespelertje3 = Tclievelde::getData("SELECT * FROM users");
        while ($mede3 = $medespelertje3->fetch_assoc()) {
            if ($mede3['voornaam'].'-'.$mede3['lidnummer'] === $_POST['speler4']) {
                $medespeler3 = $_POST['speler4'];
            }
        }
    }

    $baan = $_POST['baan'];
    $datum = date('d-m-Y', strtotime($_POST['datum']));
    $tijd = $_POST['tijd'];
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
    $thisreservation = Tclievelde::getData("SELECT * FROM reserveringen WHERE ID=$id");
    $dtb = Tclievelde::getData("SELECT Datum, Tijd FROM reserveringen WHERE Datum = '$datum' AND Tijd = '$tijd' AND Baan ='$baan'");
    $thisreservation = $thisreservation->fetch_assoc();
    if ($medespeler1 !== 0) {
        $availability = checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, $thisreservation);
    } else if ($medespeler2 !== 0) {
        $availability = checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, $thisreservation);
    } else if ($medespeler3 !== 0) {
        $availability = checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, $thisreservation);
    }
    if ($dtb->num_rows > 1) {
        $errmsg = 'Helaas wordt er al gespeeld op dit tijdstip op deze baan. Probeer een ander tijdstip of baan';
        $error = true;
    }
    if (!$availability) {
        $update = Tclievelde::insertData("UPDATE reserveringen SET Lidnummer='$lidnummer', Baan='$baan', Medespeler1='$medespeler1', Medespeler2='$medespeler2', Medespeler3='$medespeler3', Datum='$datum', Tijd='$tijd' WHERE Id = '$id'");
        header('location: /reservering');
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
                    <input type="hidden" value="<?php echo $resid; ?>" name="id" />
                    <p>
                        Zoek naar spelers:
                    </p>
                    <input type="text" id="searchbar" />
                    <div class="c-match__player-selector mt-3">
                        <?php
                        $spelers = Tclievelde::getData("SELECT * FROM users");
                        while ($lid = $spelers->fetch_assoc()) {
                            ?>
                            <div id="<?php if ($lid['voornaam'].'-'.$lid['lidnummer'] === $reservering['Lidnummer']) {
                                echo 'lidnummer';
                                     } ?>" class="c-match__single-player <?php if ($lid['gebruikersnaam'] == $user['gebruikersnaam']) {
                                echo 'no-deselect';
                                     }
                                     if ($lid['voornaam'].'-'.$lid['lidnummer'] !== $reservering['Lidnummer'] && $lid['gebruikersnaam'] == $user['gebruikersnaam']) {
                                         echo 'active-player';
                                     }
                                        ?>">
                                <p>
                                    <?php echo $lid['voornaam'].' - '.$lid['lidnummer']; ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-10">
                        <p>
                            Spelers:
                        </p>
                        <div id="allspelers" class="d-flex flex-column c-match__allwij">
                            <?php
                            for ($i=1; $i<4; $i++) {
                                if ($mijnreservering['Medespeler'.$i]) {
                                    echo '<input class="active-players" name="speler'.$i.'"value="'.$mijnreservering['Medespeler'.$i].'" readonly />';
                                }
                            } ?>
                        </div>
                    </div>
                    <p>
                        Baan:
                    </p>
                    <select name="baan">
                        <option <?php if ($mijnreservering['Baan'] == 'Baan 1') {
                            echo 'selected';
                                } ?>>Baan 1</option>
                        <option <?php if ($mijnreservering['Baan'] == 'Baan 2') {
                            echo 'selected';
                                } ?>>Baan 2</option>
                    </select>
                    <p>
                        Datum en tijd:
                    </p>
                    <div class="d-flex">
                        <input type="date" name="datum" value="<?php echo date('Y-m-d', strtotime($mijnreservering['Datum'])); ?>" />
                        <select class="ml-3" name="tijd">
                            <option <?php if ($mijnreservering['Tijd'] == '09:00-10:00') {
                                echo 'selected';
                                    } ?>>09:00-10:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '10:00-11:00') {
                                echo 'selected';
                                    } ?>>10:00-11:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '11:00-12:00') {
                                echo 'selected';
                                    } ?>>11:00-12:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '12:00-13:00') {
                                echo 'selected';
                                    } ?>>12:00-13:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '13:00-14:00') {
                                echo 'selected';
                                    } ?>>13:00-14:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '14:00-15:00') {
                                echo 'selected';
                                    } ?>>14:00-15:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '15:00-16:00') {
                                echo 'selected';
                                    } ?>>15:00-16:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '16:00-17:00') {
                                echo 'selected';
                                    } ?>>16:00-17:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '17:00-18:00') {
                                echo 'selected';
                                    } ?>>17:00-18:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '18:00-19:00') {
                                echo 'selected';
                                    } ?>>18:00-19:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '19:00-20:00') {
                                echo 'selected';
                                    } ?>>19:00-20:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '20:00-21:00') {
                                echo 'selected';
                                    } ?>>20:00-21:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '21:00-22:00') {
                                echo 'selected';
                                    } ?>>21:00-22:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '22:00-23:00') {
                                echo 'selected';
                                    } ?>>22:00-23:00</option>
                            <option <?php if ($mijnreservering['Tijd'] == '23:00-24:00') {
                                echo 'selected';
                                    } ?>>23:00-00:00</option>
                        </select>
                    </div>
                    <input type="submit" class="c-button__primary mt-3" name="opslaan" value="Opslaan" />
                </form>
                <?php
                if ($errmsg) {
                    echo $errmsg;
                }
                if ($availability !== false) {
                    echo $availability;
                }
                ?>
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

