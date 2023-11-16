<?php
  include("../site/header.php");
  if(!$loggedIn) {header("Location: index"); die();}



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

  // deleting links !!!
  'goatse.info' => '[ Link Removed ]',
  'pornhub.com' => '[ Link Removed ]',
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


  $error = array();

  $clanID = mysqli_real_escape_string($conn,$_GET['id']);
  $sqlClan = "SELECT * FROM `games` WHERE `id`='$clanID'";
  $result = $conn->query($sqlClan);
  $clanRow = $result->fetch_assoc();
  
  $userID = $_SESSION['id'];

  if(!($userID == $clanRow['creator_id'])) {
    header("Location: /play/oldindex");
  }

//added the xss or php thing checking there

  if(isset($_POST['newDesc'])) {
    $desc = str_replace(PHP_EOL, '', mysqli_real_escape_string($conn,$_POST['description']));
    
	 $alnumUsername = str_replace(array('-','_','.',' '), '', $desc);
    
    if(strlen($desc) > 500 || $desc != ctype_alnum($alnumUsername)) {
      $error[] = 'Your clan description should not be more than 500 betanumeric characters (including [ , ., -, _]).';
    }

if(empty($error)) {

    $updateSQL = "UPDATE `games` SET `description`='$desc' WHERE `id`='$clanID'";
    $update = $conn->query($updateSQL); }

  }

if(isset($_POST['active'])) {
    $act = "0";
    $active = "UPDATE `games` SET `active`='$act' WHERE `id`='$clanID'";
    $actupd = $conn->query($active);
}else{$act = "1";
    $active = "UPDATE `games` SET `active`='$act' WHERE `id`='$clanID'";
    $actupd = $conn->query($active);}

  if(isset($_POST['newName'])) {
    $name = str_replace(PHP_EOL, '', mysqli_real_escape_string($conn,$_POST['name']));

 $CN = str_replace(array('-','_','.',' '), '', $name);
    
    if(strlen($name) > 30 || $name != ctype_alnum($CN)) {
      $error[] = 'Your clan name should not be more than 30 betanumeric characters (including [ , ., -, _]).';
    }

    if(empty($error)) {
    $updateSQL = "UPDATE `games` SET `name`='$name' WHERE `id`='$clanID'";
    $update = $conn->query($updateSQL); }
  }
  
  if(isset($_POST['plrs'])) {
    $curpl = mysqli_real_escape_string($conn,$_POST['plrs']);
    $updatecur = "UPDATE `games` SET `playing`='$curpl' WHERE `id`='$clanID'";
    $updatealreadylol = $conn->query($updatecur); 
  }

  if(isset($_POST['vis'])) {
    $curvis = mysqli_real_escape_string($conn,$_POST['vis']);
    $updatev = "UPDATE `games` SET `visits`='$curvis' WHERE `id`='$clanID'";
    $visitupdater = $conn->query($updatev); 
  }

  if(isset($_POST['newImage'])) {
    if(isset($_FILES['image'])) {
      $imgName = $_FILES['image']['name'];
      $imgSize = $_FILES['image']['size'];
      $imgTmp = $_FILES['image']['tmp_name'];
      $imgType = $_FILES['image']['type'];
      $isImage = getimagesize($imgTmp);
      
      if($isImage !== false) {
        if($imgSize < 2097152) {
          $approvedSQL = "UPDATE `clans` SET `approved`='no' WHERE `id`='$clanID'";
          $approved = $conn->query($approvedSQL);
          if($approved) {
            move_uploaded_file($imgTmp,"../assets/images/games/".$clanID.".png");
          }
        } else {
          echo 'File size must be smaller than 2MB';
        }
      } else {
        echo "File must be an image!";
      }
    } else {
      echo "You did not upload a tshirt!";
    }
  }
?>

<!DOCTYPE html>
  <head>
    <title>Edit <?php echo bbcode_to_html(nl2br(htmlentities($clanRow['name']))); ?></title>
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
      <div id="box">
<center>
        <h3>Edit <?php echo bbcode_to_html(nl2br(htmlentities($clanRow['name']))); ?></h3>
        <form action="" method="POST" style="margin:10px;" enctype="multipart/form-data">
          <h4>Image:</h4>
          <img style="width:300px;height:auto;" src="/assets/images/games/<?php echo $clanID; ?>.png"><br>
          <input type="file" name="image"><br>
          <input type="submit" name="newImage">
        </form>
        <hr>
        <form action="" method="POST" style="margin:10px;">
 <h4>Clan Name:</h4>
<textarea name="name" style="width: 50%;height:20px;resize: none;font-size: 16px;"></textarea><br>
<input type="submit" name="newName">
</form><br>
<form action="" method="POST" style="margin:10px;">
          <h4>Description:</h4>
          <textarea name="description" style="width:500px;height:250px;"><?php echo $clanRow['description']; ?></textarea><br>
          <input type="submit" name="newDesc">
        </form><br>
	<form style="margin:10px;" action="" method="POST" enctype="multipart/form-data">
   Visits (optional): <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" name="vis" placeholder="0""><span></span>currently playing players (optional): <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" name="plrs" placeholder="0""><br>
	<input style="margin-bottom:10px;" type="checkbox" name="active" value="active"> Active<br>
          <input type="submit" name="submit">
        </form> 
      </div>
        </div>
      </div>
    </div>
  <?php
    include("../site/footer.php");
  ?>
  </body>
</html>