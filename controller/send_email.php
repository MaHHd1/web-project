<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php'; // Adjust path if necessary


function sendNotificationEmail($recipientEmail, $subject, $messageBody) {
    $mail = new PHPMailer(true);  // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->isSMTP();                                             // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                               // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                       // Enable SMTP authentication
        $mail->Username = 'msadeklahyouguitar@gmail.com';                     // SMTP username (your email)
        $mail->Password = 'aplp yvww knyz cdvi';                      // SMTP password (your email password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
        $mail->Port = 587;                                            // TCP port to connect to

        //Recipients
        $mail->setFrom('msadeklahyouguitar@gmail.com', 'VEGE');          // Sender's email
        $mail->addAddress($recipientEmail);                            // Add recipient's email
        $mail->addReplyTo('msadeklahyouguitar@gmail.com', 'VEGE');       // Add a reply-to email (optional)

        // Content
        $mail->isHTML(true);                                          // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $messageBody;                                // Set the body content
        $mail->AltBody = strip_tags($messageBody);                    // Optional: Plain-text alternative

        $mail->send();  // Send the email
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
