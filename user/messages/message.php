<?php
	include("../../site/header.php");
	
	if(!$loggedIn) {header('Location: ../'); die();}
	
	if (isset($_GET['id'])) {
		$mid = mysqli_real_escape_string($conn,intval($_GET['id']));
		$sqlMessage = "SELECT * FROM `messages` WHERE  `id` = '$mid'";
		$result = $conn->query($sqlMessage);
		$messageRow=$result->fetch_assoc();
		if ($messageRow['recipient_id'] != $userRow->{'id'} && $power < 1) {header("location: index");}
		
		$senderID = $messageRow['author_id'];
		$sqlSender = "SELECT * FROM `beta_users` WHERE  `id`='$senderID'";
		$sendResult = $conn->query($sqlSender);
		$senderRow=$sendResult->fetch_assoc();
		
		$kek = $messageRow['recipient_id'];

		$sqlRead = "UPDATE `messages` SET `read` = 1 WHERE `id` = '$mid'";
		$result = $conn->query($sqlRead);
	} else {
		header("location: index");
	}
if($kek != $currentUserID) {header('Location: /');}
?>

<!DOCTYPE html>
	<head>
		<title><?php echo htmlentities($messageRow['title']); ?></title>
	</head>
	<body>
		<div id="body">
			<div id="box" style="border-radius:0px;">
				<h3>A message by <a href="/user?id=<?php echo $senderRow['id']; ?>"><?php echo $senderRow['username']; ?></a></h3>
					</div><div id="box" style="border-radius:0px;">
				<span style="float:left;">
					<a style="color:#333" href="/user?id=<?php echo $senderRow['id']; ?>">
					<img style="width:220px; border:0px solid #000;" src="/assets/images/avatars/<?php echo $senderRow['id']; ?>.png?c=<?php echo $senderRow['avatar_id'] ?>"></a><hr>
					<center><?php echo '<a href="/report?type=message&id='.$mid.'">Report the message <i style="font-size:13px;" class="fa fa-flag"></i></a>'; ?></center>
				</span>
				<span>
					<h4>Title: <?php echo htmlentities($messageRow['title']); ?></h4><hr>
					<p style="clear: right;padding-left: 230px;"><?php echo nl2br(htmlentities($messageRow['message'])); ?></p>
				</span>
				<form action="compose" method="POST">
					<input type="hidden" name="title" value="<?php echo 'Reply: ' . $messageRow['title']; ?>">
					<input type="hidden" name="recipient" value="<?php echo $senderRow['id']; ?>">
					<input type="hidden" name="message" value="<?php $n = PHP_EOL; echo str_repeat($n,3) . str_repeat('-',24) . $senderRow['username'] . ' at ' . $messageRow['date'] . str_repeat('-',24) . $n . $messageRow['message']; ?>">
					<input style="background-color:#77B9FF; color:#FFF; border:1px solid #000;" type="submit" value="Reply">
				</form>
			</div>
		</div>
	</body>
	<?php
		include("../../site/footer.php");
	?>
</html>