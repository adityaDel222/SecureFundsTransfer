<?php
session_start();
if(empty($_SESSION)) {
	header("Location: ../adminSignIn.php");
}
$host = "localhost";
$user = "root";
$pass = "";
$database = "sebs_project";
$conn = new mysqli($host, $user, $pass, $database) or die("Connection failed: %s\n".$conn->error);
$conn->query('Use sebs_project;');
$sql = 'SELECT nameDB, contactNoDB, concat(bankNameDB, ", ", branchNameDB) AS bankDB, accountNoDB, amountDB FROM users';
$result = $conn->query($sql);
if($result->num_rows > 0) {
	echo '<table>';
	echo '<tr class="head_tr">';
	echo '<td>Name</td>';
	echo '<td>Contact</td>';
	echo '<td>Bank</td>';
	echo '<td>A/C Number</td>';
	echo '<td>Amount</td>';
	echo '</tr>';
	while($row = $result->fetch_assoc()) {
		echo '<tr>';
		echo '<td>' . $row["nameDB"] . '</td>';
		echo '<td>' . $row["contactNoDB"] . '</td>';
		echo '<td>' . $row["bankDB"] . '</td>';
		echo '<td>' . $row["accountNoDB"] . '</td>';
		echo '<td>' . $row["amountDB"] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
}
else {
	echo 'No results.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>View Users | Admin | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<link rel="stylesheet" href="../styles/style3.css" />
<link rel="stylesheet" href="../styles/style6.css" />
</head>
<body>
<div class="header">
	<a class="logout" href="adminLogout.php">Log Out</a>
	<h1>Secure Funds Transfer</h1>
</div>
<div class="nav_bar">
	<a href="adminDashboard.php" style="margin-left: 2.5em;" />Home</a>
	<a href="addUser.php" />Add User</a>
	<a href="viewUsers.php" style="background-color: #aaa;" />View Users</a>
	<a href="viewComplaints.php" />View Complaints</a>
</div>
<h2>View Users</h2>
</body>
</html>
<?php
$conn->close();
?>