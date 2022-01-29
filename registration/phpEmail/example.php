<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <?php
            include("phpEmail/vendor/autoload.php");
            use PHPMailer\PHPMailer\PHPMailer;

            $mail = new PHPMailer(true); // Instantiation and passing `true` enables exceptions

            // SERVER SETTINGS
            $mail->SMTPDebug = 2;                     // Enable verbose debug output
            $mail->isSMTP();                          // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';     // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                 // Enable SMTP authentication
            $mail->Username   = '';
            $mail->Password   = '';
            $mail->SMTPSecure = 'ssl';                // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 465;                  // TCP port to connect to
            $mail->smtpConnect(
                array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                )
            );
        
            // RECIPIENTS (name is optional)
            $mail->setFrom('np007MLF@gmail.com', 'name');                // from
            $mail->addAddress('nishanpaul12011996se@gmail.com', 'name'); // to
            // $mail->addAddress('ellen@example.com', 'name');           // multiple to
            // $mail->addReplyTo('info@example.com', 'name');            // reply
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            // CONTENT
            $mail->isHTML(true); // set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'CUET <b> CSE 16 </b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            // ATTACHMENTS (name is optional)
            // $mail->addAttachment('/var/tmp/file.tar.gz');
            // $mail->addAttachment('EXPRESSO\images\img_1.jpg', 'name.jpg');
        
            $mail->send();
        ?>
    </body>
</html>