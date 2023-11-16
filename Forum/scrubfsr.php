<?php
error_reporting(E_ALL);
	include("../site/header.php");
	
	if(!$loggedIn) {header("Location: index"); die();}
	if($power < 5) {header("Location: index"); die();}
	
	if(isset($_GET['id'])) {
		$userID = $_GET['id'];
		$scrubSQL = "UPDATE `test` SET `crap`='[ Content Removed ]' WHERE `uid`='$userID'";
		$scrub = $conn->query($scrubSQL);
header('Location: index');
	}
?>