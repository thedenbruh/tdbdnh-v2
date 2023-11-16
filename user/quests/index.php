<?php
include('../../site/header.php');
error_reporting(E_ALL);
$error=array();
$curDate = date('Y-m-d H:i:s');
$sus = $_SESSION['id'];

$q = "SELECT * FROM `quests` WHERE `done` = '0' AND `uid` = '$sus'";
$qSQL = $conn->query($q);

//forum replies + userRow + idfk

$findFriendsSQL = "SELECT * FROM `friends` WHERE `to_id` = '$sus' AND `status`='accepted' OR `from_id` = '$sus' AND `status` = 'accepted'";
	$findFriendsQuery = $conn->query($findFriendsSQL);

$frcnt = mysqli_num_rows($findFriendsQuery);

  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$sus'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();

$postCountSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$sus'";
$postCount = $conn->query($postCountSQL);
$posts = $postCount->num_rows;
$lastonline = strtotime($curDate)-strtotime($userRow['last_online']);
$threadCountSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$sus'";
$threadCount = $conn->query($threadCountSQL);
$threads = $threadCount->num_rows;      		
$userPostCount = ($threads+$posts);
?>

<head>
<title>plutonium - Quests</title>
<head>

<div id="body">

	<div id="box">
	<div id="subsect"><h2>Welcome to the Quests!</h2></div>
	<h4>Complete quests in order to obtain new specials!</h4><br><center>
	<h3>Account Statistics:</h3>
	<h4>Forum Posts: <?php echo $userPostCount; ?> <span>|</span> Friends: <?php echo $frcnt; ?> <span>|</span> Bucks: <?php echo $userRow['bucks']; ?></h4></center>
	<div id="subsect" style="margin-top:32px;"><h3>Your Quests:</h3></div>
	</div>
	<?php
	while($qRow=$qSQL->fetch_assoc()) {

if(isset($_POST['submit'])) {

if($qRow['replies'] <= $userPostCount){
if($userPostCount <= $qRow['replies']) {$error[] = 'seems like you do not have enough forum posts to complete this quest or others.';}
$godhelpme = $qRow['item'];
$qID = $qRow['id'];
if(empty($error)){
$crate = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`,`payment`,`price`,`date`,`own`) VALUES (NULL, '$sus', '$godhelpme', '-2', 'bits', '0', CURRENT_TIMESTAMP, 'yes')";
$wtf = $conn->query($crate);
$qd = "UPDATE `quests` SET `done` = '1' WHERE `uid` = '$sus' AND `replies` <= '$userPostCount'";
$qdSQL = $conn->query($qd);
}
}

if($qRow['friends'] <= $frcnt){
if($frcnt <= $qRow['friends']) {$error[] = 'seems like you do not have enough friends to complete this quest or others.';}
$godhelpme = $qRow['item'];
$qID = $qRow['id'];
if(empty($error)){
$crate = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`,`payment`,`price`,`date`,`own`) VALUES (NULL, '$sus', '$godhelpme', '-2', 'bits', '0', CURRENT_TIMESTAMP, 'yes')";
$wtf = $conn->query($crate);
$qd = "UPDATE `quests` SET `done` = '1' WHERE `uid` = '$sus'"; 
$qdSQL = $conn->query($qd);
}
}

if($qRow['bucks'] <= $userRow['bucks']){
if($userRow['bucks'] <= $qRow['bucks']) {$error[] = 'seems like you do not have enough bucks to complete this quest or others.';}
$bucks = $userRow['bucks'];
$price = $qRow['bucks'];
$godhelpme = $qRow['item'];
$qID = $qRow['id'];
if(empty($error)){
//bro i would to take some bucks from you
$trolla = "UPDATE `beta_users` SET `bucks` = '$bucks'-$price WHERE `id` = '$sus'";
$bucktaker = $conn->query($trolla);
$crate = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`,`payment`,`price`,`date`,`own`) VALUES (NULL, '$sus', '$godhelpme', '-2', 'bits', '0', CURRENT_TIMESTAMP, 'yes')";
$wtf = $conn->query($crate);
$qd = "UPDATE `quests` SET `done` = '1' WHERE `uid` = '$sus' AND `replies` <= '$userPostCount'";
$qdSQL = $conn->query($qd);
}
}



}

?>
<div id="box" style="padding:10px;">
<h3><center>Quest <?php echo $qRow['id'];?> : <?php echo $qRow['name'];?><br><span></span>Requirements: <?php if($qRow['friends'] > 1){echo 'Friends: '.$qRow['friends'].' ';} if($qRow['replies'] > 1){echo 'Forum Replies: '.$qRow['replies'].' ';} if($qRow['bucks'] > 1){echo 'Bucks: '.$qRow['bucks'].' ';} ?></h3><form action="" method="POST" style="text-align:center;"><input type="submit" name="submit" value="Complete Quest!"></form>
</div>
<?php } 

          if(!empty($error)) {
            echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
            foreach($error as $line) {
              echo $line.'<br>';
            }
            echo '</div>';
          }
?>
</div>

<?php



//welcome too hell - pandemonium


include('../../site/footer.php');
?>