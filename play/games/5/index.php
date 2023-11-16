<?php
	include("../../../site/config.php");
	include("../../../site/header.php");
	
	if(!$loggedIn) {header('Location: ../'); die();}
	
$error = array();
	
$econSQL = "SELECT SUM(`bits`) AS 'totalBits' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBits = $econRow['totalBits'];

$econSQL = "SELECT SUM(`bucks`) AS 'totalBucks' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBucks = $econRow['totalBucks'];

$econ = $totalBits+($totalBucks*10); 

	if(isset($_POST['submit'])) {
 

	$userID = $_SESSION['id'];
											
			if($userRow->{'bits'} >= 0) {								
			$newMoney = $userRow->{'bits'}+1	;
			$newMoneySQL = "UPDATE `beta_users` SET `bits`='$newMoney' WHERE `id`='$userID'";
			$newMoneyQ = $conn->query($newMoneySQL);
											
											
	}}
	
?>
<!DOCTYPE html>
	<head>
		<title>1 bit clicker</title>
	</head>
	<body>
		<div id="body">
				<div id="box"; style="margin-top:85px; width:50%; margin-left:226px;"><br>
		<center><h1>1 bit clicker</h1></center>
		<center><h3>have fun</h4></center><hr><br>
				<center><form method="POST" action="#">
    			<input type="submit" name="submit" style="width: 90%; height:90%;">
				</form></center>

		</div></div>
	</body>
	<?php
		include("../../../site/footer.php");
	?>
</html>



