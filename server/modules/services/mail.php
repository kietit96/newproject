<?php
require_once 'phpmailer/class.phpmailer.php';
require_once 'phpmailer/PHPMailerAutoload.php';

/**
*  Send Maill Class
*/
class Mail
{
    /**
     * Mail instance
     * @var class instance
     */
    private $mail;

    /**
     * Instance
     */
    function __construct()
    {
        $this->mail = new PHPMailer;
        $this->mail->CharSet   = 'UTF-8';
        $this->mail->SMTPDebug = false; // Enable verbose debug output
        $this->mail->isSMTP(); // Set mailer to use SMTP
        $this->mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $this->mail->SMTPAuth   = true; // Enable SMTP authentication
        $this->mail->Username   = 'lienhe.viettech@gmail.com'; // SMTP username
        $this->mail->Password   = 'ahrnennbpohnjyhy'; // SMTP password
        $this->mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port       = 587;
        $this->mail->From       = ' lienhe.viettech@gmail.com';
        $this->mail->FromName   = 'Hệ thống liên hệ'; //Title
        $this->mail->isHTML(true);
    }

    /**
     * Send mail to receivers
     * @param string $mailTitle Subject of Mail
     * @param string/html $mailBody  Content of mail
     * @param array  $sendTo    receivers mail
     */
    public function SendMail($mailTitle, $mailBody, $sendTo = [])
    {
        $this->mail->Subject    = $mailTitle;
        $this->mail->Body       = $mailBody;

        foreach ($sendTo as $key => $receiver) {
            $this->mail->addAddress($receiver, $receiver);
        }

        if (! $this->mail->send())
            throw new Exception("Có lỗi khi gửi Mail");

        return true;
    }

}