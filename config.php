<?php
#config file for accessing the database

#base variables to use for connection. Authentication isn't required so credentials are just put here
$user = "tony"; #name of the sql user 
$password = "sqlpass"; #selected password for the user
$database = "tcg"; #name of the database used 
$table = "yugioh"; #name of the table in the database


#attempt to connect to the database using above credentials
try {
 	$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
	
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

