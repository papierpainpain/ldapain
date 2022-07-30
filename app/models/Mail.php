<?php

namespace App\Models;

use App\Models\Errors\MyException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/**
 * Classe pour l'envoie de mail.
 *
 * @package Models
 */
class Mail
{

    /**
     * Envoie du mail.
     *
     * @return void
     */
    public static function send($subject, $email, $message)
    {
        // *** TREATMENTS *** //
        $email = filter_var(
            trim($email),
            FILTER_SANITIZE_EMAIL
        );
        $subject = trim($subject);
        $message = htmlspecialchars(trim($message));
        $message = wordwrap($message, 70, "\r\n");


        // *** CHECK FIELDS *** //
        if (empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new MyException('Champs incorrects ou non définis (subject='.$subject.'; message='.$message.')', 412);
        }

        // *** SEND *** //
        Mail::mailerSend($subject, $email, $message);
    }

    protected static function mailerSend($subject, $email, $message)
    {
        $mail = new PHPMailer(true);
        // $mail = new PHPMailer();

        // try {
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = false;
        $mail->isSMTP();
        $mail->Host = ENV['smtp']['host'];
        $mail->SMTPAuth = true;
        $mail->Username = ENV['smtp']['user'];
        $mail->Password = ENV['smtp']['pwd'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = ENV['smtp']['port'];

        //Recipients
        $mail->setFrom(ENV['site']['mail'], ENV['site']['name']);
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = ENV['site']['name'] . ' : ' . $subject;
        $mail->Body    = Mail::message($subject, $email, $message);
        $mail->AltBody = $message;

        $mail->send();
    }

    /**
     * Mise en forme du message en html.
     *
     * @param string $message
     *
     * @return false|string html
     */
    protected static function message($subject, $email, $message)
    {
        $date = date('d.m.Y');

        $content = file_get_contents(File::views('mails/mail.html'));

        $content = str_replace('%subject%', $subject, $content);
        $content = str_replace('%date%', $date, $content);
        $content = str_replace('%email%', $email, $content);
        $content = str_replace('%message%', $message, $content);

        return $content;
    }
}
