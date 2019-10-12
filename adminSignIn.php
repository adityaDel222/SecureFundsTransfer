<?php
session_start();
if(!empty($_SESSION)) {
	header("Location: admin/adminDashboard.php");
}
$host = "localhost";
$user = "root";
$pass = "";
$database = "sebs_project";
$conn = new mysqli($host, $user, $pass, $database) or die("Connection failed: %s\n".$conn->error);
if(isset($_POST["submit"])) {
	$conn->query('Use sebs_project;');
	$usernamePHP = $_POST["username"];
	$passwordPHP = $_POST["password"];
	$sql = "SELECT adminUsernameDB, adminPasswordDB FROM admin WHERE adminUsernameDB = '".$usernamePHP."' && adminPasswordDB = '".$passwordPHP."';";
	$result = $conn->query($sql);
	if($result->num_rows == 1) {
		$_SESSION['user'] = $usernamePHP;
		$_SESSION['pass'] = $passwordPHP;
		header("Location: admin/adminDashboard.php");
	}
	else {
		echo '<script>alert("Incorrect username or password.");</script>';
	}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Secure Funds Transfer | Admin Sign In</title>
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/style1.css" />
</head>
<body>
<div class="header">
	<div class="top_links">
		<a href="index.php" style="margin-right: 2em;">User</a>
		<a href="adminSignIn.html" style="margin-right: 5em; border-top: 0.2em solid #fff;">Admin</a>
	</div>
	<h1>Secure Funds Transfer</h1>
</div>
<iframe width="560" height="315" src="https://www.youtube.com/embed/WOlqVYkcRtA?autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<form action="" method="POST">
	<h2>Sign in to your account</h2>
	<input id="usernameID" type="text" name="username" placeholder="Username" required autofocus />
	<input id="passwordID" type="password" name="password" placeholder="Password" required />
	<input type="submit" name="submit" value="Sign In" />
</form>
</body>
</html>
<?php
$conn->close();
?>