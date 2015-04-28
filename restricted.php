<?php
// continuing the session
session_start();
// start of an if condition
if ($_SESSION['logged_in'] == true){ 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Restricted Area!</title>
</head>

<body>
<h1>Only for registered users!</h1>
<a href="logout.php">Logout</a>
</body>
</html>
<?php
// end of if condition
}
else {
    header("location:login.php");
}
?>