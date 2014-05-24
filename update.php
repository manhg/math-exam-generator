<?php 
include "config.php";

$sql = sprintf("UPDATE question SET type = %d, grade = %d, estimate = %d, difficulty = %d, content = '%s', answer = '%s', category = '%s' WHERE id = %d",
 $_REQUEST['type'], $_REQUEST['grade'], $_REQUEST['estimate'], $_REQUEST['difficulty'], mysql_real_escape_string($_REQUEST['content']), mysql_real_escape_string($_REQUEST['answer']), $_REQUEST['category'], $_REQUEST['id']);
mysql_query($sql);
echo mysql_error();