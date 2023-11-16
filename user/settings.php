<?php 
include('../site/header.php');
$error = array();
if(!$loggedIn) {header("Location: ../"); die();}

//update desc

	$userID = $userRow->{'id'};
	
	if(isset($_POST['newBirth'])) {
		$birth_year = mysqli_real_escape_string($conn,intval($_POST['year']));
		$birth_month = mysqli_real_escape_string($conn,intval($_POST['month']));
		if (date('Y')-$birth_year >= 1 && date('Y')-$birth_year <= 124) {
			$birth_date = $birth_year."-".$birth_month."-01";
			$updateDescSQL = "UPDATE `beta_users` SET `birth` = '$birth_date' WHERE `id` = '$userID'";
			$updateDesc = $conn->query($updateDescSQL);
			header("Location: index");
		} else {
			$error[] = "You must be between 1 and 124 years old to play plutonium.";
		}
	}
	
	if (isset($_POST['desc'])) {
	$newDesc = mysqli_real_escape_string($conn,$_POST['desc']);
	$userID = $userRow->{'id'};
	$updateDescSQL = "UPDATE `beta_users` SET `description` = '$newDesc' WHERE `id` = '$userID'";
	$updateDesc = $conn->query($updateDescSQL);	
	}



//i am lazy to comment that, but the thing down here actually changes your username

	if (isset($_POST['username'])) {
	$username = str_replace(PHP_EOL, '', mysqli_real_escape_string($conn,$_POST['username']));
    if(substr($username,-1) == " " || substr($username,0,1) == " ") {$error[] = "You cannot include a space at the beginning or end of your username.";}
    
    //If their username is less than 3 characters or not alnum
    $alnumUsername = str_replace(array('-','_','.',' '), '', $username);
    
    if(strlen($username) < 3 || strlen($username) > 26 || $username != ctype_alnum($alnumUsername)) {
      $error[] = 'Username must be 3-26 betanumeric characters (including [ , ., -, _]).';
    }
    
    if(strpos($username, '  ') !== false || strpos($username, '..') !== false || strpos($username, '--') !== false || strpos($username, '__') !== false) {
      $error[] = 'Spaces, periods, hyphens and underscores must be separated.';
    }

if(empty($error)) {
	$userID = $userRow->{'id'};
	$updateUserSQL = "UPDATE `beta_users` SET `username` = '$username', `usernameL` = '$username' WHERE `id` = '$userID'";
	$updateUser = $conn->query($updateUserSQL);}	
	}

if (isset($_POST['fsig'])) {
	$fsig = str_replace(PHP_EOL, '', mysqli_real_escape_string($conn,$_POST['fsig']));
    

    $alnumfsig = str_replace(array('-','_','.',' ','1','2','3','4','5','6','7','8','9','0','*'), '', $fsig);
    
    if(strlen($fsig) > 60) {
      $error[] = 'Too many characters. Maximum letters for the forum signature are 60.';
    }

    if($fsig != ctype_alnum($alnumfsig)) {
      $error[] = 'fun fact, you should not have brackets in your forum signature, use stars instead';
    }
    


if(empty($error)) {
	$userID = $userRow->{'id'};
	$updateUserSQL = "INSERT INTO `test`(`id`,`crap`,`uid`,`l_upd`) VALUES (NULL, '$fsig','$userID',CURRENT_TIMESTAMP)";
	$updateUser = $conn->query($updateUserSQL);}	
	}


if (isset($_POST['tfs'])) {
$userID = $userRow->{'id'};
$tfs = "TRUNCATE `test` WHERE `uid` = '$userID'";
$ok = $conn->query($tfs);
}

	//old theme table update
	if (isset($_POST['oldtheme'])) {
	$userID = $userRow->{'id'};
	$updateOldThemeSQL = "UPDATE `themes` SET `old-theme` = 'yes' WHERE `id` = '$userID'";
	$updateOldTheme = $conn->query($updateOldThemeSQL);	
	}

	if(isset($_POST['changePass'])) {
		
		$curPass = $_POST['curPass'];
		
		$newP1 = $_POST['newPass'];
		$newP2 = $_POST['newPassConfirm'];
		
		if (password_verify($curPass, $userRow->{'password'}) && $newP1 == $newP2) {
			
			$newPass = password_hash($_POST['newPass'], PASSWORD_BCRYPT);
			
			$changePassSQL = "UPDATE `beta_users` SET `password` = '".$newPass."' WHERE `id` = '".$_SESSION['id']."'";
			$changePass = $conn->query($changePassSQL);
			
			if ($changePass) {
				header("Location: ?msg=pc");
			} else {
				header("Location: ?msg=ue");
			}
			
		} else {
			
			header('Location: ?msg=ip');  
			die();
			
		}
		
	}
	
	if(isset($_POST['changeTheme'])) {
		
		$theme = $_POST['theme'];
		
		if ($theme != 0) {
			if (!intval($theme) || $theme < -1 || $theme > 5) {
				die("Invalid Theme");
			}
		}
		$theme = mysqli_real_escape_string($conn , $theme); // just incase check fails
		
		$changeThemeSQL = "UPDATE `beta_users` SET `theme` = '$theme' WHERE `id` = '" . $_SESSION['id'] . "'";
		$changeThemeQuery = $conn->query($changeThemeSQL);
		
		if($changeThemeQuery) {
			header("Location: /user/settings/");
			die();
		}
		
	}
	
	if(isset($_POST['sendEmail'])) {
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailSQL = "INSERT INTO `emails` (`id`, `user_id`, `email`, `verified`, `date`) VALUES (NULL, '$userID', '$email', 'no', CURRENT_TIMESTAMP)";
			$emailQ = $conn->query($emailSQL);
		}
		header("Location: index");
	}
	
