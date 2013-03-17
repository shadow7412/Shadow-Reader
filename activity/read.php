<?php
require "../include/db.php";
$item = intval($_POST['item']);
if($item==0) die("Request error.");
$db->query("INSERT INTO `useritems` (`iduser`,`iditem`,`read`) VALUES ('$_user',$item,1) ON DUPLICATE KEY UPDATE `read`=1");
echo $db->error;
?>