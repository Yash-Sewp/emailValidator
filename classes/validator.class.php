<?php 

class Validator {

	// public $email;
	// public $password;

	// public function __construct ($data, $password) {
	// 	$this->email = $data ?? '';
	// 	$this->password = $password ?? '';
	// }

	// public function isValid() {
	// 	$response = $this->validate();
	// 	return $response;
	// }

	public function validate($email, $password) {
		$isValidEmail = "";
		$isValidPassword = "";

		if(is_blank($email)) {
			$isValidEmail .= "Email cannot be blank.";
		  } elseif (!has_length($email, array('max' => 255))) {
			$isValidEmail .= "Last name must be less than 255 characters.";
		  } elseif (!has_valid_email_format($email)) {
			$isValidEmail .= "Email must be a valid format.";
		} else {
			$isValidEmail .= "Valid";
		}

		if(is_blank($password)) {
			$isValidPassword .= "Password cannot be blank.";
		  } elseif (!has_length($password, array('min' => 12))) {
			$isValidPassword .= "Password must contain 12 or more characters";
		  } elseif (!preg_match('/[A-Z]/', $password)) {
			$isValidPassword .= "Password must contain at least 1 uppercase letter";
		  } elseif (!preg_match('/[a-z]/', $password)) {
			$isValidPassword .= "Password must contain at least 1 lowercase letter";
		  } elseif (!preg_match('/[0-9]/', $password)) {
			$isValidPassword .= "Password must contain at least 1 number";
		  } elseif (!preg_match('/[^A-Za-z0-9\s]/', $password)) {
			$isValidPassword .= "Password must contain at least 1 symbol";
		  } else {
			$isValidPassword .= "Password is Okay";
		  }

		return  "EMAIL: " . $email . "<br> <b>Email status: </b>" . $isValidEmail . "<br><br>" . "PASSWORD: " . $password . "<br> <b>Password status: </b>" . $isValidPassword;
	}
	
}




?>