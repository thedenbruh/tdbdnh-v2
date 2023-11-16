<?php   
  require("adminOnly.php");
    include("../../site/config.php");
  
    if($power < 1) {header("Location: ../");die(); } 
  $logSQL = "SELECT * FROM `reports` WHERE `seen`='no'";
    $log = $conn->query($logSQL);

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
  '<script>' => 'haha i am funny js guy who wants to window.location.replace the whole tdbdnh server',
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

?>
<div id="box">
<table width="100%" cellspacing="1" cellpadding="4" border="0" style="background-color:#000;">
      <tbody>
        <tr>
          <th width="16%">
            <p class="title" style="color:#FFF;">User</p>
          </th>
          <th width="36%">
            <p class="title" style="color:#FFF;">URL</p>
          </th>
          <th width="40%">
            <p class="title" style="color:#FFF;">Reason</p>
          </th>
          <th width="8%">
            <p class="title" style="color:#FFF;">Seen</p>
          </th>
        </tr>
      <?php
      while($logRow=$log->fetch_assoc()){ 
        $reporterSQL = "SELECT * FROM `beta_users` WHERE `id`='".$logRow["user_id"]."'";
        $reporter = $conn->query($reporterSQL);
        $reporterRow = $reporter->fetch_assoc();
        
        if($logRow['r_type'] == 'post') {
          $postID = $logRow["r_id"];
          $postSQL = "SELECT * FROM `forum_posts` WHERE `id`='$postID'";
          $post = $conn->query($postSQL);
          $postRow = $post->fetch_assoc();
          $threadID = $postRow['thread_id'];
        } else {$threadID = 0;}
        $URLs = array('post'=>'/forum/thread?id='.$threadID.'#post[]','thread'=>'/forum/thread?id=[]','user'=>'/user?id=[]','game'=>'/play/set?id=[]','clan'=>'/clan?id=[]','item'=>'/shop/item?id=[]','message'=>'/messages/message?id=[]');
      
        echo '<tr class="forumColumn">
        <td>
          <a href="/user/'.$reporterRow["id"].'/">
          <img style="width:30%;" src="/images/avatars/'.$reporterRow["id"].'.png?c='.$reporterRow["avatar_id"].'">
          <br><span style="color:#333;">'.$reporterRow["username"].'</span>
          </a>
        </td>
        <td><a style="color:#333;" href="'.str_replace('[]',$logRow["r_id"],$URLs[$logRow["r_type"]]).'">'.$logRow["r_type"].'</a></td>
        <td>'.bbcode_to_html(nl2br(htmlentities($logRow["r_reason"]))).'</td>
        <td><a class="blue-button" href="index?seen='.$logRow['id'].'">Seen</a></td>
        </tr>';
      }
      ?>
      </tbody>
    </table>
    </div>