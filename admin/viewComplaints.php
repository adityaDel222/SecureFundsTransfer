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
$sql = 'SELECT A.nameDB AS Name, B.usernameDB AS Username, B.complaintDB AS Complaint FROM users A, complaints B WHERE A.usernameDB = B.usernameDB';
$result = $conn->query($sql);
if($result->num_rows > 0) {
	echo '<table>';
	echo '<tr class="head_tr">';
	echo '<td>Name</td>';
	echo '<td>Username</td>';
	echo '<td style="width: 15em;">Complaint</td>';
	while($row = $result->fetch_assoc()) {
		echo '<tr>';
		echo '<td>' . $row["Name"] . '</td>';
		echo '<td>' . $row["Username"] . '</td>';
		echo '<td style="width: 15em;">' . $row["Complaint"] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
}
else {
	echo '<p class="no_complaints">No complaints as of yet.</p>';
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
	<a href="viewUsers.php" />View Users</a>
	<a href="viewComplaints.php" style="background-color: #aaa;" />View Complaints</a>
</div>
<h2>Complaints</h2>
</form>
</body>
</html>
<?php
$conn->close();
?>