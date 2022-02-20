<?php 

class Validator {

	static protected $database;
	public $emailValidated = false;
	public $passwordValidated = false;

	static public function set_database($database) {
		self::$database = $database;
	}

	public function isValid($e, $p) {
		$response = $this->validate($e, $p);
		return $response;
	}

	public function find_by_email($email) {
		$sql = "SELECT * FROM users ";
		$sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
		$obj_array = static::find_by_sql($sql);
		if(!empty($obj_array)) {
		  return true;
		} else {
		  return false;
		}
	}

	public function find_by_sql($sql) {
		$result = static::$database->query($sql);
	
		if(!$result) {
		  exit("Database query failed");
		}
		// convert results in objects
		$object_array = [];
	
		while($record = $result->fetch_assoc()) {
		  $object_array[] = self::instantiate($record);
		}
	
		$result->free();
		return $object_array;
	}

	public function add($email, $password) {
		$this->isValid($email, $password);
		if(!empty($this->errors)) { return false; }
		//TODO: hashed password function into DB
		$sql = "INSERT INTO users (email, hashed_password) VALUES ('$email', '$password')";
		$result = self::$database->query($sql);
		if($result) {
		  $this->id = self::$database->insert_id;
		} 
		return $result;
	}

	public function instantiate($record) {
		$object = new static;
		// Manually assign values to properties
		// But auto assignment
		foreach($record as $property => $value) {
		  if(property_exists($object, $property)) {
			$object->$property = $value;
		  }
		}
		return $object;
	}

	public function set_hashed_password() {
		$this->password = password_hash($this->password, PASSWORD_BCRYPT);
	}

	public function validate($email, $password) {
		$isValidEmail = "";
		$isValidPassword = "";

		if(is_blank($email)) {
			$isValidEmail = "Email cannot be blank.";
		  } elseif (!has_length($email, array('max' => 255))) {
			$isValidEmail = "Last name must be less than 255 characters.";
		  } elseif (!has_valid_email_format($email)) {
			$isValidEmail = "Email must be a valid format.";
		} elseif(!in_black_list($email)) {
			$isValidEmail = "Email domain is part of blacklist.";
		} elseif($this->find_by_email($email)) {
			$isValidEmail = "Email exist in DB.";
		} else {
			$isValidEmail = "Email is valid.";
			$this->emailValidated = true;
		}

		if(is_blank($password)) {
			$isValidPassword = "Password cannot be blank.";
		} elseif (!has_length($password, array('min' => 12))) {
			$isValidPassword = "Password must contain 12 or more characters";
		} elseif (!preg_match('/[A-Z]/', $password)) {
			$isValidPassword = "Password must contain at least 1 uppercase letter";
		} elseif (!preg_match('/[a-z]/', $password)) {
			$isValidPassword = "Password must contain at least 1 lowercase letter";
		} elseif (!preg_match('/[0-9]/', $password)) {
			$isValidPassword = "Password must contain at least 1 number";
		} elseif (!preg_match('/[^A-Za-z0-9\s]/', $password)) {
			$isValidPassword = "Password must contain at least 1 symbol";
		} else {
			$isValidPassword = "Password is Okay.";
			$this->passwordValidated = true;
		}

		//TODO: Move out of function 
		return  "EMAIL: " . $email . "<br> <b>Email status: </b>" . $isValidEmail . "<br><br>" . "PASSWORD: " . $password . "<br> <b>Password status: </b>" . $isValidPassword;
	}

	// TODO: Should create User Class / Make Validator a Base Class that extends the User Class
	
	public $email;
	public $password;

	public function __construct ($args=[]) {
		$this->email = $args['email'] ?? '';
		$this->password = $args['password'] ?? '';
	}
	
}




?>