?>
<style>
#settingsInfo, #settingsTheme, #settingsBlurb, #changePassword {
	padding: 10px;
}

#changePassword input[type='password'] {
	margin-top:5px;
	width:100%;
}

#changePassword input[type='submit'] { 
	margin-top:5px;
}

#settingsUpperThird {
font-size: 14px;
margin-top: -10px;
}
</style>
<!DOCTYPE html>
	<head>
		<title>Settings - plutonium</title>
	</head>
	<body>
		<div id="body">
        <?php
          if(!empty($error)) {
            echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
            foreach($error as $line) {
              echo $line.'<br>';
            }
            echo '</div>';
          }
        ?>
		<div id="column" style="width:430px; float:left;">
			<div id="box" style="width:100%;">
				<center><div id="subsect">
					<h4 style="padding-left:10px;">Settings</h4>
				</div>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Account Information</h6>
					<span style="font-weight:bold;">Username: </span><span><?php echo $userRow->{'username'}; ?></span>
					<br>
					<span style="font-weight:bold;">Email:</span> <span><?php 
					$emailSQL = "SELECT * FROM `emails` WHERE `user_id` = '$userID' ORDER BY `id` DESC";
					$emailQ = $conn->query($emailSQL);
					if($emailQ->num_rows > 0) {
						$emailRow = $emailQ->fetch_assoc();
						$email = $emailRow['email'];
						$email = $email[0].$email[1].preg_replace('/[^@]+@([^\s]+)/', '***@$1', $email);
						echo $email; 
					} else {
						echo '<em>You have no email</em>';
					}
					
					?></span>
					<br>
					<span style="font-weight:bold;">Date of Birth: </span><span><?php echo date('d/m/Y',strtotime($userRow->{'birth'})); ?></span><br>

					
				</div>
<hr>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Change Password</h6>
					<form action="" method="POST">
						<input style="margin-bottom:4px;" name="curPass" type="password" placeholder="Current password"><br>
						<input style="margin-bottom:4px;" name="newPass" type="password" placeholder="New password"><br>
						<input style="margin-bottom:4px;" name="newPassConfirm" type="password" placeholder="Confirm new password">
						<br>
						<input type="submit" name="changePass">
					</form>
				</div>

				<hr>
				<div id="settingsInfo">
				<h6 id="settingsUpperThird">Themes</h6>
			<form action="" method="POST">
                      <input id="default" type="radio" name="theme" value="0" checked>
                      <label for="default">Light Theme</label></input>

 		      <input id="default" type="radio" name="theme" value="2" unchecked>
                      <label for="default">Dark (Night) Theme</label></input>
<br>
                      <input type="submit" value="Save" name="changeTheme"></input>	
				</form>
				</div>
			<hr>
<div id="settingsInfo">
					<form action="" method="POST">
						<span style="font-weight:bold;">Birthday: </span><br><br>
						<select name="year">
						<?php for($y = 1; $y <= 124; $y += 1) {echo '<option value="'.(date('Y')-$y).'">'.(date('Y')-$y).'</option>';} ?>
						</select>
						<select style="margin-left:5px;" name="month">
						<?php
						for($m = 1; $m <= 12; $m += 1) {
						$date   = DateTime::createFromFormat('!m', $m);
						$name = $date->format('F');
						echo '<option value="'.$m.'">'.$name.'</option>';} ?>
						</select><br>
						<input style="margin-top:5px;" type="submit" name="newBirth" value="Send">
					</form>
				</div>		
			</div>
</div>

<div id="column" style="width:430px; float:right;">
<div id="box" width:100%;>
<div id="settingsInfo">
					<center><span style="font-weight:bold;">Blurb (Description): </span><br><br>
					<form action="" method="POST">
						<textarea name="desc" style="width: 97.3%;height:120px;resize: none;font-size: 16px;"<?php
						echo 'placeholder="Hi, my name is ' . $userRow->{'username'} . '">' . $userRow->{'description'} . '</textarea>';
						?>
						<br>
						<input type="submit">
					</form>
<hr>
<h5>Change Username</h5>
<form action="" method="POST"><textarea name="username" style="width: 50%;height:20px;resize: none;font-size: 16px;"></textarea><br>
<input type="submit"></form>
<hr>
<center><span style="font-weight:bold;">forum signature: </span><br>	
					<form action="" method="POST">
						<textarea name="fsig" style="width: 75%;height:60px;resize: none;font-size: 16px;"></textarea>
						<br>
						<input type="submit"> <input type="submit" name="tfs" value="Delete Forum Signature">
					</form>


				</div>
				<hr>
				<div id="settingsInfo">
					<center><h6 id="settingsUpperThird">Change Email</h6>
					<form action="" method="POST">
						<span style="font-weight:bold;">Email: </span><br>
						<input style="margin:4px 0px 4px 0px;" name="email" type="text" placeholder="New email"
						<?php
						if($emailQ->num_rows > 0) {
						echo 'value="'.$email.'"';
						}
						?>
						><br>
						<input type="submit" name="sendEmail" value="Send">
						<input style="background-color: #03c303" type="submit" name="verifyEmail" value="Verify">
					</form>
				</div>
</div></center>

		</div></div>
		<?php
		include("../site/footer.php");
		?>
	</body>
</html>