# systemstatus
system status is the simple application which help us to moniter the systems status and send a email alert if something unexpected happens or system recovers from a down time. It purely runs on PHP and it uses PHPMailer to delever email to your inbox.


#using systemstatus
You can easily use this application by modifying some variables in the code.
<pre>
$GLOBALS['host'] = "your ip goes here";
</pre>
<pre>
$GLOBALS['port'] = your port goes here;
</pre>
<pre>
$mail->Host = "your SMTP Host goes here";
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = "your username goes here";
$mail->Password = "your password goes here";
$mail->setFrom('your from address goes here', 'your from name goes here');
$mail->addReplyTo('your reply to address goes here', 'your reply to name goes here');
$mail->addAddress('your email address goes here', 'your name goes here');
</pre>


#contribute
Contributions to systemstatus are welcome. Here is how you can contribute to systemstatus:

<a href='https://github.com/arunkumarpalaniappan/systemstatus/issues'> Submit bugs</a> and verify issues.

<a href='https://github.com/arunkumarpalaniappan/systemstatus/pulls'> Submit pull requests</a>  for bug fixes and features and discuss existing proposals.
