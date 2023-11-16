<?php 
  include('../site/header.php');
  
  if($loggedIn) {header("Location: /user/dashboard/"); die();}
  
  $error = array();
  if (isset($_POST['submit'])) {
    $username = str_replace(PHP_EOL, '', mysqli_real_escape_string($conn,$_POST['username']));
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $confirmPassword = $_POST['passwordConfirm'];
    $key = mysqli_real_escape_string($conn, $_POST['key']); 
    $IP = $_SERVER['REMOTE_ADDR'];
    $curDate = date('Y-m-d');
    
    if(substr($username,-1) == " " || substr($username,0,1) == " ") {$error[] = "You cannot include a space at the beginning or end of your username.";}
    
    //If their username is less than 3 characters or not alnum
    $alnumUsername = str_replace(array('-','_','.',' '), '', $username);
    
    if(strlen($username) < 3 || strlen($username) > 26 || $username != ctype_alnum($alnumUsername)) {
      $error[] = 'Username must be 3-26 betanumeric characters (including [ , ., -, _]).';
    }
    
    if(strpos($username, '  ') !== false || strpos($username, '..') !== false || strpos($username, '--') !== false || strpos($username, '__') !== false) {
      $error[] = 'Spaces, periods, hyphens and underscores must be separated.';
    }
    //
    
    //If they have more than 5 accounts on this IP, no thank you
    $checkIPSQL = "SELECT * FROM `beta_users` WHERE `ip`='$IP'";
    $checkIP = $conn->query($checkIPSQL);
    if($checkIP->num_rows >= 50000) {
      $error[] = 'You cannot make any more accounts.';
    }
    //
    
    
    if ( $password !== $confirmPassword ) {
      $error[] = 'Passwords do not match!';
    } 
    
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email!';
    }
    
    $mailCheckSQL = "SELECT * FROM `emails` WHERE `email`='$email'";
    $mailCheck = $conn->query($mailCheckSQL);
    if($mailCheck->num_rows >= 10) {
      $error[] = 'You can only associate 10 accounts with one email. This was done to prevent namesniper guys from making the half of playerbase to be botted with alts.';
    }
    
    $birth_year = mysqli_real_escape_string($conn,intval($_POST['year']));
    $birth_month = mysqli_real_escape_string($conn,intval($_POST['month']));
    if (date('Y')-$birth_year >= 1 && date('Y')-$birth_year <= 124) {
      $birth_date = $birth_year."-".$birth_month."-01";
    } else {
      $error[] = "You must be between 1 and 124 years old to play Brick Hill.";
    }
    
    if(isset($_POST['gender'])) {$gender = mysqli_real_escape_string($conn,$_POST['gender']);} else {$gender = 'hidden';}
    if($gender != 'male' && $gender != 'female') {
      $gender = 'hidden';
    }
    
    
    
    $usernameL = strtolower(mysqli_real_escape_string($conn, $username));
    //important
		$checkUsernameSQL = "SELECT * FROM `beta_users` WHERE `beta_users`.`usernameL` = '$usernameL'";
		$checkUsername = $conn->query($checkUsernameSQL);
    
    if ($checkUsername->num_rows > 0) {
      $error[] = 'Username taken.';
    }
    
    
    $findKeySQL = "SELECT * FROM `reg_keys` WHERE `key_content` = '$key' AND `used` = 0";
      
    $findKey = $conn->query($findKeySQL);
    
    if(empty($error)) {
      if ($findKey->num_rows == 0) {
          $error[] = 'Invalid key!';
          
      } elseif($findKey->num_rows > 0) {
        
        $keyRow = $findKey->fetch_assoc();
        $keyID = $keyRow['id'];
        
        $updateKeySQL = "UPDATE `reg_keys` SET `used` = '1' WHERE `id` = '$keyID' ";
        $updateKey = $conn->query($updateKeySQL);
        
      }
    }
    
    //^ will be added after account nuking
    
    if(empty($error)) {
      
      
    
      $password = password_hash($password, PASSWORD_BCRYPT);
      $username = mysqli_real_escape_string($conn, $username);
      
      do {    $uid = bin2hex(random_bytes(20));
        $uidCheckSQL = "SELECT * FROM `beta_users` WHERE `unique_key`='$uid'";
        $uidCheck = $conn->query($uidCheckSQL);
      } while ($uidCheck->num_rows > 0);
      
      $createUserSQL = "INSERT INTO `beta_users` (`username`, `usernameL`, `password`, `IP`, `birth`, `gender`, `date`, `last_online`, `daily_bits`, `views`, `description`, `bucks`, `bits`, `power`, `unique_key`, `theme`) VALUES ('$username', '$usernameL', '$password', '$IP', '$birth_date', '$gender', now(), '$curDate', '$curDate', '0', '', '0', '1000', '0', '$uid','0');";

      
      $createUser = $conn->query($createUserSQL);
      if ($createUser) {
        $userID = $conn->insert_id;
        
        $emailSQL = "INSERT INTO `emails` (`id`, `user_id`, `email`, `verified`, `date`) VALUES (NULL, '$userID', '$email', 'yes', CURRENT_TIMESTAMP)";
        $emailQ = $conn->query($emailSQL);

        $membershipSQL = "INSERT INTO `membership` (`id`, `user_id`, `membership`, `date`, `length`, `active`) VALUES (NULL, '$userID', '1', CURRENT_TIMESTAMP, '2147483647', 'yes')";
        $membershipQ = $conn->query($membershipSQL);

        do {    $uid = bin2hex(random_bytes(20));
          $uidCheckSQL = "SELECT * FROM `beta_users` WHERE `unique_key`='$uid'";
          $uidCheck = $conn->query($uidCheckSQL);
        } while ($uidCheck->num_rows > 0);
        
        if(substr($usernameL,-1) == 's') {$title = $username."' Set";}
        else {$title = $username."'s Set";}
        
        $torsoColors = array('c60000','3292d3','85ad00','e58700');
        $legColors = array('650013','1c4399','1d6a19','76603f');
        $torso = $torsoColors[rand(0,3)];
        $leg = $legColors[rand(0,3)];
        $avatarSQL = "INSERT INTO `avatar` (`user_id`,`head_color`,`torso_color`,`right_arm_color`,`left_arm_color`,`right_leg_color`,`left_leg_color`,`face`,`shirt`,`pants`,`tshirt`,`hat1`,`hat2`,`hat3`,`hat4` ,`hat5`,`tool`,`head` ,`cache`) VALUES ('$userID',  'f3b700',  '$torso',  'f3b700',  'f3b700',  '$leg',  '$leg',  '0',  '0',  '0',  '$tshirt',  '0',  '0',  '0',  '0',  '0',  '0',  '0',  '0')";
        $avatar = $conn->query($avatarSQL);
        
        $_SESSION['id'] = $userID;
        header('Location: /user/dashboard/');
      } else {
        $error[] = 'Database error';
      }
    }
      
    
    
  }
