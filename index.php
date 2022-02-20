<?php
	require_once('db_credentials.php');
	require_once('database_functions.php');
	require_once('classes/validator.class.php');
	require_once('validator_functions.php');

	$database = db_connect();

	Validator::set_database($database);

	// Example List of data
	$data = [
		"mail@example.com"=>"Yashveer!5!5",
		"yash@faceb.com"=>"the"
	];

	$valid = new Validator($data);

	foreach($data as $email => $password) {
		$result = $valid->isValid($email, $password);

		if($valid->emailValidated && $valid->passwordValidated) {
			$res = $valid->add($email, $password);

			if($res === true) {
				echo "Passed password and email validation: Saved to DB.";
			} else {
				echo "Failed to save to DB.";
			}
		} 

		if($result != "") {
			echo "<hr>";
			echo $result;
			echo "<br>";
		}
	}

	// CREATE TABLE users (
	// 	id INT(11) AUTO_INCREMENT PRIMARY KEY,
	// 	email VARCHAR(255) NOT NULL,
	// 	hashed_password VARCHAR(255) NOT NULL
	// );

	// Reason for SQL - More experince in PHP and SQL vs PHP and Document-base (Mongo)
	// Do have years off experince in Mongo with JS - Wasn't prepared to experiment with PHP and Mongo due to time
	
	// QUESTION - Please describe what needs to be done to use this service to validate an organization's password policy (no need to code it) - Missed this question - Not sure / Please elobrate 
	
	// ALSO NOTE, I've created a few 'TODO' items reason being, I'm not sure about the position of those functions but they do work - Not too experienced with PHP - I am willing to extend my knowledge 

	  
	db_disconnect($database);
?>

