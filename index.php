
<?php 
$i=-1;
foreach (glob("security/*.php") as $filename) {
	if(++$i==0) continue;
	include $filename;
}
?>