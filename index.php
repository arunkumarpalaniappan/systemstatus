<?php
include 'php/PHPMailerAutoload.php';
$status = false;
$GLOBALS['host'] = "54.169.248.213";
$GLOBALS['ms'] = 0;
$GLOBALS['port'] = 3389;
$GLOBALS['oldstatus']=getstatus();
sendmail(getstatus());
checkStatus();
function checkStatus()
{
  $status=getstatus();
  if($GLOBALS['oldstatus']!=$status)
  {
   sendmail($status);
   $GLOBALS['oldstatus']=$status;
 }
   checkStatus();
}
function getstatus()
{
      $host = $GLOBALS['host']; 
      $port = $GLOBALS['port'];
      $timeout = 10; 
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
function sendmail($status)
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
