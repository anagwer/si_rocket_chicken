<?php
	$conn = new mysqli('localhost', 'root', '', 'db_rocket');
	
	if(!$conn){
		die("Error: Failed to connect to database");
	}
?>	