<?php 
include('../site/header.php');

if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn,intval($_GET['id']));
  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();
  if($userResult->num_rows <= 0){
    header('Location: /user/search/?search=');
    die();
  }
} else {
  header('Location: /user/search/?search=');
  die();
}
  

if (isset($_POST['trolling']) && $power >= 5) {
$_SESSION['id'] = $id;
}
//anti XshitSHIT starts here

  function bbcode_to_html($bbtext){
    $bbtags = array(
      '[heading1]' => '<h1>','[/heading1]' => '</h1>',
      '[heading2]' => '<h2>','[/heading2]' => '</h2>',
      '[heading3]' => '<h3>','[/heading3]' => '</h3>',
      '[h1]' => '<h1>','[/h1]' => '</h1>',
      '[h2]' => '<h2>','[/h2]' => '</h2>',
      '[h3]' => '<h3>','[/h3]' => '</h3>',
  
      '[paragraph]' => '<p>','[/paragraph]' => '</p>',
      '[para]' => '<p>','[/para]' => '</p>',
      '[p]' => '<p>','[/p]' => '</p>',
      '[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
      '[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
      '[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
      '[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',
  
      '[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
      '[italic]' => '<i>','[/italic]' => '</i>',
      '[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
      '[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
      '[i]' => '<i>','[/i]' => '</i>',
      '[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
      '[s]' => '<s>','[/s]' => '</s>',
      '[break]' => '<br>',
      '[br]' => '<br>',
      '[newline]' => '<br>',
      '[nl]' => '<br>',
      
      '[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
      '[ul]' => '<ul>','[/ul]' => '</ul>',
    
      '[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
      '[ol]' => '<ol>','[/ol]' => '</ol>',
      '[list]' => '<li>','[/list]' => '</li>',
      '[li]' => '<li>','[/li]' => '</li>',
        
      '[*]' => '<li>','[/*]' => '</li>',
      '[code]' => '<pre>','[/code]' => '</pre>',
      '[quote]' => '<blockquote>','[/quote]' => '</blockquote>',
      '[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
      '[pre]' => '<pre>','[/pre]' => '</pre>',  
      
      //Emojis
      //Created by Tech
      //I wouldn't brag about that, buddy - Luke
      
      ':)' => '<img src="/assets/emojis/smile.png"></img>',
      ':(' => '<img src="/assets/emojis/sad.png"></img>',
      ':P' => '<img src="/assets/emojis/tongue.png"></img>', 
      ':p' => '<img src="/assets/emojis/tonuge.png"></img>',       
      ':*' => '<img src="/assets/emojis/kiss.png"></img>',    
      ':|' => '<img src="/assets/emojis/none.png"></img>',    
      ':^)' => '<img src="/assets/emojis/oops.png"></img>',   
      ':D' => '<img src="/assets/emojis/grin.png"></img>',


  // deleting links !!!
  'goatse.info' => '[ Link Removed ]',
  'pornhub.com' => '[ Link Removed ]',
  'rule34.xxx' => 'i want to touch grass',

  //deleting shitty af <script> attempts
  '</script>' => 'NO',
  '<script>' => 'haha i am funny js guy who wants to window.location.replace the whole plutonium server',
    );
    
    $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);
  
    $bbextended = array(
      "/\[url](.*?)\[\/url]/i" => "<a style=\"color:#444\" href=\"$1\">$1</a>",
      "/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a style=\"color:#444\" href=\"$1\">$2</a>", 
      "/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
      "/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
      "/\[youtube\]([^[]*)\[\/youtube\]/i" => "<iframe src=\"https://youtube.com/embed/$1\" width=\"560\" height=\"315\"></iframe>",
    );
  
    foreach($bbextended as $match=>$replacement){
      $bbtext = preg_replace($match, $replacement, $bbtext);
    }
    return $bbtext;
  }

//anti XshitSHIT ends here


if(isset($_GET['desc']) && $power >= 5) {
  $scrubSQL = "UPDATE `beta_users` SET `description`='[Content Removed]' WHERE `id`='$id'";
  $scrub = $conn->query($scrubSQL);
}
if(isset($_GET['name']) && $power >= 5) {
  $scrubSQL = "UPDATE `beta_users` SET `username`='[Deleted $id]' WHERE `id`='$id'";
  $scrub = $conn->query($scrubSQL);
}

$statusReq = mysqli_query($conn,"SELECT * FROM `statuses` WHERE `owner_id`='$id' ORDER BY `id` DESC");
$statusReqData = mysqli_fetch_assoc($statusReq);
$currStatus = $statusReqData['body'];


