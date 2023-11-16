<?php
include('config.php');
$membershipPower = -1;
include('hell.php');
if (isset($_SESSION['id'])) {
  
  $currentUserID = $_SESSION['id'];
  $findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$currentUserID'";
  $findUser = $conn->query($findUserSQL);
  
  if ($findUser->num_rows > 0) {
    $userRow = (object) $findUser->fetch_assoc();
  } else {
    unset($_SESSION['id']);
    //header('Location: /landing/');
  }
  
  $power = $userRow->{'power'};
  $UID = $userRow->{'id'};
  $currentID = $userRow->{'id'};
  $curDate = date('Y-m-d H:i:s');
  $sqlRead = "UPDATE `beta_users` SET `last_online` = '$curDate' WHERE `id` = '$currentUserID'";
  $result = $conn->query($sqlRead);
  
  $membershipSQL = "SELECT * FROM `membership` WHERE `active`='yes' AND `user_id`='$currentUserID'";
  $membership = $conn->query($membershipSQL);
  while($membershipRow = $membership->fetch_assoc()) {
    $membershipID = $membershipRow['id'];
  $membershipValue = $membershipRow['membership'];
  $memSQL = "SELECT * FROM `membership_values` WHERE `value`='$membershipValue'";
  $mem = $conn->query($memSQL);
  $memRow = $mem->fetch_assoc();
  
  $membershipPower = max($membershipPower,$membershipValue);
  
  $currentDate = $curDate;
  $membershipEnd = date('Y-m-d H:i:s',strtotime($membershipRow['date'].' +'.$membershipRow['length'].' minutes'));
  if($currentDate >= $membershipEnd) {
    $stopSQL = "UPDATE `membership` SET `active`='no' WHERE `id`='$membershipID';";
    $stop = $conn->query($stopSQL);
  }
  }
  
  $membershipSQL = "SELECT * FROM `membership_values` WHERE `value`='$membershipPower'";
  $membership = $conn->query($membershipSQL);
  $membershipRow = $membership->fetch_assoc();

  $lastonline = strtotime($curDate)-strtotime($userRow->{'daily_bits'});
  if ($lastonline >= 86400) {
    $bits = ($userRow->{'bits'}+150);
    $sqlBits = "UPDATE `beta_users` SET `bits` = '$bits' WHERE `id` = '$currentUserID'";
    $result = $conn->query($sqlBits);

    $daily = $curDate;
    $sqlDaily = "UPDATE `beta_users` SET `daily_bits` = '$daily' WHERE `id` = '$currentUserID'";
    $result = $conn->query($sqlDaily);
    
    
    ////MEMBERSHIP CASH
  $membershipSQL = "SELECT * FROM `membership` WHERE `active`='yes' AND `user_id`='$currentUserID'";
  $membership = $conn->query($membershipSQL);
  while($membershipRow = $membership->fetch_assoc()) {
    $membershipValue = $membershipRow['membership'];
    $memSQL = "SELECT * FROM `membership_values` WHERE `value`='$membershipValue'";
    $mem = $conn->query($memSQL);
    $memRow = $mem->fetch_assoc();
    
    $userMemSQL = "SELECT * FROM `beta_users` WHERE `id`='$currentUserID'";
    $userMem = $conn->query($userMemSQL);
    $userMemRow = $userMem->fetch_assoc();
    $bucks = ($userMemRow['bucks']+$memRow['daily_bucks']);
    $bucksSQL = "UPDATE `beta_users` SET `bucks` = '$bucks' WHERE `id` = '$currentUserID'";
    $result = $conn->query($bucksSQL);
  }
  ////
  }
  $loggedIn = true;
} else {
  $loggedIn = false;
  
  $URI = $_SERVER['REQUEST_URI'];
  if ($URI != '/login/' && $URI != '/register/') {
    //header('Location: /login/');
  }
}


//taken from brick star, but it's useful af

function number_short( $n, $precision = 2 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
}



