<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once ("controllers/DBController.php");
require_once ("./../PHPMailer/src/Exception.php");
require_once ("./../PHPMailer/src/PHPMailer.php");
require_once ("./../PHPMailer/src/SMTP.php");

class mailController
{

    const FROM = 'tours@realrussia.co.uk';

    private $db;
     
    function __construct() {
        $this->db = new DBController();
    }

    function sendEmail($to, $subject, $message) {
        $mail = new PHPMailer(true);


        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'realrussia.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'emailScript';
            $mail->Password   = 'Kyx6EgWz5LWFW00gHhfg13eOKA6l2a2BdQY3dH1TzxbRcy7VKWtkXu3KfnOkfms';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 25;

            //Recipients
            $mail->setFrom(self::FROM);
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function callMeBackForm(){

        $name = !empty($_POST['name'])  ? $_POST['name'] : null;
        $email    = !empty($_POST['email'])     ? $_POST['email'] : null;
        $phone = !empty($_POST['phone'])  ? $_POST['phone'] : null;
        $msg   = !empty($_POST['msg'])    ? $_POST['msg'] : null;
        $to  = !empty($_POST['to'])   ? $_POST['to'] : [];

        $subject = "Call Me Back ".$name;

        $message = "
        <html>
        <head>
        <title>Contact Email</title>
        </head>
        <body>
        <table>
        <tr>
        <th>Name - ".$name." </th>
        </tr>
        <tr>
        <th>Email - ".$email."</th>
        </tr>
        <tr>
        <th>Phone - ".$phone." </th>
        </tr>
        <tr>
        <th>Message - ".$msg."</th>
        </tr>
        </table>
        </body>
        </html>
        ";

        $result = $this->sendEmail($to, $subject, $message) && $this->sendEmail(self::FROM, $subject, $message);

        if($result) {
            $contactMsg = "Message sent successfully...";
            $status     = 1;
        }else {
            $contactMsg = "Message could not be sent...";
            $status     = 0;  
        }

        $sql = "INSERT INTO tblemaillog (formtype, name, email, phonenumber, message, status, createddate)
            VALUES ('callMeBack', '".addslashes($name)."', '".$email."', '".$phone."', '".addslashes($msg)."', ".$status.", '".date('Y/m/d H:i:s')."')";  
  
        $this->db->query($sql);

        return array('status'=>$status,'msg'=>$contactMsg);
    }

    function tourEnquiry(){

        $name = !empty($_POST['name'])  ? $_POST['name'] : null;
        $email    = !empty($_POST['email'])     ? $_POST['email'] : null;
        $phone = !empty($_POST['phone'])  ? $_POST['phone'] : null;
        $msg   = !empty($_POST['msg'])    ? $_POST['msg'] : null;
        $to  = !empty($_POST['to'])   ? $_POST['to'] : [];
        $tourName = !empty($_POST['tourName'])  ? $_POST['tourName'] : null;

        $subject = "Tour Enquiry ".$tourName;

        $message = "
        <html>
        <head>
        <title>Tour Enquiry Email</title>
        </head>
        <body>
        <table>
        <tr>
        <th>Name - ".$name." </th>
        </tr>
        <tr>
        <th>Email - ".$email."</th>
        </tr>
        <tr>
        <th>Phone - ".$phone." </th>
        </tr>
        <tr>
        <th>Tour Name - ".$tourName." </th>
        </tr>
        <tr>
        <th>Message - ".$msg."</th>
        </tr>
        </table>
        </body>
        </html>
        ";

        $result = $this->sendEmail($to, $subject, $message) && $this->sendEmail(self::FROM, $subject, $message);

        if($result) {
            $contactMsg = "Message sent successfully...";
            $status     = 1;
        }else {
            $contactMsg = "Message could not be sent...";
            $status     = 0;  
        }

        $sql = "INSERT INTO tblemaillog (formtype, name, email, phonenumber, message, tourname, status, createddate)
            VALUES ('tourEnquiry', '".addslashes($name)."', '".$email."', '".$phone."', '".addslashes($msg)."', '".addslashes($tourName)."', ".$status.", '".date('Y/m/d H:i:s')."')";  
  
        $this->db->query($sql);

        return array('status'=>$status,'msg'=>$contactMsg);
        
    }
    
}
?>