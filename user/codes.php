<?php
include('../site/header.php');
error_reporting(0);
$error = array();

if(!$loggedIn) {header("Location: /"); die();}
  $me = $_SESSION['id'];
  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$me'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();


//a mess, working mess...

if(isset($_POST['submit'])) {

$pcode = mysqli_real_escape_string($conn,$_POST['pcode']);
  $sql = "SELECT * FROM `items` WHERE  `name` = '$pcode'";
  $result = $conn->query($sql);
  $shopRow = $result->fetch_assoc();

if(empty($error)) {
$item = $shopRow['tickets'];
$troll = "-1";
$bucks = $shopRow['robux'];
$fyphp = $shopRow['id'];

if($item > "0"){
$crate = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`, `payment`, `price`, `date`, `own`) VALUES (NULL,'$me','$item','$troll','bits','0',CURRENT_TIMESTAMP,'yes')";
$cSQL = $conn->query($crate);
$ownsSQL = "SELECT * FROM `crate` WHERE `item_id`='$item' AND `user_id`='$me'";
$owns = $conn->query($ownsSQL);
if($owns->num_rows > 0) {$owns = true;} else {$owns = false;}
if($owns = true) {$error[] = "you've already reedemed it";}
}
 
if($bucks > "0"){
$trololo = $userRow['bucks']+$bucks;
$mUsed = "UPDATE `items` SET `method` = 'offsale' WHERE `id` = '$fyphp'";
$godhelpme = $conn->query($mUsed);

if($godhelpme = "offsale") {$error[] = "fun fact, all money promocodes expire after one use";}
if(empty($error)) {
$moneyz = "UPDATE `beta_users` SET `bucks` = '$trololo' WHERE `id` = '$me'";
$mSQL = $conn->query($moneyz);
}

}
}
}


//now this looks even better btw
?>
<head>
<title>Promocodes - plutonium</title>
</head>
<div id="body">

						<?php
						if(!empty($error)) {
							echo '<div style="color:#EE3333; background-color:#a73e40" id="box"><center>';
							foreach($error as $line) {
								echo $line.'</center>';
							}
							echo '</div>';
						}
						?>

<div id="box" style="margin:10px; text-align:center;">
<div id="subsect">
<h3>Promocodes</h3>
</div>
<form action="" method="POST" style="margin-top:5px;">
<input type="text" name="pcode" placeholder="type the promocode here" style="width:200px; height:16px;"></input>
<input type="submit" name="submit" style="margin-top:15px;">
</form>
</div>
</div>

<?php
include('../site/footer.php');
?>