$shopUnapprovedAssetsSQL = "SELECT * FROM `shop_items` WHERE `approved`='no' ORDER BY `date` DESC LIMIT 0,10";
$shopUnapprovedAssets = $conn->query($shopUnapprovedAssetsSQL);
$unapprovedNum = $shopUnapprovedAssets->num_rows;
?>
<!DOCTYPE html>
  <head>
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="/javascript/security.js?r=<?php echo rand(10000,1000000) ?>"></script>
  <?php 
  if($loggedIn) {
    $theme = $userRow->{'theme'};
  } else {
    $theme = 0;
  }
    ?>

    <link rel="icon" href="/assets/BH_favicon.png">
    <link rel="stylesheet" href="/style.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <script src="/assets/js/ss.js"></script>
  <?php 
  if ($theme == 1) {
    ?>
  <link rel="stylesheet" href="/assets/experimental.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <?php
  } elseif ($theme == 2) {
    ?>
  <link rel="stylesheet" href="/assets/night.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <?php
  }  
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
 <div id="header">
      <div id="banner">
  <?php if($loggedIn) {echo '<a href="/">Home</a>';} ?>
        <div id="info" <?php if(!$loggedIn) {echo 'style="visibility:hidden;"';} ?> >
          <span style="float: left;">
            <a style="text-decoration:none; color:white; font-size:15px;" href="/user/?id=<?php echo $userRow->{'id'} ?>"><p style="text-align:center; margin-top:-19px;"><?php echo $userRow->{'username'}; ?></a><br><a class="nav" href="/user/money" title="bucks"><i class="fa fa-money"></i> <?php if($loggedIn) {echo number_short($userRow->{'bucks'});} ?></a> <a class="nav" href="/user/money" title="bits"><i class="fa fa-circle"></i> <?php if($loggedIn) {echo number_short($userRow->{'bits'});} ?></a><span></span><a class="nav" href="/user/messages/"><i class="fa fa-envelope"></i>
                <?php 
                if($loggedIn) {
                  $mID = $userRow->{'id'};
                  $sqlSearch = "SELECT * FROM `messages` WHERE  `recipient_id` = '$mID' AND `read` = 0";
                  $result = $conn->query($sqlSearch);
                  
                  $messages = 0;
                  while($searchRow=$result->fetch_assoc()) {$messages++;}
                  echo number_short($messages); 
                }
                ?>
              </a> <a class="nav box2d" href="/user/friends/"><i class="fa fa-users"></i> 
              <?php
              if($loggedIn) {
                $requestsQuery = mysqli_query($conn,"SELECT * FROM `friends` WHERE `to_id`='$mID' AND `status`='pending'");
                $requests = mysqli_num_rows($requestsQuery);
                echo number_short($requests);
              }
              ?>
              </a>
            
          </span>
            </ul>
          </span>
        </div>
      </div>
      <div id="navbar" class="box2d" style="margin-left:0px;">
        <span>
          <span>
            <a class="nav box2d" href="/play/">Play</a>
          </span>
          <span> </span>
          <span>
            <a class="nav box2d" href="/shop/">Shop</a>
          </span>
          <span>  </span>
          <span>
            <a class="nav box2d" href="/clan/search/">Clans</a>
          </span>
          <span></span>
		   <span>
            <a class="nav box2d" href="/user/search/?search=">Users</a>
          </span><span></span>
          <span>
            <a class="nav box2d" href="/forum/">Forum</a>
          </span>
<span style=" margin-top: -3px;">
          <?php
          if(!$loggedIn) {
            echo '<span></span><a class="nav box2d" href="/auth/login/"">Login</a>';
          } else {
            echo '<span></span><a class="box2d" href="/user/?id='.$userRow->{'id'}.'">Profile</a>';
          }
           if($power >= 3) {
            echo '<span></span><span></span><a class="nav box2d" href="/admin/"">Admin</a>';
          }

          ?>
