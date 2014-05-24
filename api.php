<?php
include "config.php";

mysql_query("SET NAMES 'UTF8'");
header("Content-type: text/plain; charset=utf-8");
if (isset($_REQUEST['action'])) {
	$func = $_REQUEST['action'];
	switch ($func) {
		case 'topic':
			$result = mysql_query("SELECT DISTINCT category FROM question ORDER BY category ASC");
			$output = array();
			while($category = mysql_fetch_assoc($result)) {
				$output[] = $category['category'];
			}
			echo sprintf("<option>%s</option>", implode("</option>\n<option>", $output));
			break;
		case 'question':
			include 'latex.php';
			$topic = $_REQUEST['topic'];
			$type = $_REQUEST['type'];
			$grade = $_REQUEST['grade'];
			$sql = "SELECT id, content FROM question WHERE type = $type " . 
				($topic == '_' ? "" : " AND category = '$topic' ") . 
				($grade == '_' ? "" : " AND grade = $grade");
			$result = mysql_query($sql);
			$output = array();
			while($row = mysql_fetch_object($result)) {
				$output[] = $row->content;
				// echo "<div>{$row->content}</div>";
				echo "<div class='question' ref='{$row->id}' id='q{$row->id}'>". latex($row->content). "</div>";
			}
			break;
		case 'random':
			
		default:
			break;
	}
}