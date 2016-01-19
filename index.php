<?php
include 'php/PHPMailerAutoload.php'; //import PHPMailer for SMTP
$status = false; //initialize status as false to send emails periodically
$GLOBALS['host'] = "your ip goes here"; //replace your host here eg. 192.168.x.x
$GLOBALS['ms'] = 0; //initialize time to zero
$GLOBALS['port'] = your port goes here; //replace with your port eg. 80,587,8080,etc
$GLOBALS['oldstatus']=getstatus(); //obtaining current status
sendmail(getstatus()); //send initial status
checkStatus(); //call function to check status
function checkStatus()
{
  $status=getstatus();
  if($GLOBALS['oldstatus']!=$status) //call send email function with status
  {
   sendmail($status);
   $GLOBALS['oldstatus']=$status;
 }
   checkStatus();//calling check status recursively
}
function getstatus() //function to check and return status 
{
      $host = $GLOBALS['host']; 
      $port = $GLOBALS['port'];
      $timeout = 10; //change timeout accordingly
      $tbegin = microtime(true);  
      $fp = fsockopen($host, $port, $errno, $errstr, $timeout);  
      $responding = 1;
      if (!$fp) { $responding = 0; }  
      $tend = microtime(true); 
      fclose($fp); 
      $mstime = ($tend - $tbegin) * 1000;
      $mstime = round($mstime, 2); 
      $GLOBALS['ms'] = $mstime;
      return $responding;
}
function sendmail($status) //send email using PHP Mailer
{
  if($status)
   {
    $hoststate =  $GLOBALS['host']." responded to requests on port ".$GLOBALS['port']." in ".$GLOBALS['ms']."\n milliseconds!<br><br>This is automated email,please don't reply to this.";
    $emailsubject = "Info:".$GLOBALS['host']." is back online!";
   }
   else
   {
    $hoststate =  $GLOBALS['host']." is not responding to requests on port ".$GLOBALS['port']."\n<br><br>This is automated email,please don't reply to this.";
    $emailsubject = "Attention Required:".$GLOBALS['host']." is down!";
   }
      $mail = new PHPMailer;
      $mail->isSMTP();
      $mail->Debugoutput = 'html';
      $mail->Host = "your SMTP Host goes here";
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->Username = "your username goes here";
      $mail->Password = "your password goes here";
      $mail->setFrom('your from address goes here', 'your from name goes here');
      $mail->addReplyTo('your reply to address goes here', 'your reply to name goes here');
      $mail->addAddress('your email address goes here', 'your name goes here');
      $mail->Subject = "$emailsubject";
      $mail->msgHTML("$hoststate");
      $mail->AltBody = 'Please enable HTML to view this email';
      $mail->send();
}
?>
