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
$sql = "SELECT accountNoDB FROM users WHERE usernameDB = '" . $usernamePHP . "';";
$result = $conn->query($sql);
if($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$accNo = $row['accountNoDB'];
	$sql1 = "SELECT * FROM transactions WHERE fromAcc = '" . $accNo . "' OR toAcc = '" . $accNo . "';";
	$result1 = $conn->query($sql1);
	if($result1->num_rows > 0) {
		echo '<table class="view_transactions">';
		echo '<tr class="head_tr">';
		echo '<td>Status</td>';
		echo '<td>From/To</td>';
		echo '<td>Amount</td>';
		echo '<td>Date/Time</td>';
		echo '</tr>';
		while($row = $result1->fetch_assoc()) {
			$from = $row['fromAcc'];
			$to = $row['toAcc'];
			$amount = $row['amount'];
			$timestamp = $row['transaction_time'];
			if($accNo == $from) {
				echo '<tr style="background-color: #ffe6e6;">';
				echo '<td><p>Transferred To</p></td>';
				echo '<td>' . $to . '</td>';
				echo '<td>' . $amount . '</td>';
				echo '<td>' . $timestamp . '</td>';
				echo '</tr>';
			}
			else if($accNo == $to) {
				echo '<tr style="background-color: #e6ffe6;">';
				echo '<td><p>Received From</p></td>';
				echo '<td>' . $from . '</td>';
				echo '<td>' . $amount . '</td>';
				echo '<td>' . $timestamp . '</td>';
				echo '</tr>';
			}
		}
		echo '</table>';
	}
	else {
		echo '<p class="no_transactions">No transactions for this account.</p>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>View Transactions | User | Secure Funds Transfer</title>
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
	<a href="viewTransactions.php" style="background-color: #aaa;" />View Transactions</a>
	<a href="viewBalance.php" />View Balance</a>
	<a href="Complain.php" />Complain</a>
</div>
<h2>Transactions</h2>
</body>
</html>
<?php
$conn->close();
?>