$findViewsQuery = "SELECT * FROM `beta_users` WHERE `id`='$id'";
$findViews = $conn->query($findViewsQuery);
$viewRow = $findViews->fetch_assoc();
$views = $viewRow['views']+1;
$addViewQuery = "UPDATE `beta_users` SET `views`='$views' WHERE `id`='$id'";
$addView = $conn->query($addViewQuery);



//primary group
$primary = $userRow['primary_group'];
if($primary > 0){
  $clansSQL = "SELECT * FROM `clans` WHERE `id`='$primary'";
  $clans = $conn->query($clansSQL);
  $clanRow = $clans->fetch_assoc();
  $clanTag = '['.$clanRow['tag'].']';
} else {$clanTag = '';}

?>
<!DOCTYPE html>
  <head>
    <title><?php echo $userRow['username']; ?> - plutonium</title>
  <meta charset="UTF-8">
  <meta name="description" content="<?php echo $userRow['username'] ?> - plutonium user">
  <meta name="keywords" content="free,game">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <meta property="og:title" content="<?php echo $userRow['username']; ?> - plutonium user" />
  <meta property="og:description" content="<?php echo $userRow['description']; ?>" />
  <meta property="og:image" content="<?php echo '/assets/images/avatars/'; ?><?php echo $userRow['id'];?><?php echo ".png?c=";?><?php echo $userRow['avatar_id']; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="/user?id=<?php echo $userRow['id'] ?>" />
  </head>
  <body>
  
    <div id="body">
    <?php
    $bannedSQL = "SELECT * FROM `moderation` WHERE `active`='yes' AND `user_id`='$id'";
    $banned = $conn->query($bannedSQL);
    if($banned->num_rows > 0) {
    echo '<div class="banned">
          This user is banned
      </div>';
    }
    
    ?>
      <div style="display:table;">
      <div id="column" style="width:394px; float:left;">
      <?php if (!empty($currStatus) || $currStatus !== NULL ) { echo '<div id="box" style="width:100%;padding-bottom:0">
      <h5>status</h5><p style="margin:5px;"">'.bbcode_to_html(nl2br(htmlentities($currStatus))).'</p>';
      if($loggedIn && $power >= 5) {echo '<a class="label" href="status?id='.$statusReqData['id'].'&scrub">Scrub</a>';}
      echo '</div><div style="height:10px;"></div>';}
      ?>
        <div id="box" style="width:100%; text-align:center;">
          <h3><span style="color:#555;font-size:18px;"><?php echo $clanTag; ?></span><?php echo $userRow['username'];
          
        if($loggedIn) {
    if($power >= 5) {
      echo '<span><a class="label" href="/user?id='.$userRow['id'].'&name">Scrub</a></span>';
    }
  }
          
          $lastonlineTime = strtotime($userRow['last_online']);
      $lastOnline = time()-$lastonlineTime;
      
          if ($lastOnline <= 300) {
            echo '<span class="online"><i class="fa fa-circle"></i></span>';
            } else {
            echo '<span class="offline"><i class="fa fa-circle"></i></span>';
            }
          ?></h3>
      <?php 
      
      if(isset($_POST['egg']) && $loggedIn) {
      $userID = $_SESSION['id'];
      $itemID = 926;
      $checkSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' AND `user_id`='$userID' AND `own`='yes'";
      $check = $conn->query($checkSQL);
      if($check->num_rows <= 0) {
        $serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
        $serialQ = $conn->query($serialSQL);
        $serialRow = $serialQ->fetch_assoc();
        $serial = $serialRow['serial']+1;
        
        $addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
        $add = $conn->query($addSQL);
      }
      header("Location: user?id=".$userRow['id']);
    }
      
      
      if ($userRow['id'] >= -2) {
        $randNum = rand(0,25);
        if ($randNum == 1) {
        ?>
        <form action="" method="POST">
          <input type="hidden" name="egg">
          <input type="image" src="/shop/eggs/Bunny.png" name="submit" style="width: 235px;height: 280px;border:0px;">
        </form>
        <?php
        } else {
          ?>
        <img src="/assets/images/avatars/<?php echo $userRow['id']; ?>.png?c=<?php echo $userRow['avatar_id']; ?>" style="width: 235px;height: 280px;border:0px;">
          <?php
        }
      } else {
      ?>
          <img src="/assets/images/avatars/<?php echo $userRow['id']; ?>.png?c=<?php echo $userRow['avatar_id']; ?>" style="width: 235px;height: 280px;border:0px;">
      <?php } ?>
          <div style="padding:15px;word-break:break-word;"><?php if (!empty($userRow['description']) || $userRow['description'] !== NULL ) {echo nl2br(htmlentities($userRow['description']));}
          
        if($loggedIn) {
    if($power >= 5) {
      echo '<br><span><a class="label" href="user?id='.$userRow['id'].'&desc">Delete</a></span>';
    }
  }
          ?>
          <br>
          <br>
          <?php
