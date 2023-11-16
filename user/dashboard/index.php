<?php 
include('../../site/header.php');

if ($loggedIn) {

  $currentUserID = $_SESSION['id'];
  $findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$currentUserID'";
  $findUser = $conn->query($findUserSQL);
  
      //threads + posts = forum posts
            $postCountSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$currentUserID'"; //can't wait for php errors
            $postCount = $conn->query($postCountSQL);
            $posts = $postCount->num_rows;
            $threadCountSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$currentUserID'"; //wtf it worked, how?
          //can't believe it still works
            $threadCount = $conn->query($threadCountSQL);
            $threads = $threadCount->num_rows;
            
            $userPostCount = ($threads+$posts);

      //friends
$id = $userRow->{'id'};
$friendsQuery = "SELECT `from_id`,`to_id` FROM `friends` WHERE (`from_id`='$id' OR `to_id`='$id') AND `status`='accepted'";
$friends = $conn->query($friendsQuery);

$friendsArray = array();
while($friendRow = $friends->fetch_assoc()) {
  $friendsArray[] = $friendRow['from_id'];
  $friendsArray[] = $friendRow['to_id'];
}

$friendList = join("','",$friendsArray);
$friendnumrows = mysqli_num_rows($friends);

  if ($findUser->num_rows > 0) {
    $userRow = (object) $findUser->fetch_assoc();
  } else {
    unset($_SESSION['id']);
    header('Location: /');
    die();
  }
  
} else {
  header('Location: /');
  die();
}

//update desc
if (isset($_POST['desc'])) {
  $newDesc = mysqli_real_escape_string($conn,$_POST['desc']);
  //$newDesc = strip_tags($_POST['desc']);
  $userID = $userRow->{'id'};
  $updateDescSQL = "UPDATE `beta_users` SET `description` = '$newDesc' WHERE `id` = '$userID'";
  $updateDesc = $conn->query($updateDescSQL);
  header("Location: index");
  }
  //update status
if (isset($_POST['status'])) {
  //make something where you can't spam statuses
  $newStatus = mysqli_real_escape_string($conn,$_POST['status']);
  mysqli_query($conn,"INSERT INTO `statuses` VALUES (NULL,'$currentUserID','$newStatus','$curDate')");
  header("Location: index");
  }

$statusSQL = "SELECT * FROM `statuses` WHERE `owner_id`='$currentUserID' ORDER BY `id` DESC";
$findStatus = $conn->query($statusSQL);

if ($findStatus->num_rows > 0) {
  $statsRow = (object) $findStatus->fetch_assoc();
}

?>

<!DOCTYPE html>
  <head>
    <title>Dashboard - plutonium</title>
  </head>
  <body>
    <div id="body">

      <div id="box" style="background-color:#e9e9ba; color:yellow; padding:20px; text-align:center;">
	Please, be sure to read Terms of Service before doing anything there.
      </div>
<br>
      <div id="column" style="float:left; ">
        <div id="box" style="width:100%;">

        
          <div style="margin:20px;float:left;position:relative;width: 165px;">
<?php if($loggedIn) {echo '<center><h4>Greetings, '. $userRow->{'username'}.'!</h4></center>';} ?><iframe style="width:180px;height:225px;border:0px;" src="/user/rendering/headshot/"></iframe>
          </div>
          <form style="margin: 20px 20px 10px 20px; float:left; text-align:left;" action="" method="POST">
            
            <p class="title" style="font-weight:bold;">Status:</p>
            <input name="status" style="width:320px;" type="text"<?php if (empty($currStatus)) {echo 'placeholder="Right now I&#39;m..."></input>';}else {echo 'value="' . $currStatus . '"</input>';}
            ?><br>
            <input type="submit" style="margin-top:4px;">
          </form>
          <form style="margin: 10px 20px 20px 20px; float:left; text-align:left;" action="" method="POST">
            <p class="title" style="font-weight:bold;">Description</p>
            <textarea name="desc" style="width:320px; height:120px;"<?php
            if (empty($userRow->{'description'})) {echo 'placeholder="Hi, my name is "' . $userRow->{'username'} . '"></textarea>';}
            else {echo '>' . $userRow->{'description'} . '</textarea>';}
            ?>
            <br>

            <input type="submit">  

          </form>
