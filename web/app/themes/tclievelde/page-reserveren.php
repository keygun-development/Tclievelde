<?php

use Tclievelde\Tclievelde;
use functions\customposts\Proa_Reservation;

$reservations = Proa_Reservation::findBy(
    [
        'orderby' => 'date',
        'post_type' => 'reservation',
    ],
    $args['limit'] ?? null
);

$newreservation = false;
$errmsg = '';
$availability = '';
$succes = '';

if (isset($_COOKIE['user'])) {
    $cookieuser = $_COOKIE["user"];
    $user = Tclievelde::getData("SELECT * FROM wp_users WHERE md5(user_login)='$cookieuser'");
    $user = $user->fetch_assoc();
} else {
    header('location: /inloggen');
}

if (isset($_GET['newreservation'])) {
    $participantReservation = false;

    foreach ($reservations as $reservation) {
        foreach ($reservation->getAuthor() as $auth) {
            if ($auth == $user['ID']) {
                $participantReservation = true;
            }
        }
    }

    foreach ($reservations as $reservation) {
        foreach ($reservation->getRelatedPlayers() as $participant) {
            if (is_array($participant['reservation_participant'])) {
                if ($participant['reservation_participant']['ID'] == $user['ID']) {
                    $participantReservation = true;
                }
            }
        }
    }

    foreach ($reservations as $reservation) {
        foreach ($reservation->getRelatedPlayers() as $participant) {
            if (is_array($participant['reservation_participant'])) {
                if ($participant['reservation_participant']['ID'] == $user['ID']) {
                    $participantReservation = true;
                }
            }
        }
    }

    if ($participantReservation) {
        $errmsg = 'U mag maar 1 keer reserveren.';
    } else {
        $newreservation = true;
    }
}

if (isset($_POST['aanmaken'])) {
    $baan = $_POST['baan'];
    $datum = date('d-m-Y', strtotime($_POST['date']));
    $tijd = $_POST['time'];
    $lidnummer = $user['ID'];
    $medespeler1 = $_POST['speler1Id'] ?? 0;
    $medespeler2 = $_POST['speler2Id'] ?? 0;
    $medespeler3 = $_POST['speler3Id'] ?? 0;
    $medespeler1noId = $_POST['speler1'] ?? '';
    $medespeler2noId = $_POST['speler2'] ?? '';
    $medespeler3noId = $_POST['speler3'] ?? '';
    $medespeler1Reservation = false;
    $medespeler2Reservation = false;
    $medespeler3Reservation = false;
    $tijd = explode('-', $tijd);

    if ($medespeler1 === 0) {
        $errmsg = 'Kies minimaal 1 medespeler.';
    }

    if ($datum < date('d-m-Y')) {
        $errmsg = 'U kunt niet in het verleden reserveren.';
    }

    if ($datum == date('d-m-Y') && $tijd[0] <= date('H:i')) {
        $errmsg = 'U kunt niet in het verleden reserveren.';
    }

    if ($datum.' '.$tijd[0] <= date('d-m-Y H:i')) {
        $errmsg = 'U kunt niet in het verleden reserveren.';
    }

    //Check where author
    if ($medespeler1 !== 0) {
        foreach ($reservations as $reservation) {
            foreach ($reservation->getAuthor() as $auth) {
                if ($auth == $medespeler1) {
                    $medespeler1Reservation = true;
                }
            }
        }
    }

    if ($medespeler2 !== 0) {
        foreach ($reservations as $reservation) {
            foreach ($reservation->getAuthor() as $auth) {
                if ($auth == $medespeler2) {
                    $medespeler2Reservation = true;
                }
            }
        }
    }

    if ($medespeler3 !== 0) {
        foreach ($reservations as $reservation) {
            foreach ($reservation->getAuthor() as $auth) {
                if ($auth == $medespeler3) {
                    $medespeler3Reservation = true;
                }
            }
        }
    }

    if ($medespeler1Reservation) {
        $errmsg = $medespeler1noId.' heeft al een reservering in het systeem staan.';
    }

    if ($medespeler2Reservation) {
        $errmsg = $medespeler2noId . ' heeft al een reservering in het systeem staan.';
    }
    if ($medespeler3Reservation) {
        $errmsg = $medespeler3noId . ' heeft al een reservering in het systeem staan.';
    }

    //Check where participant
    foreach ($reservations as $reservation) {
        foreach ($reservation->getRelatedPlayers() as $participant) {
            if (is_array($participant['reservation_participant'])) {
                if ($participant['reservation_participant']['ID'] == $medespeler1) {
                    $errmsg = $medespeler1noId . ' heeft al een reservering in het systeem staan.';
                } else if ($participant['reservation_participant']['ID'] == $medespeler2) {
                    $errmsg = $medespeler2noId . ' heeft al een reservering in het systeem staan.';
                } else if ($participant['reservation_participant']['ID'] == $medespeler3) {
                    $errmsg = $medespeler3noId . ' heeft al een reservering in het systeem staan.';
                }
            }
        }
    }

    //Check court date and time
    foreach ($reservations as $reservation) {
        if ($reservation->getTimeStart().' '.$reservation->getTimeEnd() == $datum.' '.$tijd[0].' '.$datum.' '.$tijd[1]) {
            if ('Baan '.$reservation->getCourt() == $baan) {
                $errmsg = 'Op dit moment is deze baan al in gebruik. Kies een ander tijdstip of een andere baan.';
            }
        }
    }

    //Check shielding
    foreach ($reservations as $reservation) {
        if ($datum.' '.$tijd[0] >= $reservation->getTimeStart() && $datum.' '.$tijd[0] <= $reservation->getTimeEnd()) {
            if ('Baan '.$reservation->getCourt() == $baan) {
                $errmsg = 'De baan is op dit moment afgeschermd van '.$reservation->getTimeStart().' tot '.$reservation->getTimeEnd().' kies een andere baan of een ander tijdstip.';
            }
        }
    }

    if ($errmsg == '') {
        $my_post = array(
            'post_title'    => 'Reservering '.$user['display_name'].' - '.get_field('user_player_number', 'user_'.$user['ID']),
            'post_type'     => 'reservation',
            'post_status'   => 'publish',
            'post_author'   => 1
        );

        $post_id = wp_insert_post($my_post);

        $baan = explode(' ', $baan);

        $value = array(
                array(
                    "reservation_participant" => $medespeler1
                ),
            array(
                "reservation_participant" => $medespeler2
            ),
            array(
                "reservation_participant" => $medespeler3
            )
        );

        update_field('reservation_author', $lidnummer, $post_id);
        update_field('reservation_date_time_start', $datum.' '.$tijd[0], $post_id);
        update_field('reservation_time_end', $datum.' '.$tijd[1], $post_id);
        update_field('reservation_court', $baan[1], $post_id);
        update_field('field_61c18b86ee6fd', $value, $post_id);
        $succes = 'Uw reservering is succesvol aangemaakt.';
    }
}

