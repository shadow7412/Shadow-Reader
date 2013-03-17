<?php
$db = new mysqli("127.0.0.1","steven","","lanpanel_shadowreader");
session_name("rdr");
session_start();
$_user = $db->real_escape_string($_SESSION['user']);
?>
