<?php 
// loading external PHP script, target to file passed as argument
require_once('db_const.php');
// checking IF form-array exists
if(isset($_POST['submit'])){
	$connection = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
	// checking for connection errors
	if($connection->connect_error){
		// exit the current script
		die($connection->connect_error);
		}else {
	//echo "Superduper - connection made!";
	}
// prepare data for insertion into database
// collect form values
$username = $_POST['username'];
// adding basic password encryption
$password = hash("sha256", $_POST['password']);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
# check if username and email exist, else insert
	$exists = 0;
	$check = $connection->query("SELECT username from users WHERE username = '$username' LIMIT 1");
	// sometimes we only want to retrieve a subset of records. In MySQL, this is accomplished using the LIMIT keyword
	if ($check->num_rows == 1) {
		$exists = 1;
		$check = $connection->query("SELECT email from users WHERE email = '$email' LIMIT 1");
		if ($check->num_rows == 1) $exists = 2;	
	} else {
		$check = $connection->query("SELECT email from users WHERE email = '$email' LIMIT 1");
		if ($check->num_rows == 1) $exists = 3;
	}
 
	if ($exists == 1) echo "<p>Username already exists!</p>";
	else if ($exists == 2) echo "<p>Username and Email already exists!</p>";
	else if ($exists == 3) echo "<p>Email already exists!</p>";
	else {
		###################################
		# insert data into mysql database #
		###################################
		
		$insert = "INSERT INTO users (id, username, password, first_name, last_name, email) 
				VALUES (NULL, '$username', '$password', '$first_name', '$last_name', '$email')";
		// execute SQL query		
 		
		if($connection->query($insert)){
			echo "New user registered!";
		}else{
			echo "Ooops - something went wrong...";
		}
	}

// end if isset	

}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Registration</title>
</head>

<body>
<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
Username: <input type="text" name="username" id="username"><br>
Password: <input type="password" name="password" id="password"><br>
First name: <input type="text" name="first_name" id="first_name"><br>
Last name: <input type="text" name="last_name" id="last_name"><br>
E-mail: <input type="email" name="email" id="email"><br>
<input type="submit" name="submit" value="Register">
</form>
</body>
</html>





