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
$accNo1 = $row['accountNoDB'];
$cID = $row['cardIDDB'];
$P = $row['PINDB'];
$a = $row['amountDB'];
$ek = $row['encryption_key'];
$iv = $row['initialisation_vector'];
define('AES_256_CBC', 'aes-256-cbc');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Transfer | User | Secure Funds Transfer</title>
<link rel="stylesheet" href="../styles/style.css" />
<link rel="stylesheet" href="../styles/style2.css" />
<link rel="stylesheet" href="../styles/style3.css" />
<link rel="stylesheet" href="../styles/style4.css" />
<link rel="stylesheet" href="../styles/style5.css" />
</head>
<body>
<div class="header">
	<a class="logout" href="userLogout.php">Log Out</a>
	<h1>Secure Funds Transfer</h1>
</div>
<div class="nav_bar">
	<a href="userDashboard.php" style="margin-left: 2.5em;" />Home</a>
	<a href="transfer.php" style="background-color: #aaa;" />Transfer</a>
	<a href="viewTransactions.php" />View Transactions</a>
	<a href="viewBalance.php" />View Balance</a>
	<a href="Complain.php" />Complain</a>
</div>
<h2>Transfer Amount</h2>
<form id="initial" action="" method="POST">
	<input id="x1" type="text" name="cardID" placeholder="Card ID" maxlength="16" required />
	<input id="x2" type="password" name="PIN" placeholder="PIN" maxlength="6" required />
	<input id="x3" type="submit" name="proceed" value="Proceed" />
</form>
<form id="proceeded" action="" method="POST">
	<input id="y1" type="text" name="accountNo" placeholder="Recipient's Account Number" maxlength="16" disabled />
	<input id="y2" type="number" name="amount" placeholder="Amount" step="0.01" min="100.00" max="100000.00" disabled />
	<input id="y3" type="submit" name="pay" value="Pay Now" disabled />
</form>
<?php
if(isset($_POST['proceed'])) {
	$cardIDPHP = $_POST['cardID'];
	$cardIDPHPenc = openssl_encrypt($cardIDPHP, AES_256_CBC, $ek, 0, $iv);
	$cardIDPHPenc = $cardIDPHPenc . ':' . base64_encode($iv);
	$PINPHP = $_POST['PIN'];
	if(CRYPT_STD_DES == 1)
		$PINPHPenc = crypt($PINPHP, 'st');
	if($cardIDPHPenc == $cID && $PINPHPenc == $P) {
		echo '<script>document.getElementById("y1").removeAttribute("disabled");</script>';
		echo '<script>document.getElementById("y2").removeAttribute("disabled");</script>';
		echo '<script>document.getElementById("y3").removeAttribute("disabled");</script>';
		echo '<script>document.getElementById("x1").setAttribute("disabled", true);</script>';
		echo '<script>document.getElementById("x2").setAttribute("disabled", true);</script>';
		echo '<script>document.getElementById("x3").setAttribute("disabled", true);</script>';		
		echo '<script>document.getElementById("initial").style.opacity = "0.5";</script>';
		echo '<div class="balance">Balance: '.$a.'</div>';
		echo '<script>document.getElementById("proceeded").style.opacity = "1";';
		echo 'document.getElementById("y1").focus();</script>';
	}
}
if(isset($_POST['pay'])) {
	$accountNoPHP = $_POST['accountNo'];
	$amountPHP = $_POST['amount'];
	$sql = "SELECT accountNoDB, amountDB, usernameDB FROM users WHERE accountNoDB = '".$accountNoPHP."';";
	$result = $conn->query($sql);
	if($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$aN = $row['accountNoDB'];
		$a2 = $row['amountDB'];
		if($amountPHP <= $a - 100.00) {
			$newBalance1 = $a - $amountPHP;
			$newBalance2 = $a2 + $amountPHP;
			$sql1 = "UPDATE users SET amountDB = ".$newBalance1." WHERE cardIDDB = '".$cID."';";
			$sql2 = "UPDATE users SET amountDB = ".$newBalance2." WHERE accountNoDB = '".$aN."';";
			$result1 = $conn->query($sql1);
			$result2 = $conn->query($sql2);
			date_default_timezone_set('Asia/Kolkata');
			$currentDateTime = date('Y-m-d H:i:s');
			$sql3 = "INSERT INTO transactions (fromAcc, toAcc, amount, transaction_time) VALUES ('" . $accNo1 . "', '" . $aN . "', " . $amountPHP . ", '" . $currentDateTime . "');";
			$result3 = $conn->query($sql3);
			echo '<script>alert("Fund successfully transferred.");</script>';
		}
		else {
			echo '<script>alert("Insufficient balance.");</script>';
		}
	}
	else {
		echo '<script>alert("There was an error completing your transaction.");</script>';
	}
}
$conn->close();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
</body>
</html>