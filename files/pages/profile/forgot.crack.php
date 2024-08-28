<?php 

Server::Valid(2);

if(Config::$_url[2] != 'pin') {
	Config::redirect('user/pin');
	exit;
}

$to = $player_data->Email;
$from = "no-reply@dark-play.ro";
$subject = "".Config::$Name." - Recovery your PIN";
$message = "
<html>
<head>
You have received this email because a pin recovery<br>
was instigated by you on ".Config::$Name." - Panel.<br><hr>
Your Pin is: ".$player_data->Pin."
</body>
</html>
";
$headers = "From: $from"; 
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$ok = mail($to, $subject, $message, $headers, "-f " . $from);

$_SESSION['P_INFO'] = 'Un email a fost trimis, verifica indbox-ul si spam-ul!';
$_SESSION['P_COLOR'] = 'success';

Config::redirect('user/pin');

?>