get_header();
require 'page.php';
?>
<div class="bg-blue">
    <div class="container section">
    <?php
    $user_meta = get_userdata($user['ID']);
    if (in_array('administrator', $user_meta->roles)) {
        ?>
        <h2>
            Admin controls
        </h2>
        <div class="d-flex">
            <a href="/wp/wp-admin" class="c-button__primary">
                Adminpaneel
            </a>
            <a href="/wp/wp-admin/post-new.php?post_type=reservation" target="_blank" class="c-button__primary ml-4">
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
                            U bent:
                        </p>
                        <input name="lidnummer" value="<?php echo $user['display_name'].' - '.get_field('user_player_number', 'user_'.$user['ID']); ?>" readonly />
                        <p>
                            Zoek naar spelers:
                        </p>
                        <input type="text" id="searchbar" />
                        <div class="c-match__player-selector mt-3">
                            <?php
                            $spelers = Tclievelde::getData("SELECT * FROM wp_users");
                            while ($lid = $spelers->fetch_assoc()) {
                                if ($lid['ID'] !== $user['ID']) {
                                    ?>
                                    <div id="<?php echo $lid['ID']; ?>" class="c-match__single-player">
                                        <p>
                                            <?php echo get_user_meta($lid['ID'])['first_name'][0].' '.get_user_meta($lid['ID'])['last_name'][0].' - '.get_field('user_player_number', 'user_'.$lid['ID']); ?>
                                        </p>
                                    </div>
                                    <?php
                                }
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
                                    Geselecteerde medespelers:
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
                    if (!$reservations) {
                        echo 'Geen reserveringen gevonden';
                    }
                    foreach ($reservations as $reservation) {
                        ?>
                        <div class="c-match__single">
                            <p>
                                <b>Datum en tijd:</b><br><?php echo $reservation->getTimeStart().' - '.$reservation->getTimeEnd(); ?>
                            </p>
                            <p>
                                <b>Baan:</b> <?php echo $reservation->getCourt(); ?>
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
                                    if (count($reservation->getRelatedPlayers()) > 1) {
                                        if (is_array($reservation->getRelatedPlayers()[1]['reservation_participant'])) {
                                            echo $reservation->getRelatedPlayers()[1]['reservation_participant']['user_firstname'] . ' ' . $reservation->getRelatedPlayers()[1]['reservation_participant']['user_lastname'] . ' - ' . get_field('user_player_number', 'user_' . $reservation->getRelatedPlayers()[1]['reservation_participant']['ID']);
                                        }
                                    }
                                    ?>
                                </p>
                                <p>
                                    <?php
                                    if (count($reservation->getRelatedPlayers()) > 1) {
                                        if (is_array($reservation->getRelatedPlayers()[2]['reservation_participant'])) {
                                            echo $reservation->getRelatedPlayers()[2]['reservation_participant']['user_firstname'] . ' ' . $reservation->getRelatedPlayers()[2]['reservation_participant']['user_lastname'] . ' - ' . get_field('user_player_number', 'user_' . $reservation->getRelatedPlayers()[2]['reservation_participant']['ID']);
                                        }
                                    }
                                    ?>
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
            } if ($succes) {
                echo '<p class="c-succes__msg">'.$succes.'</p>';
            }
            ?>
        </div>
    </div>
</div>
<?php
get_footer();

