<?php
//fetches the next x feeds, returns them in JSON format
require "../include/db.php";
function get($a, $b=""){
	if(isset($_GET[$a])){
		return $_GET[$a];
	} else return $b;
}
$json = array();
$res = $db->query("SELECT * FROM `fetchview` ".(get("folder",0)==0?"":" WHERE `feed`=".get("folder",0))." ORDER BY date DESC LIMIT ".get("start",0).",".get("length",100));

//requires:
//id of Item
//Feed Name
//Date of Item

//Subject of Item
//Content of Item
//Link of Item

//is read/starred/shared

/*
SELECT `rssitems`.`id`,`link`,`title`,`subject`,`rssitems`.`date`,`content`,`shared`,`starred`,`read`
FROM rssitems
LEFT JOIN `useritems`
ON `rssitems`.id=`useritems`.iditem
*/

//WHERE `iduser`=$_user

while($row = $res->fetch_assoc()){
	$json[] = $row;
}
echo json_encode($json);
?>
