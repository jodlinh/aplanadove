<?php 
date_default_timezone_set("America/La_Paz");    

	$mysqli = new mysqli("localhost", "jhuerta", "dFt&523$$.123", "aplanado");
	if ($mysqli->connect_errno) {	die($mysqli->connect_error);  exit;}
	$mysqli->select_db("aplanado"); 
?>