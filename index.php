<?php
	require_once('classes/validator.class.php');
	require_once('validator_functions.php');
	
	$email = [
		"mail@example.com"=>"Yashveer!5!5",
		"yash@gmail.com"=>"the"
	];

	$valid = new Validator();

	foreach($email as $e => $p) {
		$result = $valid->validate($e, $p);
		echo "<hr>";
		echo $result;
		echo "<br>";
	}

?>