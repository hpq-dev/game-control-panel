<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Suspend</title>

<style type="text/css">
	* {
		background: #902A2A;
	}
	center {
		font-size: 50px;
		margin-top: 280px;
		color: #DADADA;
	}
	img {
		margin-top: 30px;
	}
</style>

</head>
<body>
<center>
	<?php
	echo'
	You are suspended by admin <b>'.$suspend->Admin.'</b>.<br>
	Reason: <b>'.$suspend->Reason.'</b><br>
	Expires: <b>'.$suspend->Date.'</b><br>
	<img src="https://c.tenor.com/nXwgSsfo2bYAAAAM/suspended-kid-crying.gif">';
	?>
</center>
</body>
</html>