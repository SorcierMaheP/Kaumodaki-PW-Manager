<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

	session_start();

	$conn = mysqli_connect('db', 'root', 'MYSQL_ROOT_PASSWORD', 'PM_1');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$username = $_POST['username'];
	$email = $_POST['email'];
	$hashemail = hash('md5', $email);
	$password = $_POST['password'];
	$sql = "SELECT `Salt`,`Password` FROM `Credentials` WHERE `Email`='$hashemail'";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		header("Refresh:3, url= http://localhost:8000/authentication");
		echo "Connection failed";
		$conn->close();
		exit();
	} else if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$hasheddata = hash('sha512', $password . $row["Salt"]);
			if ($row["Password"] == $hasheddata) {
				echo "User exists! Sign in instead.";
				header("Refresh:3,url=index.php");
				$conn->close();
				exit();
			}
		}
		header("Refresh:3,url=index.php");
		echo "Email already taken! Use another one.";
		$conn->close();
		exit();
	}
	require_once('func.php');
	$salt = getRandomStringRand();
	$hasheddata = hash('sha512', $password . $salt);

	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['hashemail'] = $hashemail;
	$_SESSION['password'] = $hasheddata;
	$_SESSION['salt'] = $salt;

	$conn->close();
	setcookie($_SESSION['hashemail'], 'register', time() + 360, path: '/');
	header("Location: register-form.php");
	exit();
} else {
	header("Location: index.php");
	exit();
}

?>