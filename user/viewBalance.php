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
$conn->query('Use sebs_project;');
$usernamePHP = $_SESSION['username'];
$passwordPHP = $_SESSION['password'];
$sql = "SELECT * FROM users WHERE usernameDB = '".$usernamePHP."' && passwordDB = '".$passwordPHP."';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$a = $row['amountDB'];
echo '<p class="balance">&#8377;' . $a . '</p>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>View Balance | User | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<link rel="stylesheet" href="../styles/style3.css" />
<link rel="stylesheet" href="../styles/style6.css" />
</head>
<body>
<div class="header">
	<a class="logout" href="userLogout.php">Log Out</a>
	<h1>Secure Funds Transfer</h1>
</div>
<div class="nav_bar">
	<a href="userDashboard.php" style="margin-left: 2.5em;" />Home</a>
	<a href="transfer.php" />Transfer</a>
	<a href="viewTransactions.php" />View Transactions</a>
	<a href="viewBalance.php" style="background-color: #aaa;" />View Balance</a>
	<a href="Complain.php" />Complain</a>
</div>
<h2>Your Balance</h2>
</body>
</html>
<?php
$conn->close();
?>