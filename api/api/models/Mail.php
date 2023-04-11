<?php

namespace Api\Models;

use \PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Class Mail
 * 
 * @package Api\Models
 */
class Mail
{
    public static function sendPasswordReset(string $email, string $uid, string $password): void
    {
        $uid = htmlspecialchars(trim($uid));
        $password = htmlspecialchars(trim($password));

        $message = 'Mot de passe réinitialisé, voici ton mot de passe : ' . $password . ' (uid : ' . $uid . '). ';
        $message .= 'Il doit être modifié après connexion ! 💂 Ici : https://ldapain.papierpain.fr/login';

        $template = file_get_contents('api/views/emails/reset-password.html');
        $template = str_replace('{{uid}}', $uid, $template);
        $template = str_replace('{{password}}', $password, $template);

        self::sendMail(
            $email,
            'Réinitialisation du mot de passe',
            $message,
            $template
        );
    }

    public static function sendNewAccount(string $email, string $uid, string $password): void
    {
        $uid = htmlspecialchars(trim($uid));
        $password = htmlspecialchars(trim($password));

        $message = 'Bienvenue ' . $uid . ', voici ton mot de passe : ' . $password . '.';
        $message .= 'Il doit être modifié après connexion ! 💂 Ici : https://ldapain.papierpain.fr/login';

        $template = file_get_contents('api/views/emails/new-account.html');
        $template = str_replace('{{uid}}', $uid, $template);
        $template = str_replace('{{password}}', $password, $template);

        self::sendMail(
            $email,
            'Nouveau compte LDAPain',
            $message,
            $template
        );
    }

    private static function sendMail(string $email, string $subject, string $message, string $template): void
    {
        $email = filter_var(
            trim($email),
            FILTER_VALIDATE_EMAIL
        );

        $mail = new PHPMailer(true);

        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        //Server settings
        $mail->SMTPDebug = false;
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        //Recipients
        $mail->setFrom($_ENV['SMTP_USER'], $_ENV['APP_NAME']);
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $_ENV['APP_NAME'] . ' - ' . $subject;
        $mail->Body = $template;
        $mail->AltBody = $message;

        $mail->send();
    }
}
