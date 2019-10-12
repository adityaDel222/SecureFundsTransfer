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
if(isset($_POST['submit'])) {
	$complaintPHP = $_POST['complaint'];
	$sql = "INSERT INTO complaints VALUES ('" . $complaintPHP . "','" . $usernamePHP . "');";
	if($conn->query($sql)) {
		echo '<script>alert("Complaint submitted successfully.");</script>';
	}
	else {
		echo '<script>alert("There was an error submitting the complaint.");</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Complain | User | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<link rel="stylesheet" href="../styles/style3.css" />
<link rel="stylesheet" href="../styles/style4.css" />
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
	<a href="viewBalance.php" />View Balance</a>
	<a href="Complain.php" style="background-color: #aaa;" />Complain</a>
</div>
<h2>Have a complain?</h2>
<form action="" method="post">
	<textarea name="complaint" rows="8" cols="50" placeholder="Write here..."></textarea>
	<input name="submit" type="submit" value="Submit"></button>
</body>
</html>
<?php
$conn->close();
?>