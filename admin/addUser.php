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
define('AES_256_CBC', 'aes-256-cbc');
if(isset($_POST["submit"])) {
	$conn->query("USE sebs_project;");
	$namePHP = $_POST["name"];
	$contactNoPHP = $_POST["contactNo"];
	$bankNamePHP = $_POST["bankName"];
	$branchNamePHP = $_POST["branchName"];
	$accountNoPHP = $_POST["accountNo"];
	$cardIDPHP = $_POST["cardID"];
	$encryption_key = openssl_random_pseudo_bytes(32);
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
	$cardIDPHPenc = openssl_encrypt($cardIDPHP, AES_256_CBC, $encryption_key, 0, $iv);
	$cardIDPHPenc = $cardIDPHPenc . ':' . base64_encode($iv);
	$PINPHP = $_POST["PIN"];
	if(CRYPT_STD_DES == 1)
		$PINPHPenc = crypt($PINPHP, 'st');
	$amountPHP = $_POST["amount"];
	$usernamePHP = $_POST["username"];
	$passwordPHP = $_POST["password"];
	$passwordPHPhash = md5($passwordPHP);
	$sql = "INSERT INTO users VALUES ('" . $namePHP . "', '" . $contactNoPHP . "', '" . $bankNamePHP . "', '" . $branchNamePHP . "', '" . $accountNoPHP . "', '" . $encryption_key . "', '" . $iv . "', '" . $cardIDPHPenc . "', '" . $PINPHPenc . "', '" . $amountPHP . "', '" . $usernamePHP . "', '" . $passwordPHPhash . "');";
	if ($conn->query($sql)) {
		echo "<script>alert('Account Created Successfully!');</script>";
	}
	else {
		echo "<script>alert('Error creating account: ".$conn->error.");</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Add User | Admin | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<link rel="stylesheet" href="../styles/style3.css" />
<link rel="stylesheet" href="../styles/style4.css" />
</head>
<body>
<div class="header">
	<a class="logout" href="adminLogout.php">Log Out</a>
	<h1>Secure Funds Transfer</h1>
</div>
<div class="nav_bar">
	<a href="adminDashboard.php" style="margin-left: 2.5em;" />Home</a>
	<a href="addUser.php" style="background-color: #aaa;" />Add User</a>
	<a href="viewUsers.php" />View Users</a>
	<a href="viewComplaints.php" />View Complaints</a>
</div>
<h2>Add User</h2>
<form action="" method="POST">
	<input type="text" name="name" placeholder="Name" maxlength="30" required autofocus />
	<input type="text" name="contactNo" placeholder="Contact Number" maxlength="10" required />
	<input type="text" name="bankName" placeholder="Bank Name" maxlength="30" required />
	<input type="text" name="branchName" placeholder="Branch Name" maxlength="30" required />
	<input type="text" name="accountNo" placeholder="Account Number" maxlength="18" minlength="16" required />
	<input type="text" name="cardID" placeholder="Card ID" maxlength="16" minlength="16" required />
	<input type="text" name="PIN" placeholder="PIN" maxlength="6" minlength="4" required />
	<input type="number" name="amount" placeholder="Amount" step="0.01" min="100.00" required />
	<input type="text" name="username" placeholder="Username" required />
	<input type="password" name="password" placeholder="Password" required />
	<input type="submit" name="submit" value="Submit" />
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
</body>
</html>
<?php
$conn->close();
?>