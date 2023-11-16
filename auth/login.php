<?php 
	include('../site/header.php');
	
	if($loggedIn) {header("Location: /user/dashboard/"); die();}
	
	$error = array();
	if (isset($_POST['ln'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		
		$usernameL = strtolower(mysqli_real_escape_string($conn, $username));
		
		$checkUsernameSQL = "SELECT * FROM `beta_users` WHERE `beta_users`.`usernameL` = '$usernameL'";
		$checkUsername = $conn->query($checkUsernameSQL);
		
		if ($checkUsername->num_rows > 0) {
			
			$username = mysqli_real_escape_string($conn, $username);
			
			$userReqRow = (object) $checkUsername->fetch_assoc();
			
			$userPass = $userReqRow->{'password'};
			
			if (password_verify($password, $userPass)) { //logged in
				$_SESSION['id'] = $userReqRow->{'id'};
				$userID = $_SESSION['id'];
				$userIP = $_SERVER['REMOTE_ADDR'];
				$logSQL = "INSERT INTO `log` (`id`,`action`,`date`) VALUES (NULL,'User $userID logged in from $userIP',CURRENT_TIMESTAMP)";
				$log = $conn->query($logSQL);
				header('Location: /user/dashboard/ ');
				die();
			} else {
				$error[] = "Wrong password!";
			}
			
		} else {
			$error[] = "User does not exist!";
			
		}
		
	}
?>
<!DOCTYPE html>
	<head>
		<title>Login</title>
	</head>
	<body>
<br><br><br><br>
		<div id="body">
			<div style="overflow:auto; text-align:center;">
				<div id="column" style="width:350px;float:center; ">
					<div id="box" style="padding:20px;text-align: center;">
						<?php
						if(!empty($error)) {
							echo '<div style="color:#EE3333;">';
							foreach($error as $line) {
								echo $line.'<br>';
							}
							echo '</div>';
						}
						?>
						<form action="" method="POST" style="margin: auto;">
							<strong>Username:</strong><br>
							<input style="margin-top:8px;margin-bottom:8px;" type="text" name="username"><br>
							<strong>Password:</strong><br>
							<input style="margin-top:8px;" type="password" name="password"><br>
							<center>
								<input style="text-align:center;margin-top:16px;width:64px;height:24px;" type="submit" name="ln" value="Login">
								<a href="/auth/register/"><input style="text-align:center;width:64px;height:24px;" type="button" value="Register"></a>
							</center>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
			include('../site/footer.php');
		?>
	</body>
</html>