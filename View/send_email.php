<?php
require 'C:/xampp/htdocs/vege/vege/phpmailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/vege/vege/phpmailer/src/Exception.php';
require 'C:/xampp/htdocs/vege/vege/phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Now you can proceed with sending the email using PHPMailer


$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Use SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set mail server
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'esratulip22email@gmail.com';                 // Your email address
    $mail->Password   = 'mamapapa22';                  // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
    $mail->Port       = 587;                                   // SMTP port

    // Recipients
    $mail->setFrom('esratulip22email@gmail.com', 'Admin');            // From address
    $mail->addAddress($userEmail, 'User');                      // To user email

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Response to Your Complaint';
    $mail->Body    = 'We have received your complaint and will respond soon. Thank you!';
    $mail->AltBody = 'We have received your complaint and will respond soon. Thank you!'; // Fallback plain text

    $mail->send();
    echo 'Email has been sent successfully.';
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
