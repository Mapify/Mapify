<?php
	$host="131.244.54.3";
	$port=3306;
	$socket="";
	$user="student";
	$password="student";
	$dbname="happinessIndex";
	$con = new mysqli($host, $user, $password, $dbname, $port, $socket) or die ('Could not connect to the database server' . mysqli_connect_error());
?>