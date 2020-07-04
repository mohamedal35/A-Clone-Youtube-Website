<?php 
class sendActiveCode {
    public function send($firstName, $lastName, $activationCode, $email, $username) {
        // Send Mail To Verify
        $urlVerification                    = "http://localhost/youtube/verifyEmail.php";
        $mailMsgBody                        = "<p>Hello " . $firstName . " " . $lastName . "</p>
                                            <p>Thanks For Your Registration </p>
                                            <p>Please Open This Link To verify Your Account : </p>
                                            <p>" . $urlVerification . "?code=" . $activationCode . "</p>";

        // Mail Class
        $mail = new PHPMailer\PHPMailer\PHPMailer();
                //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.sendgrid.net';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username = "apikey";
        //Password to use for SMTP authentication
        $mail->Password = "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";
        //Set who the message is to be sent from
        $mail->setFrom('mmaa13825@gmail.com', 'VideoTube');
        //Set who the message is to be sent to
        $mail->addAddress($email, $username);
        //Set the subject line
        $mail->Subject = 'VideoTube - Verification Msg';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->IsHTML(true);
        //Replace the plain text body with one created manually
        $mail->Body     = $mailMsgBody;
        //send the message, check for errors
        if (!$mail->send()) {
        } else {   
        }
            
    }
}

?>