<?php
session_start();
if(empty($_SESSION)) {
	header("Location: ../adminSignIn.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Admin Home | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<style>
.admin_pic {
	float: right;
	width: 11em;
	height: 11em;
	margin-top: 5.5em;
	margin-right: 1em;
	background-color: #fff;
}
.content_head {
	float: right;
	margin-right: 2em;
	font-family: Segoe UI Light;
	font-size: 5em;
	text-shadow: 0.01em 0.01em 0.1em #aaa;
}
.card {
	position: relative;
	display: block;
	width: 10em;
	margin: 1em 0 0 2em;
	background-color: #c00;
	padding: 0.5em;
	font-family: Segoe UI Light;
	font-size: 2em;
	color: #fff;
	text-decoration: none;
	transition: width 0.5s;
}
.card:hover {
	width: 12em;
}
.card span {
	position: relative;
}
</style>
</head>
</body>
<div class="header">
	<a class="logout" href="adminLogout.php">Log Out</a>
	<h1>Secure Funds Transfer</h1>
</div>
<h1 class="content_head">Welcome,<br />Administrator</h1>
<img class="admin_pic" src="adminPic.jpg" />
<a class="card" href="addUser.php">Add User<span style="left: 7em;">&#8680;</span></a>
<a class="card" href="viewUsers.php">View Users<span style="left: 6.4em;">&#8680;</span></a>
<a class="card" href="viewComplaints.php">View Complaints<span style="left: 4em;">&#8680;</span></a>
</body>
</html>