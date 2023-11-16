<?php
include('../site/header.php');
?>

	<head>
		
		<title>My Sets - plutonium</title>
		
	</head>

<body>
		
		<div id="body">

			<div id="box" style="padding-top: 9px;padding-left: 9px;">
				<div id="subsect">
			Your Sets
			</div>
			<?php 
			$ownerID = $_SESSION['id'];
			$findGamesSQL = "SELECT * FROM `games` WHERE `creator_id`='$ownerID' ORDER BY `playing` DESC";
			$findGames = $conn->query($findGamesSQL);
			
			if ($findGames->num_rows > 0) {
				while($gameRow = $findGames->fetch_assoc()) {
					
					// Change array to OOP Array
					
					$gameRow = (object) $gameRow;
					
					// Find Game Owner
					
					$findOwnerSQL = "SELECT * FROM `beta_users` WHERE `id` = $ownerID";
					$findOwner = $conn->query($findOwnerSQL);
					$ownerRow = (object) $findOwner->fetch_assoc();
					
			?>
				<div style="margin: 10px; width: 196px; display:inline-block; ;"><a href="set?id=<?php 
					echo $gameRow->{'id'};
					?>"><img id="shopItem" style="width:196px;" src="<?php echo '/assets/images/games/' . $gameRow->{'id'} . '.png'; ?>"></a>
					<span style="display:inline-block; float:left; width:100%">
						<a class="shopTitle" href="set?id=<?php 
					echo $gameRow->{'id'}; ?>"><?php echo $gameRow->{'name'}; ?></a>
					</span>
					<span style="display:inline-block; float:left; padding-left:0px;"><p class="shopDesc">by<a class="shopDesc" href="/user?id=<?php echo $ownerID; ?>"><?php echo $ownerRow->{'username'}; ?></a></p></span>
					<span style="padding:0px; display:inline-block; float:right; text-align:right"><p class="shopDesc" style="color:Red;"><?php echo $gameRow->{'playing'}; ?> online</p></span>
					</div>
				
				
			<?php 
				}
				} else {
					?>
					<div style="text-align:center;">
						You haven't created any sets!
					</div>
					<?php
				}
			?>
			</div>
<div id="box" style="margin-top:10px; padding-top: 9px;padding-left: 9px;">
<center>make your own set, if you want<br><button onClick="window.location.replace('/play/create/')">Create</button><span></span><button onClick="window.location.replace('/play/oldindex')">Go back to the old games page</button></center>
</div>
		</div>
		


		<?php
		include("../site/footer.php");
		?>
		
	</body>