<?php
require 'latex.php';
$text = $_REQUEST['text'];
echo latex($text);