<?php 
include('../site/config.php');
include('../site/header.php');

//anti xss made easy

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

?>
<!DOCTYPE html>
<html>

	<head>
		
		<title>Games - plutonium</title>
		
	</head>
	
	<body>
		
		<div id="body">
			<div id="box" style="padding-top: 9px;padding-left: 9px;">
			<div id="subsect">plutonium games
			</div>
			<?php 
			
			$findGamesSQL = "SELECT * FROM `games` WHERE `active`='1' ORDER BY `playing` DESC";
			$findGames = $conn->query($findGamesSQL);
			
			if ($findGames->num_rows > 0) {
				while($gameRow = $findGames->fetch_assoc()) {
					
					// Change array to OOP Array
					
					$gameRow = (object) $gameRow;
					
					// Find Game Owner
					
					$ownerID = $gameRow->{'creator_id'};
					$findOwnerSQL = "SELECT * FROM `beta_users` WHERE `id` = $ownerID";
					$findOwner = $conn->query($findOwnerSQL);
					$ownerRow = (object) $findOwner->fetch_assoc();
					
			?>
				<div style="margin: 10px; width: 196px; display:inline-block; ;"><a href="set?id=<?php 
					echo $gameRow->{'id'};
					?>"><img id="shopItem" style="width:196px;" src="<?php echo '/assets/images/games/' . $gameRow->{'id'} . '.png'; ?>"></a>
					<span style="display:inline-block; float:left; width:100%">
						<a class="shopTitle" href="set?id=<?php 
					echo $gameRow->{'id'}; ?>"><?php echo bbcode_to_html(nl2br(htmlentities($gameRow->{'name'}))); ?></a>
					</span>
					<span style="display:inline-block; float:left; padding-left:0px;"><p class="shopDesc">by<a class="shopDesc" href="/user?id=<?php echo $ownerID; ?>"><?php echo $ownerRow->{'username'}; ?></a></p></span>
					<span style="padding:0px; display:inline-block; float:right; text-align:right"><p class="shopDesc" style="color:Red;"><?php echo $gameRow->{'playing'}; ?> online</p></span>
					</div>
				
				
			<?php 
				}
				} else {
					?>
					<div style="text-align:center;">
						There aren't any active sets!
					</div>
					<?php
				}
			?>
			</div>
<div id="box" style="margin-top:10px; padding-top: 9px;padding-left: 9px;">
<center>wanna make your own set?<br>well i got you<br><span><button onClick="window.location.replace('/play/create/')">Create</button><span></span><button onClick="window.location.replace('/play/mysets')">Your Sets</button><span></span><button onClick="window.location.replace('/play/')">go back to the current games page</button></span></center>
</div>
		</div>
		


		<?php
		include("../site/footer.php");
		?>
		
	</body>
	
</html>
