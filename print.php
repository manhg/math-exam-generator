<html>
<style>
p { font-size: 13pt; }
img { vertical-align: -15%; }
</style>
<table>
<?php
include 'config.php';	
require 'latex.php';

$p = isset($_GET['p']) ? $_GET['p'] : 0;
$n = isset($_GET['n']) ? $_GET['n'] : 10;
$p = $p*$n;
$r = mysql_query("SELECT * FROM question LIMIT $p, $n");
while ($row = mysql_fetch_object($r)) {	
	$content = latex($row->content);
	echo sprintf("<p>%s. %s</p>", $row->id, $content);
}
?>
</table>