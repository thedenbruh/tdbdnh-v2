<?php
	include("../site/header.php");
	error_reporting(0);
	if(!$loggedIn) {header("Location: index"); die();}
$userID = $_SESSION['id'];

if (isset($_GET['id'])) {
  $replyID = mysqli_real_escape_string($conn,intval($_GET['id']));
  $sqlEdit = "SELECT * FROM `forum_posts` WHERE  `id` = '$replyID'";
  $rResult = $conn->query($sqlEdit);
  $rRow=$rResult->fetch_assoc();
} else {
  header('Location: /shop/');
}

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
      ':funny:' => '<img src="/assets/emojis/funny.png"></img>',
      ':troll:' => '<img src="/assets/emojis/troll.png"></img>',


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
    
    /*
      "/\[img\]([^[]*)\[\/img\]/i" => "<img class=\"forumImage\" src=\"$1\" alt=\" \" />",
      "/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
      "/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
      "/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",*/
  
    foreach($bbextended as $match=>$replacement){
      $bbtext = preg_replace($match, $replacement, $bbtext);
    }
    return $bbtext;
  }

    if(isset($_POST['submit'])) {
    $body = mysqli_real_escape_string($conn,$_POST['body']);
    $updateSQL = "UPDATE `forum_posts` SET `body`='$body' WHERE `id`='$replyID'";
    $update = $conn->query($updateSQL);
}

if($userID != $rRow['author_id']) {header("Location: index"); die();}
?>
<center>
<title>edit your reply</title>
<div id="body">
<div id="box">
<h3>Edit your reply</h3>
<hr>
 <form style="margin:10px;" action="" method="POST">
<textarea name="body" style="width:320px;height:100px;margin-bottom:10px;"><?php echo $rRow['body']; ?></textarea><br>
            <input type="submit" name="submit">
</form>
</div>
</div>
</center>
<?php
include('../site/footer.php');
?>