<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'PHPMailer/PHPMailerAutoload.php';

class SendMail
{

    public $mail;

    public function __construct()
    {
		$this->mail = new PHPMailer; 
		$this->mail->isSMTP(); 
		//$this->mail->SMTPDebug = 2; 
		$this->mail->Debugoutput = 'html'; 
		$this->mail->Host = 'sg2plcpnl0221.prod.sin2.secureserver.net'; 
		$this->mail->Port = 465; 
		$this->mail->SMTPSecure = 'ssl'; 
		$this->mail->SMTPAuth = true; 
		$this->mail->Username = "chandra@dev.w3ondemand.com"; 
		$this->mail->Password = "Chandra@123";
		$this->mail->CharSet = 'UTF-8';
    }

    public function sendTo($toEmail, $recipientName, $subject, $msg)
    {
        $this->mail->setFrom('w3ondemand@gmail.com', 'w3ondemand');
        $this->mail->addAddress($toEmail, $recipientName);
        $this->mail->isHTML(true); 
        $this->mail->Subject = $subject;
        $this->mail->Body = $msg;
        if (!$this->mail->send()) {
			//pr($this->mail->ErrorInfo,1);
            log_message('error', 'Mailer Error: ' . $this->mail->ErrorInfo);
            return false;
        }
        return true;
    }

}
