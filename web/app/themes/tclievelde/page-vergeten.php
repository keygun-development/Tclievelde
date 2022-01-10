<?php

    use Tclievelde\Tclievelde;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
    $mailback = new PHPMailer(true);

    $getuser = null;

if (isset($_POST['submit'])) {
    $sender = $_POST['email'];
    $getuser = Tclievelde::getUserFromEmail($sender);
    $loader = true;
    if ($getuser !== 'Er bestaat geen gebruiker met dit emailadres') {
        $email = md5($getuser['email']);
        $pass = md5($getuser['wachtwoord']);
        $site = $_ENV['GMAIL_SITE'];
        try {
            //Server settings
            $mailback->isSMTP();
            $mailback->Host       = 'smtp.gmail.com';
            $mailback->SMTPAuth   = true;
            $mailback->Username   = $_ENV['GMAIL_USER'];
            $mailback->Password   = $_ENV['GMAIL_PASS'];
            $mailback->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mailback->Port       = 465;

            //Recipients
            $mailback->setFrom('keygun2001@gmail.com');
            $mailback->addAddress($sender);
            $mailback->addReplyTo('keygun2001@gmail.com');

            //Content
            $mailback->isHTML(true);
            $mailback->Subject = 'Wachtwoord resetten voor Tclievelde';
            $mailback->Body    = '
                <p>Geachte heer/vrouw,</p>
                <p>Volgens ons systeem probeert u uw wachtwoord te resetten. Als dat niet zo is dan probeert iemand in uw account te komen. Neem dan contact met ons op.</p>
                <p>Via onderstaande link kunt u uw wachtwoord resetten:</p>
                <a href="https://'.$site.'/reset?key='.$email.'&reset='.$pass.'" style="text-decoration: none; padding: 10px 25px; background-color: #46c5f1; border-radius: 4%; color: #fff; font-weight: 700; border: none;">Resetten</a>
                <p>Met vriendelijke groet,</p>
                <p>Tclievelde</p>
                ';

            $mailback->send();
        } catch (Exception $e) {
            dd($e);
            echo "Message kon niet worden verzonden. Error: {$mail->ErrorInfo}. Probeer het opnieuw of vraag de beheerder om hulp keaganmulder1@gmail.com";
        }
    }
}
get_header();
require 'page.php';
?>
<div class="bg-blue">
    <div class="container section">
        <form method="post">
            <p>
                Email:
            </p>
            <input class="col-6" type="email" name="email" />
            <input type="submit" class="c-button__primary mt-4" name="submit">
        </form>
        <?php
        if ($getuser == 'Er bestaat geen gebruiker met dit emailadres') {
            echo '<p class="c-error__msg">'.$getuser.'</p>';
        }
        ?>
    </div>
</div>
<?php
    get_footer();
?>