<div id="box" style="width:300px; margin-top:75px;">
<h4>Your Statistics:</h4>
<hr>
<h5>Forum Posts: <?php echo $userPostCount ?> <span></span> <a href="/user/friends/">Friends: <?php echo $friendnumrows ?></a> <span></span> Profile Views: <?php echo $userRow->{'views'} ?></h5>
</div>
<center><button onClick="window.location.replace('/user/settings/')" style="font-size:20px; margin-top:30px;">Your Settings</button></center>
        </div>

      </div>
<br>
        <div id="box" style="width:100%;padding-bottom:0px;">
          <div id="subsect" style="margin:0px;">
            <h3>Your Feed</h3>
          </div>
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <tbody>
            <?php
$id = $userRow->{'id'};
$friendsQuery = "SELECT `from_id`,`to_id` FROM `friends` WHERE (`from_id`='$id' OR `to_id`='$id') AND `status`='accepted'";
$friends = $conn->query($friendsQuery);

$friendsArray = array();
while($friendRow = $friends->fetch_assoc()) {
  $friendsArray[] = $friendRow['from_id'];
  $friendsArray[] = $friendRow['to_id'];
}

$friendList = join("','",$friendsArray);
$friendnumrows = mysqli_num_rows($friends);

$statusQuery = "SELECT * FROM `statuses` WHERE `owner_id` IN('$friendList') AND `owner_id`!='$id' ORDER BY `id` DESC";
$status = $conn->query($statusQuery);

for($c = 0; $c < 15; $c++) {
  $statusRow = $status->fetch_assoc();
  
  if(empty($statusRow)) {break;}
  
  $findPosterRowSQL = "SELECT * FROM `beta_users` WHERE `id` = '" . $statusRow['owner_id'] . "'";
  $findPosterRow = $conn->query($findPosterRowSQL);
  $posterRow = $findPosterRow->fetch_assoc();
  echo '<tr style="border-bottom: 0px solid #e9ebf3;">
    <td style="padding: 8px 0px 0px 8px;" valign="top">'.str_replace(">","&gt;",str_replace("<","<",$statusRow['body'])).'</td><td style="font-size: 12.5px;font-style: italic;text-align: right;padding-top: 46px;float: right;padding-right: 5px;">'.$statusRow['date'].'</div>
    <td style="width: 20%; text-align: center;">
    <div style="border-left: 1px solid #e9ebf3;padding: 3px;">
    <a href="/user?id='.$statusRow['owner_id'].'" style="text-decoration:none;">
      <img style="width:80px;" src="/assets/images/avatars/'.$statusRow['owner_id'].'.png?c='.$posterRow['avatar_id'].'"><br>' .$posterRow['username']. '</a>
    </div></td>
    </tr>';
}

while($statusRow = $status->fetch_assoc()) {
  $findPosterRowSQL = "SELECT * FROM `beta_users` WHERE `id` = '" . $statusRow['owner_id'] . "'";
  $findPosterRow = $conn->query($findPosterRowSQL);
  $posterRow = $findPosterRow->fetch_assoc();
  echo '<div id="subsect" style="overflow: auto;">
    <div style="display:inline-block;float:left;">
    <a href="/user.php?id='.$statusRow['owner_id'].'" style="text-decoration:none;">
      <img style="width:40px;" src="/assets/images/avatars/'.$statusRow['owner_id'].'.png?c='.$posterRow['avatar_id'].'"><br>' .$posterRow['username']. '</a>
    </div>
    <div>'.str_replace(">","&gt;",str_replace("<","<",$statusRow['body'])).'</div>
    </div>';
  }
            
            
            
            ?>
            </tbody>
            </table>
          </div>
    
        </div>
      </div>
    </div>
    <?php include('../../site/footer.php'); ?>
  </body>
</html>