<?php
error_reporting(0);
include("../../site/config.php");

//shows the currently wearing thing to user page


if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn,intval($_GET['id']));
  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();

	$findUserAvatarSQL = "SELECT * FROM `avatar` WHERE `user_id` = '$id'";
$findUserAvatar = $conn->query($findUserAvatarSQL);
$userAvatar = (object) $findUserAvatar->fetch_assoc();


 //var_dump ( $userAvatar );
	$itemArray = array(
		"h1" => $userAvatar->{'hat1'},
		"h2" => $userAvatar->{'hat2'},
		"h3" => $userAvatar->{'hat3'},
		"h4" => $userAvatar->{'hat4'},
		"h5" => $userAvatar->{'hat5'},
		"s" => $userAvatar->{'shirt'},
		"tool" => $userAvatar->{'tool'},
		"p" => $userAvatar->{'pants'},
		"t" => $userAvatar->{'tshirt'},
		"f" => $userAvatar->{'face'},
		"h" => $userAvatar->{'head'}
	);
	
foreach ($itemArray as $potato => $item) {
$itemID = $item;
$findItemSQL = "SELECT * FROM `shop_items` WHERE `id` = $itemID";
$findItem = $conn->query($findItemSQL);
  if ($findItem->num_rows > 0) {
    $itemRow = (object) $findItem->fetch_assoc();
    
    if ($itemRow->{'approved'} == 'yes') {$thumbnail = $itemRow->{'id'};}
	elseif ($itemRow->{'approved'} == 'declined') {$thumbnail = 'declined';}
	else {$thumbnail = 'pending';}
    
		$kek = $potato;
  ?><div style="clear: both;width: 118px;display:inline-block;position: relative;">
    <a href="/shop/item?id=<?php echo $itemRow->{"id"};?>">
			</a>
				<center><img id="shopItem" src="/shop/thumbnails/<?php echo $thumbnail; ?>.png" style="width: 92%;height:auto;"></a>
				<span style="text-align:center;display:inline-block;float:left;width: 100%;">
					<a class="shopTitle" href="/shop/item?id=<?php echo $itemRow->{"id"};?>" style="font-size:16px;">
						<?php echo htmlentities($itemRow->{'name'}); ?>
					</a>
				</span>
					<div style="text-align:center;">
					</div>
				</div> 
				<?php
 } 
	}}
?>