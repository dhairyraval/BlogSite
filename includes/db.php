<!-- -- contributed by:
	-- Name: Ishan Bhatia
	-- Banner Number: B00835259
	-- Implemented the functionality to establish a connection to the database -->
	
<?php

	$hostservername = "localhost"; 
	$username = "root";
	$password = "root";
	$dbname = "2170db";

	$dbconnection = new mysqli($hostservername, $username, $password, $dbname);

	if ($dbconnection->connect_error) {
		die("No connection<br>" . $dbconnection->connect_error);
	}

?>
