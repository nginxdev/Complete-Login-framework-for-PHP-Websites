<?php
include('phpmailer.php');
class Mail extends PhpMailer
{
    // Set default variables for all new objects
    public $From     = 'admin@zingerpie.com';
    public $FromName = 'ZingerPie Admin';
    public $Host     = 'mail.zingerpie.com';
    public $Mailer   = 'smtp';
    public $SMTPAuth = true;
    public $Username = 'admin@zingerpie.com';
    public $Password = 'Dael_q433';
    public $SMTPSecure = 'tls';
    public $WordWrap = 75;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }
}
