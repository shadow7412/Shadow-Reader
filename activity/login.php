<?php
require "../include/db.php";
if(isset($_POST['login'])){
	$_SESSION['user'] = $_POST['login'];
}
?>