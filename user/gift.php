<?php include('../site/header.php'); 

if(!$loggedIn) {header("Location: /"); die();}
  $giverid = $_SESSION['id'];
  

if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn,intval($_GET['id']));
  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();
} 

if($giverid == $userRow['id']) {header('Location: /');}	
if(isset($_POST['submit'])) {
$bruh = mysqli_real_escape_string($conn,$_POST['bruh']);
  $sql = "SELECT * FROM `shop_items` WHERE  `id` = '$bruh'";
  $result = $conn->query($sql);
  $shopRow = $searchRow=$result->fetch_assoc();

$name = $shopRow['name'];

$tradeSQL = "UPDATE `crate` SET	`user_id` = '$id' WHERE `item_id` = '$bruh' AND `user_id` = '$giverid'";
$trade = $conn->query($tradeSQL);

$messager = "INSERT INTO `messages` (`id`, `author_id`, `recipient_id`, `date`, `title`, `message`, `read`) VALUES (NULL, '$giverid', '$id', CURRENT_TIMESTAMP, 'You got a gift from me!','I just gave you the $name as a gift! Have fun.' ,'0')";
$msgSQL = $conn->query($messager);

header('/user/search/');
die();
}

?>
<head>
<title>Gift - plutonium</title>
</head>
<div id="body">
<div id="box" style="margin:10px;">
<div id="subsect">
<center><h3>make a warming gift for <?php echo $userRow['username']?>!</h3></center>
</div>
<form action="" method="POST" style="margin:10px;">

item id you're gonna give to <?php echo $userRow['username'];?>: <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" name="bruh"><br>
            <input type="submit" name="submit">
</form>
</div>
<div id="box" style="float:left; margin-top:10px; padding-bottom:0px; width:100%;overflow: hidden;">
        <div id="subsect" style="margin-bottom:-1px;text-align:center;">
          <h3>Your Crate (the number in brackets is for item id)</h3>
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

<script>
  var id = "<?php echo $giverid; ?>";

  window.onload = function() {
    getPage('hat',0);
  };
  
  function getPage(type, page) {
    $("#crate").load("/assets/idk/crate?id="+id+"&type="+type+"&page="+page);
  };

</script>

<?php include('../site/footer.php');?>