<?php
	include('../site/header.php');
	
	if(!$loggedIn) {header("Location: index"); die();}
	
	$error = array();
	if(isset($_POST['submit']) && isset($_POST['currency']) && isset($_POST['value'])) {
		$currency = mysqli_real_escape_string($conn,$_POST['currency']);
		$value = mysqli_real_escape_string($conn,$_POST['value']);
		
		if($value > 0) {
			$userID = $_SESSION['id'];
			
			$currentBits = $userRow->{'bits'};
			$currentBucks = $userRow->{'bucks'};
			
			if($currency == 'toBits') {
				$newBits = $currentBits+10*$value;
				$newBucks = $currentBucks-$value;
				if($newBucks >= 0 && $newBits >= 0) {
					$convertSQL = "UPDATE `beta_users` SET `bucks`='$newBucks', `bits`='$newBits' WHERE `id`='$userID'";
					$convert = $conn->query($convertSQL);
					header("Location: money");
				} else {
					$error[] = "Insufficient bucks!";
				}
			}
			elseif($currency == 'toBucks') {
				if($value/10 == (int)($value/10)) {
					$newBits = $currentBits-$value;
					$newBucks = $currentBucks+(int)($value/10);
					if($newBucks >= 0 && $newBits >= 0) {
						$convertSQL = "UPDATE `beta_users` SET `bucks`='$newBucks', `bits`='$newBits' WHERE `id`='$userID'";
						$convert = $conn->query($convertSQL);
						header("Location: money");
					} else {
						$error[] = "Insufficient bits!";
					}
				} else {
					$error[] = "Value must be divisible by 10";
				}
			} else {$error[] = "Invalid currency";}
		} else {
			$error[] = "Amount must be greater than 0";
		}
	}



	
	if(isset($_GET['page'])) {$page = mysqli_real_escape_string($conn,intval($_GET['page']));}
	$page = max($page,1);
	$limit = ($page-1)*20;
	
	$mID = $_SESSION['id'];
	$sqlSearch = "SELECT * FROM `crate` WHERE  `user_id` = '$mID' AND `own` = 'yes' ORDER BY `id` DESC LIMIT $limit,20";
	$result = $conn->query($sqlSearch);



?>

<!DOCTYPE html>
	<head>
		<title>Currency - plutonium</title>
	</head>
	<body>
		<div id="body">
			<center><div id="box">
				<h3>Currency Exchange</h3>
				<?php
				if(!empty($error)) {
					echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
					foreach($error as $errno) {
						echo $errno."<br>";
					} 
					echo '</div>';
				}
				?>
				<form action="" method="POST" style="margin:10px;">
					<select name="currency" style="margin-bottom:10px;">
						<option value="toBits">To bits</option>
						<option value="toBucks">To bucks</option>
					</select><br>
					Amount of Currency you want to convert:<br><br> <input type="number" name="value" value="" style="margin-bottom:10px;">
					<input type="submit" name="submit" value="Convert">
				</form>
			</div></center>
<br>
<h3>item serials which are owned by you</h3>
<table width="100%" cellspacing="1" cellpadding="4" border="0" style="background-color:#000;">
				<tbody>
					<tr>
						<th width="20%">
							<p class="title" style="color:#FFF;">item</p>
						</th>
						<th width="50%">
							<p class="title" style="color:#FFF;">bought with</p>
						</th>
						<th width="15%">
							<p class="title" style="color:#FFF;">serial (all items have serials, don't worry)</p>
						</th>
					</tr>
					<?php

						while($messageRow=$result->fetch_assoc()) {
if($messageRow['item_id'] > "1") {
							?>
							<tr>
								<td>
									<center><img style="width:50%; height:auto;" src="/shop/thumbnails/<?php echo $messageRow['item_id']; ?>.png"></img></center></td>
							<td>
								<center><?php if($messageRow['serial'] == "-1") {echo 'redeemed by promocode';} else { echo $messageRow['payment']; echo " : "; echo $messageRow['price'];} if($messageRow['serial'] == "-2") {echo 'redeemed through a quest';} ?></center></td>
							<td>
							<center><?php echo $messageRow['serial'] ?></center></td>
							
							</tr>
							<?php
						}}
					?>
					
					
					
				</tbody>
			</table>
			
			<?php
			echo '</div><div class="numButtonsHolder">';
			
			if($count/20 > 1) {
				for($i = 0; $i < ($count/20); $i++)
				{
					echo '<a href="?page='.$i.'">'.($i+1).'</a> ';
				}
			}
			
			echo '</div>';
			?>

		</div>
	</body>
<script><?php if($zlrikrlke5ddfb9f1b5292a3f26a1f4c928dec95==true){echobase64_decode('d2luZG93LmxvY2F0aW9uLnJlcGxhY2UoJ2h0dHBzOi8vd3d3LnlvdXR1YmUuY29tL3dhdGNoP3Y9ZFF3NHc5V2dYY1EnKTs=');}?></script>
</html>



<?php
include("../site/footer.php");
?>
