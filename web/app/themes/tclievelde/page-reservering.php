<?php

use functions\customposts\Proa_Reservation;
use Tclievelde\Tclievelde;

$edit = false;
$errmsg = '';
$error = false;
$succes = '';

if (isset($_COOKIE['user'])) {
    $cookieuser = $_COOKIE["user"];
    $user = Tclievelde::getData("SELECT * FROM wp_users WHERE md5(user_login)='$cookieuser'");
    $user = $user->fetch_assoc();
} else {
    header('location: /inloggen');
}

$reservations = Proa_Reservation::findBy(
    [
        'orderby' => 'date',
        'post_type' => 'reservation',
    ],
    $args['limit'] ?? null
);

$mijnreservering = null;

foreach ($reservations as $reservation) {
    foreach ($reservation->getRelatedPlayers() as $player) {
        if (is_array($player['reservation_participant'])) {
            if ($player['reservation_participant']['ID'] == $user['ID']) {
                $mijnreservering = $reservation;
            }
        }
    }
    foreach ($reservation->getAuthor() as $auth) {
        if ($auth == $user['ID']) {
            $mijnreservering = $reservation;
        }
    }
}

if (isset($_GET['delres'])) {
    $id = $_GET['delres'];
    Tclievelde::insertData("DELETE FROM reserveringen WHERE Id=".$id);
    header('location: reserveren');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $reserveringen = Proa_Reservation::findBy(
        [
            'post__in' => array($id),
            'post_type' => 'reservation',
        ],
        $args['limit'] ?? null
    );
    if ($reserveringen) {
        foreach ($reserveringen as $reservering) {
            $edit = true;
            $resid = $reservering->getID();
            $lidnummer = $reservering->getAuthor();
            $baan = $reservering->getCourt();
            $speler1 = $reservering->getRelatedPlayers()[0];
            $speler2 = $reservering->getRelatedPlayers()[1];
            $speler3 = $reservering->getRelatedPlayers()[2];
            $datum = $reservering->getTimeStart();
            $tijd = $reservering->getTimeEnd();
        }
    }
}

