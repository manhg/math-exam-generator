<?php
include "config.php";

$sql = sprintf("INSERT question (type, grade, estimate, difficulty, content, answer, category) VALUES (%d, %d, %d, %d, '%s', '%s', '%s')",
 $_REQUEST['type'], $_REQUEST['grade'], $_REQUEST['estimate'], $_REQUEST['difficulty'], mysql_real_escape_string($_REQUEST['content']), mysql_real_escape_string($_REQUEST['answer']), $_REQUEST['category']);
mysql_query($sql);
echo mysql_error();