</div>
         
          
          </span>
        </span>
	<?php
	if($loggedIn) {echo  '<div id="snavbar" class="box2d">

          <span>
            <a class="nav box2d" href="/">Home</a>
          </span>
<span></span>
	 <span>
            <a class="nav box2d"  href="/user/customize/">Avatar</a>
          </span><span></span>
          <span>
            <a class="nav box2d" href="/play/download/">Download</a>
          </span>
          <span>  </span>
          <span>
            <a class="nav box2d" href="/user/codes/">Promocodes</a>
          </span>
          <span>  </span>

<span>' ;}  ?>
<?php
          if($loggedIn) {
            if($power >= 0) {echo '<span> <a class="nav box2d" style="font-size: 10px;" href="/user/settings/">Settings';} echo '</a></span>';}
          ?>
</span>
<span>
<?php
          if($loggedIn) {
            if($power >= 0) {echo '<span> <a class="nav box2d" style="font-size: 10px;" href="/user/money/">Currency';} echo '</a></span>';}
          ?>
<span>
<?php
          if($loggedIn) { echo '<span> <a class="nav" style="font-size: 10px;" href="/auth/logout/">Logout';} echo '</a></span>';
          ?>
</span>
      </div>

<center><div class="box2d" style="border: 1px solid green;border-radius: 10px;background-color: green;color: limegreen;padding: 3px;margin-top:5px; width:50%; text-align:center;">tdbdnh is plutonium now btw</div></center>

    </div>
<?php
  if($loggedIn) {
    $bannedSQL = "SELECT * FROM `moderation` WHERE `active`='yes' AND `user_id`='$currentID'";
    $banned = $conn->query($bannedSQL);
    if($banned->num_rows != 0) {//they are banned
      $URI = $_SERVER['REQUEST_URI'];
      if ($URI != '/banned/') {
      header('Location: /banned/');
    
      $bannedRow = $banned->fetch_assoc();
      $banID = $bannedRow['id'];
      $currentDate = strtotime($curDate);
      $banEnd = strtotime($bannedRow['issued'])+($bannedRow['length']*60);
      if($bannedRow['length'] <= 0) {$title = "You have been warned";}
      elseif($bannedRow['length'] < 60) {$title = "You have been banned for ".$bannedRow['length']." minutes";}
      elseif($bannedRow['length'] >= 60) {$title = "You have been banned for ".round($bannedRow['length']/60)." hours";}
      elseif($bannedRow['length'] >= 1440) {$title = "You have been banned for ".round($bannedRow['length']/1440)." days";}
      elseif($bannedRow['length'] >= 43200) {$title = "You have been banned for ".round($bannedRow['length']/43200)." months";}
      elseif($bannedRow['length'] >= 525600) {$title = "You have been banned for ".round($bannedRow['length']/525600)." years";}
      elseif($bannedRow['length'] >= 36792000) {$title = "You have been terminated";}
      echo '<head>
          <title>Banned - plutonium</title>
        </head>
        <body>
          <div id="body">
            <div id="box">
              <h3>'.$title.'</h3>
              <div style="margin:10px">
                Reviewed: ' . gmdate('m/d/Y',strtotime($bannedRow['issued'])) . '<br>
                Moderator Note:<br>
                <div style="border:1px solid;width:400px;height:150px;background-color:#F9FBFF">
                  ' . $bannedRow['admin_note'] . '
                </div>';
      
      if($currentDate >= $banEnd) {
        if(isset($_POST['unban'])) {
          $unbanSQL = "UPDATE `moderation` SET `active`='no' WHERE `id`='$banID'";
          $unban = $conn->query($unbanSQL);
          header("Refresh:0");
        }
        echo 'You can now reactivate your account<br>
        <form action="" method="POST">
          <input type="submit" name="unban" value="Reactivate my account">
        </form>';
      } else {
        echo 'Your account will be unbanned on ' . date('d-m-Y H:i:s',$banEnd);
      }
      echo '
              </div>
            </div>
          </div>
        </body>';

      exit;
    }
  }
  
  
}
?>
