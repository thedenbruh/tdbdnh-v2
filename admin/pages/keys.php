<?php
include('../../site/ahdr.php');
include('../../site/PHP/helper.php');
 error_reporting(E_ALL);
 if($userRow->{'power'} < 2) {
	 header('Location: /');
	 die();
 }
 
?>
<!DOCTYPE html>
<html>

	<head>
	</head>
	
	<body>
		<div id="body">
			<div id="box" style="padding:5px; width:75%; height:auto;">
			<button onClick="window.location.replace('/admin/pages/ak');" style="text-decoration:none;">Click Here if you can't generate keys there</button>
			<?php 
			$lmao = "DH_";
			if (isset($_POST['genKey'])) {
				
				function genKey() {
					return rand(1,6) . rand(10000,99999) . range(1,6);
				}
				
				$key = substr(hash('sha256', genKey()), 0, 6);
				
				$createKeySQL = "INSERT INTO `reg_keys` (`id`,`key_content`,`used`) VALUES (NULL, 'DH_$key', '0') ";
				$createKey = $conn->query($createKeySQL);
				
				
			}
			
			?>
				<div> 
				<form action="" method="POST">
				<input type="submit" style="width:50%;margin:auto;display:block;text-align:center;" name="genKey" value="Generate New Key">
				</form>
				</div>
				<div>
					<div>
						<b>
							Active Keys
						</b>
					</div>
						<?php 
						
						$findActiveKeysSQL = "SELECT * FROM `reg_keys` WHERE `used` = '0'";
						$findActiveKeys = $conn->query($findActiveKeysSQL);
						
						if ($findActiveKeys->num_rows > 0) {
							while ($keyRow = $findActiveKeys->fetch_assoc()) {
								$keyRow = (object) $keyRow;
								?>
								<div style="width:73%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'key_content'} ; ?>
								</div>
								<div style="width:23%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'id'} ; ?>
								</div>
								<?php
							}
						} else {
							?>
							<div style="color:grey;text-align:center;">
								There are no active keys!
							</div>
							<?php
						}
						
						?>
					
				</div>
				<div>
					<div>
						<b>
							Used Keys
						</b>
					</div>
						<?php 
						
						$findActiveKeysSQL = "SELECT * FROM `reg_keys` WHERE `used` = '1'";
						$findActiveKeys = $conn->query($findActiveKeysSQL);
						
						if ($findActiveKeys->num_rows > 0) {
							?>
							<div style="width:73%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<b> Key </b>
							</div>
							<div style="width:23%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<b> ID </b>
							</div>
							<?php
							while ($keyRow = $findActiveKeys->fetch_assoc()) {
								$keyRow = (object) $keyRow;
								?>
								<div style="width:73%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'key_content'} ; ?>
								</div>
								<div style="width:23%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'id'} ; ?>
								</div>
								<?php
							}
						} else {
							?>
							<div style="color:grey;text-align:center;">
								There are no used keys!
							</div>
							<?php
						}
						
						?>
					
				</div>
			</div>
	</body>
	
</html>