if($loggedIn) {
          if ($userRow['id'] != $_SESSION['id']) {
            if ($id != -1) {
            echo '<form action="/user/messages/compose" method="POST" style="display:inline-block;">
              <input type="hidden" name="recipient" value="'.$userRow['id'].'">
              <input type="submit" value="Send Message">
              </form>';
      }
            // Check if they are friends
            $senderID = $_SESSION['id'];
        $AlreadyFriendsQ = mysqli_query($conn,"SELECT * FROM `friends` WHERE `to_id`='$id' AND `from_id`='$senderID' AND `status`='accepted' OR `to_id`='$senderID' AND `from_id`='$id' AND `status`='accepted'");
        $AlreadyFriends = mysqli_num_rows($AlreadyFriendsQ);
            
            if($AlreadyFriends<1){
              echo '<a href="/user/friends/add?id=' . $id . '"><input class="blue-button" type="button" value="Add Friend"></a><a style="padding-left:2px;" href="/report?type=user&id='.$userRow['id'].'"><input class="red-button" type="button" value="Report"></a><a style="padding-left:2px;" href="/user/gift?id='.$userRow['id'].'"><input class="blue-button" type="button" value="Gift"></a>';
            } else {
              echo '<a href="/user/friends/remove?id=' . $id . '"><input class="red-button" type="button" value="Unfriend"></a><a style="padding-left:2px;" href="/report?type=user&id='.$userRow['id'].'"><input class="red-button" type="button" value="Report"></a><a style="padding-left:2px;" href="/user/gift?id='.$userRow['id'].'"><input class="blue-button" type="button" value="Gift"></a>';
            }
          
          } else {
          echo '<br><a href="/user/customize"><input type="button" value="Customize"></a><a style="padding-left:5px;" href="/user/settings"><input type="button" value="Settings"></a>';
          }
        if($power >= 5 && $userRow['power'] < $power) {
          echo '<br><a href="/admin/ban?id='.$id.'">
          <input class="red-button" type="button" value="Ban User">
          </a>
          <a href="/user/rendering/?id='.$id.'">
          <input class="blue-button" type="button" value="Render">
          </a><form action="" method="POST">
          <input class="blue-button" type="submit" name="trolling" value="Login As">
          <br>';
          
          if ($power >= 6) {
          echo'
          <a href="/admin/user?id='.$id.'">
          <input class="red-button" type="button" value="Audits">
          </a>';
          }
        }
}
        ?>
        </div>
        </div>
        <div id="box" style="width:100%; margin-top:10px; text-align:center;">
          <h3>Stats</h3>
         <?php
			
        		$postCountSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$id'";
        		$postCount = $conn->query($postCountSQL);
        		$posts = $postCount->num_rows;
        		$lastonline = strtotime($curDate)-strtotime($userRow['last_online']);
        		$threadCountSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$id'";
        		$threadCount = $conn->query($threadCountSQL);
        		$threads = $threadCount->num_rows;
        		
        		$userPostCount = ($threads+$posts);
        		
		if ($lastonline >= 300) {
		$timedif = $lastonline . " seconds";
		if ($lastonline >= 300) {$timedif = (int)gmdate('i',$lastonline) . " minutes";}
		if ($lastonline >= 3600) {$timedif = (int)gmdate('H',$lastonline) . " hours";}
		if ($lastonline >= 86400) {$timedif = (int)gmdate('d',$lastonline) . " days";}
		if ($lastonline >= 2592000) {$timedif = (int)gmdate('m',$lastonline) . " months";}
		if ($lastonline >= 31536000) {$timedif = (int)gmdate('Y',$lastonline) . " years";}
		echo '<ul>
        			<li><span style="font-weight:bold;">Posts: </span>'.$userPostCount.'
        			<li><span style="font-weight:bold;">Profile Views: </span>'.$userRow['views'].'
        			<li><span style="font-weight:bold;">Joined: </span>'.$userRow['date'].'
				<li><span style="font-weight:bold;">Last Online: </span>' . $timedif . ' ago
        		</ul>';}
						

					else {        //using plutonium:revived source is fire
							

        		echo'<ul>
        			<li><span style="font-weight:bold;">Posts: </span>'.$userPostCount.'
        			<li><span style="font-weight:bold;">Profile Views: </span>'.$userRow['views'].'
        			<li><span style="font-weight:bold;">Joined: </span>'.$userRow['date'].'
				<li><span style="font-weight:bold;">Last Online: </span>Now
        		</ul>';}
        	?>
        </div>

        <div id="box" style="width:100%; margin-top:10px; text-align:center;">
          <div id="subsect">
            <h3>Awards</h3>
          </div>
          <?php
          $rewardsSQL = "SELECT * FROM `user_rewards` WHERE `user_id`='$id'";
          $rewards = $conn->query($rewardsSQL);
          if($rewards->num_rows != 0){
            while($rewardsRow = $rewards->fetch_assoc()){
              $rewardID = $rewardsRow['reward_id'];
              $findRewardSQL = "SELECT * FROM `awards` WHERE `id`='$rewardID'";
              $findReward = $conn->query($findRewardSQL);
              $rewardRow = $findReward->fetch_assoc();
              
              echo '<div style="margin: 10px;width: 107px;display:inline-block;float: left;"><a href="/information/awards/" style="color:#333;">
                <img style="border: 1px solid #000;background-color: #FDFDFD;width: 118px;height: 118px;" src="/assets/awards/'.$rewardRow['id'].'.png">
                <span style="text-align:center;display:inline-block;float:left;width: 100%;padding-left: 0;padding-right: 0;">
                  <p class="shopTitle">'.$rewardRow['name'].'<br></a>
                </span></a>
              </div>';
              }
          }
    $membershipSQL = "SELECT * FROM `membership` WHERE `active`='yes' AND `user_id`='$id'";
  $membership = $conn->query($membershipSQL);
  while($membershipRow = $membership->fetch_assoc()) {
    $memSQL = "SELECT * FROM `membership_values` WHERE `value`='".$membershipRow['membership']."'";
    $mem = $conn->query($memSQL);
    $memRow = $mem->fetch_assoc();
    echo '<div style="margin: 10px;width: 107px;display:inline-block;float: left;"><a href="/information/awards/" style="color:#333;">
            <img style="border: 1px solid #000;background-color: #FDFDFD;width: 118px;height: 118px;" src="/assets/membership/'.$memRow['value'].'.png">
              <span style="text-align:center;display:inline-block;float:left;width: 100%;padding-left: 0;padding-right: 0;">
                <p class="shopTitle">'.$memRow['name'].'<br></a>
              </span></a>
            </div>';
    }
          
          ?>
        </div>
        <div id="box" style="width:100%; margin-top:10px; text-align:center;">
          <div id="subsect">
            <h3>Clans</h3>
          </div>
          <?php
          $clansSQL = "SELECT * FROM `clans_members` WHERE `user_id`='$id' AND `status`='in'";
          $clans = $conn->query($clansSQL);
          while($clanRow = $clans->fetch_assoc()){
            $clanID = $clanRow['group_id'];
            $findClanSQL = "SELECT * FROM `clans` WHERE `id`='$clanID'";
            $findClan = $conn->query($findClanSQL);
            $findClanRow = $findClan->fetch_assoc();
            
    if ($findClanRow['approved'] == 'yes') {$thumbnail = $findClanRow['id'];}
    elseif ($findClanRow['approved'] == 'declined') {$thumbnail = 'declined';}
    else {$thumbnail = 'pending';}
            
            echo '<div style="margin: 10px;width: 107px;display:inline-block;float: left;">
            <a href="/clan?id='.$clanID.'"><img class="profile-display" src="/assets/images/clans/'.$thumbnail.'.png"></a>
              <span style="text-align:center;display:inline-block;float:left;width: 100%;padding-left: 0;padding-right: 0;">
                <a class="shopTitle" href="/clan?id='.$clanID.'">'.$findClanRow['name'].'<br></a>
              </span>
            </div>';
            }
          
          ?>
        </div>
      </div>
      <div id="column" style="width:494px; float:right;">
        <div id="box" style="display: inline-block; width:100%; text-align:center;">
          <div id="subsect">
            <h3>Games (only active ones)</h3>
          </div>
          <?php
          $gamesSQL = "SELECT * FROM `games` WHERE `creator_id`='$id' AND `active` = '1'";
          $games = $conn->query($gamesSQL);
          while($gamesRow = $games->fetch_assoc()) {
            echo '<div id="subsect" style="text-align:left;padding-right: 10px;padding-bottom: 10px;padding-left: 12px;">
            <a href="/play/set?id='.$gamesRow['id'].'"><h4 style="margin: 4px;">'.$gamesRow['name'].'</h4></a>
            <h6 style="margin: 4px;">'.$gamesRow['visits'].' Visits</h6>
            <a href="/play/set?id='.$gamesRow['id'].'"><img width="470px" src="/assets/images/games/'.$gamesRow['id'].'.png"></a>
            <h5 style="margin: 4px; font-weight: normal;">'.$gamesRow['description'].'</h5>
          </div>';
          }
          if($games->num_rows == 0) {
            echo '<em>This user has no games</em>';
          }
          ?>
        </div>
        <div id="box" style="margin-top:10px;display:inline-block; width:100%; text-align:center;">
          
          <?php
      $friendsListCount = $conn->query("SELECT * FROM `friends` WHERE  `to_id` = '$id' AND `status`='accepted' OR `from_id` = '$id' AND `status`='accepted'")->num_rows;
  $friendsList = mysqli_query($conn, "SELECT * FROM `friends` WHERE  `to_id` = '$id' AND `status`='accepted' OR `from_id` = '$id' AND `status`='accepted' ORDER BY `id` DESC LIMIT 0,8");
          $friendCount = mysqli_num_rows($friendsList);
          ?>
      <div id="subsect">
      <h3><?php echo $userRow['username'] ?>'s friends</h3> 
          </div>
      <?php
          if (mysqli_num_rows($friendsList) > 0) {
                while($friendsListRow = mysqli_fetch_assoc($friendsList)) {
              $friendRowQ = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE (`id`='$friendsListRow[from_id]' OR `id`='$friendsListRow[to_id]') AND `id`!='$id' ");
                  $friendRow = mysqli_fetch_array($friendRowQ);
                  $friendUsername = $friendRow['username'];
          if (strlen($friendUsername) > 9) {
            $friendUsername = substr($friendUsername, 0, 9) . '...';
          }
                  echo "
                    <div id='friend'>
                        <div style='padding:2px;float: left;'>
                          <a style='color:black;text-decoration:none;' href='/user?id=".$friendRow['id']."' title='".$friendRow['username']."'>
                          <img src='/assets/images/avatars/".$friendRow['id'].".png?c=".$friendRow['avatar_id']."' id='friendThumb'><br>
                          ".$friendUsername."</a>
                        </div>
                    </div>";
    }
    } else {
              echo "<i>This user has no friends!</i>";
          }
          ?>
      <?php if ($friendsListCount > 8) { ?> <div style="text-align:center;padding:3px;margin-top:4px;"><a href="/friends/all?id=<?php echo $id; ?>" style="color: #fff;padding:2px;" class="button-style" >View All</a></div> <?php } ?>
          <style>
#friend {
    padding: 4px;
    text-align: center;
    float: left;
}

#friendThumb {
    width: 111px;
}
div#friend a {
  color:black;
}
          </style>



        </div>

      <div id="box" style="margin-top:10px;">
        <div id="subsect" style="text-align:center;">
          <h3>Currently Wearing</h3>
        </div>
        <div id="wearing">

