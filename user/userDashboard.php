<?php
session_start();
if(empty($_SESSION)) {
	header("Location: ../index.php");
}
$host = "localhost";
$user = "root";
$pass = "";
$database = "sebs_project";
$conn = new mysqli($host, $user, $pass, $database) or die("Connection failed: %s\n".$conn->error);
$usernamePHP = $_SESSION['username'];
$passwordPHP = $_SESSION['password'];
$sql = "SELECT * FROM users WHERE usernameDB = '".$usernamePHP."' && passwordDB = '".$passwordPHP."';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$n = $row['nameDB'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>User Home | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<style>
h2 {
	margin-right: 2em;
	margin-bottom: 1em;
	float: right;
	font-family: Segoe UI Light;
	font-size: 2em;
	text-shadow: 0.01em 0.01em 0.1em #aaa;
}
.cards {
	margin-top: 7em;
	margin-left: 5em;
}
.cards a {
	display: inline-block;
	width: 5em;
	height: 4em;
	text-align: center;
	vertical-align: middle;
	margin: 0 0 0 2em;
	background-color: #c00;
	padding: 3em 0.5em 0em 0.5em;
	font-family: Segoe UI Light;
	font-size: 2em;
	color: #fff;
	text-decoration: none;
	border: 0.15em solid #f00;
	border-radius: 0.3em;
	transition: transform 0.5s;
}
.cards a:hover {
	transform: scale(1.1,1.1);
}
</style>
</head>
<body>
<div class="header">
	<a class="logout" href="userLogout.php">Log Out</a>
	<h1>Secure Funds Transfer</h1>
</div>
<?php
echo '<h2>Welcome back, '.$n.'!</h2>';
?>
<div class="cards">
	<a href="transfer.php"><br />Transfer<!--<span style="left: 7.7em;">&#8680;</span>--></a>
	<a href="viewTransactions.php">View Transactions<!--<span style="left: 3.65em;">&#8680;</span>--></a>
	<a href="viewBalance.php">View Balance<!--<span style="left: 5.5em;">&#8680;</span>--></a>
	<a href="complain.php"><br />Complain<!--<span style="left: 7em;">&#8680;</span>--></a>
</div>
</body>
</html>
<?php
$conn->close();
?>