?>
<!DOCTYPE html>
  <head>
    <title>registration page</title>
  </head>
  <body>
    <div id="body">
      <div id="box">
        <?php
          if(!empty($error)) {
            echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
            foreach($error as $line) {
              echo $line.'<br>';
            }
            echo '</div>';
          }
        ?>
        <form action="" method="POST" style="float:left;margin-left:10px;">
          <h4>Username:</h4>
          <h6>How will people recognize you?</h6>
          <input style="margin-left:5px;" type="text" name="username"><br>
          <h4 style="margin-top:10px;">Email:</h4>
          <h6>This must be valid so we can contact you!</h6>
          <input style="margin-left:5px;" type="text" name="email"><br>
          <h4 style="margin-top:10px;">Birthday:</h4>
          <h6>For your safety, please enter your date of birth.</h6>
          <select style="margin-left:5px;" name="year">
          <?php for($y = 1; $y <= 124; $y += 1) {echo '<option value="'.(date('Y')-$y).'">'.(date('Y')-$y).'</option>';} ?>
          </select>
          <select style="margin-left:5px;" name="month">
          <?php
          for($m = 1; $m <= 12; $m += 1) {
          $date   = DateTime::createFromFormat('!m', $m);
          $name = $date->format('F');
          echo '<option value="'.$m.'">'.$name.'</option>';} ?>
          </select><br>
	<div id="column">
	<div id="box" style="margin-left:250px; margin-top:-220px; border:0px;">
          <h4>Password:</h4>
          <h6>Only you will know this!</h6>
          <input style="margin-left:5px;" type="password" name="password"><br>
          <h6>Please retype your password.</h6>
          <input style="margin-left:5px;" type="password" name="passwordConfirm"><br>
 <h4 style="margin-top:10px;">invite key:</h4>
          <h6>Get this by messaging Data Hill staff, thedenbruh<br> or by getting invite key from invite key drops.</h6>
          <input style="margin-left:5px;" type="text" name="key"><br></div></div>
<br><h6 style="font-size:16px;">By signing up, you agree to the <a href="/terms/">Terms of Service</a></h6>
         <center><input style="margin:10px 0px 0px 5px;text-align:center;width:64px;height:24px;" type="submit" name="submit" value="Register"><span></span></center>
        </form>
        <div style="margin:10px;border:1px solid #000;padding:10px;background-color:#FFF;clear:right;float:right;width:300px;">
          <h4>Under 13s...</h4>
          <p>If you are under 13, i really wonder why you've supposed to come here.</p>
        </div>
        <div style="margin:10px;border:1px solid #000;padding:10px;background-color:#FFF;clear:right;float:right;width:300px;">
          <h4>Already have an account?</h4>
          if yeah, then <a href="/auth/login/">login</a>.<br>
          Can't play? Go to <a href="/download">download</a> and install the workshop to play it lol!</p>
        </div>
        <div style="margin:10px;clear:right;">
          <p style="font-size:14px;text-align:right;">Contact denbruh (DenGuy#5348) if you have any questions or queries!</p>
        </div>
      </div>
    </div>
    <?php
      include('../site/footer.php');
    ?>
  </body>
</html>