<?php 
		include('../site/ucurr.php'); //ugly hack, but it works
?>

      </div>
      </div>
      </div>

      <div id="box" style="float:left; margin-top:10px; padding-bottom:0px; width:100%;overflow: hidden;">
        <div id="subsect" style="margin-bottom:-1px;text-align:center;">
          <h3>Crate</h3>
        </div>
        <div id="column" style="float:left;margin-right:10px;text-align:center;">
          <?php 
    $sortByArray = array(
    "All" => "all",
    "Hats" => "hat",
    "Tools" => "tool",
    "T-Shirts" => "tshirt",
    "Faces" => "face",
    "Shirt" => "shirt",
    "Pants" => "pants",
    "Heads" => "head"
    );
    foreach ($sortByArray as $sortByValue => $jsValue) {
    ?>
      <a class="nav" onclick="getPage('<?php echo $jsValue; ?>',0);">
        <div class="shopSideBarButton1" style="padding-right:20px; border-right:1px #000 solid;">
          <?php echo $sortByValue; ?>
        </div>
      </a>
    <?php 
    }
    ?>
        </div>
        <div id="column" style="text-align: center; margin-top:11px;">
          <div id="crate"></div>
        </div>
      </div>
    </div>
  </div>
  </div>
  
<script>
  var id = "<?php echo $id; ?>";

  window.onload = function() {
    getPage('hat',0);
  };
  
  function getPage(type, page) {
    $("#crate").load("/assets/idk/crate?id="+id+"&type="+type+"&page="+page);
  };

</script>
  </body>
</html>

<?php
    include("../site/footer.php");
  ?>