if (isset($_POST['opslaan'])) {
    $id = $_POST['id'];
    $medespeler1 = $_POST['speler2'] ?? 0;
    $medespeler2 = $_POST['speler3'] ?? 0;
    $medespeler3 = $_POST['speler4'] ?? 0;
    $medespeler1id = $_POST['speler2Id'] ?? 0;
    $medespeler2id = $_POST['speler3Id'] ?? 0;
    $medespeler3id = $_POST['speler4Id'] ?? 0;
    $baan = explode(' ', $_POST['baan']);
    $datum = date('d-m-Y', strtotime($_POST['datum']));
    $tijd = $_POST['tijd'];

    $tijdStart = $datum.' '.explode('-', $tijd)[0];
    $tijdEnd = $datum.' '.explode('-', $tijd)[1];
    foreach ($reservations as $reservation) {
        foreach ($reservation->getRelatedPlayers() as $player) {
            if (is_array($player['reservation_participant'])) {
                if ($player['reservation_participant']['user_firstname'].' '.$player['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$player['reservation_participant']['ID']) === $medespeler1
                    || $player['reservation_participant']['user_firstname'].' '.$player['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$player['reservation_participant']['ID']) === $medespeler2
                    || $player['reservation_participant']['user_firstname'].' '.$player['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$player['reservation_participant']['ID']) === $medespeler3
                ) {
                    if ($reservation->getID() !== $id) {
                        $errmsg = $player['reservation_participant']['user_firstname']." heeft al een reservering in het systeem staan.";
                    }
                }
            }
        }
        if ($reservation->getCourt() == $baan[1] && $reservation->getTimeStart() == $tijdStart && $reservation->getID() !== $id) {
            $errmsg = "Op dat moment wordt er al op de baan gespeeld";
        }
    }
    if (!$errmsg) {
        $myreservation = Proa_Reservation::findBy(
            [
                'orderby' => 'date',
                'post_type' => 'reservation',
                'post_id' => $id,
            ],
            $args['limit'] ?? null
        );
        $value = array(
            array(
                "reservation_participant" => $medespeler1id
            ),
            array(
                "reservation_participant" => $medespeler2id
            ),
            array(
                "reservation_participant" => $medespeler3id
            )
        );

        $id = intval($id);

        update_field('reservation_date_time_start', $tijdStart, $id);
        update_field('reservation_time_end', $tijdEnd, $id);
        update_field('reservation_court', $baan[1], $id);
        update_field('related_player', $value, $id);
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
                        <div id="lidnummer" class="c-match__single-player active-player no-deselect">
                            <p>
                                <?php echo $lidnummer['user_firstname'].' '.$lidnummer['user_lastname'].' - '.get_field('user_player_number', 'user_'.$lidnummer['ID']); ?>
                            </p>
                        </div>
                        <?php
                        $spelers = Tclievelde::getData("SELECT * FROM wp_users");
                        while ($lid = $spelers->fetch_assoc()) {
                            if ($lid['ID'] != $lidnummer['ID']) {
                                ?>
                                <div id="<?php echo $lid['ID']; ?>" class="c-match__single-player
                                <?php
                                if (is_array($speler1['reservation_participant'])) {
                                    if ($speler1['reservation_participant']['ID'] == $lid['ID']) {
                                        echo 'active-player';
                                    }
                                }
                                if (is_array($speler2['reservation_participant'])) {
                                    if ($speler2['reservation_participant']['ID'] == $lid['ID']) {
                                        echo 'active-player';
                                    }
                                }
                                if (is_array($speler3['reservation_participant'])) {
                                    if ($speler3['reservation_participant']['ID'] == $lid['ID']) {
                                        echo 'active-player';
                                    }
                                }
                                ?>">
                                    <p>
                                        <?php echo get_user_meta($lid['ID'])['first_name'][0].' '.get_user_meta($lid['ID'])['last_name'][0].' - '.get_field('user_player_number', 'user_'.$lid['ID']); ?>
                                    </p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="col-10">
                        <p>
                            Medespelers:
                        </p>
                        <div id="allspelers" class="d-flex flex-column c-match__allwij">
                            <?php
                            foreach ($mijnreservering->getRelatedPlayers() as $medespeler) {
                                if ($medespeler['reservation_participant']) {
                                    echo 'test';
                                    echo '<input class="active-players" value="'.$medespeler['reservation_participant']['user_firstname']." ".$medespeler['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$medespeler['reservation_participant']['ID']).'" readonly />';
                                }
                            } ?>
                        </div>
                    </div>
                    <p>
                        Baan:
                    </p>
                    <select name="baan">
                        <option <?php if ($mijnreservering->getCourt() == '1') {
                            echo 'selected';
                                } ?>>Baan 1</option>
                        <option <?php if ($mijnreservering->getCourt() == '2') {
                            echo 'selected';
                                } ?>>Baan 2</option>
                    </select>
                    <p>
                        Datum en tijd:
                    </p>
                    <div class="d-flex">
                        <?php $time = explode(' ', $mijnreservering->getTimeStart().' '.$mijnreservering->getTimeEnd());
                        ?>
                        <input type="date" name="datum" value="<?php echo $time[0]; ?>" />
                        <select class="ml-3" name="tijd">
                            <option <?php if ($time[1].'-'.$time[3] == '09:00-10:00') {
                                echo 'selected';
                                    } ?>>09:00-10:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '10:00-11:00') {
                                echo 'selected';
                                    } ?>>10:00-11:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '11:00-12:00') {
                                echo 'selected';
                                    } ?>>11:00-12:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '12:00-13:00') {
                                echo 'selected';
                                    } ?>>12:00-13:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '13:00-14:00') {
                                echo 'selected';
                                    } ?>>13:00-14:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '14:00-15:00') {
                                echo 'selected';
                                    } ?>>14:00-15:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '15:00-16:00') {
                                echo 'selected';
                                    } ?>>15:00-16:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '16:00-17:00') {
                                echo 'selected';
                                    } ?>>16:00-17:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '17:00-18:00') {
                                echo 'selected';
                                    } ?>>17:00-18:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '18:00-19:00') {
                                echo 'selected';
                                    } ?>>18:00-19:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '19:00-20:00') {
                                echo 'selected';
                                    } ?>>19:00-20:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '20:00-21:00') {
                                echo 'selected';
                                    } ?>>20:00-21:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '21:00-22:00') {
                                echo 'selected';
                                    } ?>>21:00-22:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '22:00-23:00') {
                                echo 'selected';
                                    } ?>>22:00-23:00</option>
                            <option <?php if ($time[1].'-'.$time[3] == '23:00-24:00') {
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
                if ($succes) {
                    echo $succes;
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
            <?php echo $mijnreservering->getTimeStart().' - '.$mijnreservering->getTimeEnd(); ?>
            </p>
            <p>
                <b>
                    Baan:
                </b>
            <?php echo $mijnreservering->getCourt(); ?>
            </p>
            <div class="d-flex justify-content-between">
                <p>
                    <?php
                    $author = $reservation->getAuthor();
                    echo $author['user_firstname'].' '.$author['user_lastname'].' - '.get_field('user_player_number', 'user_'.$author['ID']);
                    ?>
                </p>
                <p>
                <?php
                if (is_array($reservation->getRelatedPlayers()[0]['reservation_participant'])) {
                    echo $reservation->getRelatedPlayers()[0]['reservation_participant']['user_firstname'].' '.$reservation->getRelatedPlayers()[0]['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$reservation->getRelatedPlayers()[0]['reservation_participant']['ID']);
                }
                ?>
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <p>
                <?php
                if (is_array($reservation->getRelatedPlayers()[1]['reservation_participant'])) {
                    echo $reservation->getRelatedPlayers()[1]['reservation_participant']['user_firstname'].' '.$reservation->getRelatedPlayers()[1]['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$reservation->getRelatedPlayers()[1]['reservation_participant']['ID']);
                }
                ?>
                </p>
                <p>
                <?php
                if (is_array($reservation->getRelatedPlayers()[2]['reservation_participant'])) {
                    echo $reservation->getRelatedPlayers()[2]['reservation_participant']['user_firstname'].' '.$reservation->getRelatedPlayers()[2]['reservation_participant']['user_lastname'].' - '.get_field('user_player_number', 'user_'.$reservation->getRelatedPlayers()[2]['reservation_participant']['ID']);
                }
                ?>
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <a href="?edit=<?php echo $reservation->getID(); ?>">
                    Bewerken
                </a>
                <a href="?delres=<?php echo $reservation->getID(); ?>">
                    Verwijderen
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
get_footer();

