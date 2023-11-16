<?php
    include("site/header.php");
   if($loggedIn) {header("Location: /user/dashboard/"); die();}

$result = mysqli_query($conn, "SELECT username FROM beta_users ORDER BY id");

$row_cnt = mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html>
<head>
<style>
@font-face {
	font-family: "idk";
	src: url('/assets/W95FA.otf');
}

.button {
    padding: 5px;
    font-size: 1.5rem;
    background-color: #08ca08;
    border-bottom: 5px solid #008600;
    text-align: center;
}
.button:hover {
	cursor: pointer;
}
.button:active {
    border-bottom: 0px solid transparent;
    margin-top: 15px;
}
.red-button {
	background-color: #FF5747;
	border-bottom: 5px solid #CB4538;
}
.green-button {
	background-color: #2BDC32;
	border-bottom: 5px solid #22B229;
}
  .blue-button {
    background-color: #15BFFF;
    border-bottom: 5px solid #109ACD;
    color: white;
}
</style>
	<style>
	#landing {
	   height: 300px;
	   background-repeat: round;
	   background-size: cover;
	}
	</style>
	<title>plutonium</title>
</head>
<body>
	<div id="body">
		<div id="box" class="box2d" style="padding: 10px; text-align:center;">
			<div id="landing" class="box2d">
				<div class="box2d" style="display: inline-table;padding-top: 5%;">
					<center><img class="box2d" src="/assets/landing.png" style="width:75%;height:auto;"></img>
					<h4 class="box2d">a funny brick hill clone with <?php echo $row_cnt; ?> players in it</h4></center>

          
          <div>
            
          <center><div class="button box2d pixel-text blue-button" style="display:inline-block;" onClick="window.location.replace('/auth/register/');">
					register
          </div></center></div>
<center><div class="button box2d pixel-text blue-button" style="display:inline-block;" onClick="window.location.replace('/auth/login/');">
					login </div></center>
				</div>
			</div>
			<h5 class="box2d" style="color:black;margin:0px;margin-top:5px;">rewritten in a month!</h5>
    </div>

	</div><?php
	        include("site/footer.php");
	    ?>
</body>



</html>