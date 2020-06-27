<?php
require_once('inc/class/db.php');
require_once('inc/class/sitemap.php');


echo sm::linkMB('//\\(//yuyutyu)<>?/');


$string = 'April 15, 2003=';
$pattern = '/(\w+) (\d+), (\d+)/i';
$replacement = '${1} 5 , $3';
//echo preg_replace($pattern, $replacement, $string);

