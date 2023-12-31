<?php
	include("../site/config.php");
	include("../site/header.php");
	
	
	if(isset($_GET['search'])) {
		$searchQ = htmlentities($_GET['search']);
	} else {
		$searchQ = '';
	}
?>

<!DOCTYPE html>
	<head>
		<title>Shop - plutonium</title>
	</head>
	<body>
		<div id="body">
			<div id="column" style="float:left; width:195px;">
				<div id="box" style="padding-bottom:0px;">
					<div id="subsect">
						<h2 style="padding:5px;">Shop</h2>
					</div>
					<h6 style="padding-left:5px;margin-bottom:10px;">Sort By:</h6>
					<div>
					<?php 
					$sortByArray = array(
					"All" => "all",
					"Hats" => "hat",
					"Heads" => "head",
					"Faces" => "face",
					"Shirts" => "shirt",
					"T-Shirts" => "tshirt",
					"Tools" => "tool",
					"Pants" => "pants",
					"ROBLOX Places" => "place",
					"ROBLOX Models" => "model",
					"Brick Hill Games" => "bhgame"
					);
					foreach ($sortByArray as $sortByValue => $jsValue) {
					?>
						<a class="nav" onclick="getPage('<?php echo $jsValue; ?>','<?php echo $searchQ; ?>',0);">
							<div class="shopSideBarButton1">
								<?php echo $sortByValue; ?>
							</div>
						</a>
					<?php 
					}
					?>
					</div>
				</div>
				<div id="box" style="margin-top:10px;">
					<div id="subsect">
						<h6 style="padding-left:5px;margin:10px 0px 10px 0px;">small, probably useful guide:</h6>
					</div>
					<div style="padding-left:5px;">
						<div style="height:5px;"></div>
						<img src="speciale_label.png">
						<p id="shopLegendTitle">"Special Edition" Items</p>
						<p id="shopLegendInfo">If an item has a "Special E." label, there is a limited stock of the item. So, that actually means you should immediately buy it before its stock will be ran out.</p>
						<div style="height:5px;"></div>
						<img src="free_label.png">
						<p id="shopLegendTitle">"Free" Items</p>
						<p id="shopLegendInfo">Any item with a "Free" label is free for everyone, which is damn obvious.</p>
						<div style="height:5px;"></div>
					</div>
				</div>
			</div>
			<style>
			#shopLegendTitle {
			font-size: 15px;
			font-weight: 600;
			margin-top:2px;
			}
			#shopLegendInfo {
				margin-top: -14px;
   				padding-top: 8px;
   				font-size: 13px;
			}
			.shopSortBy a {
    			background: #77B9FF;
    			margin: 10px;
    			padding: 5px;
    			border: 1px solid black;
    			position: relative;
			}
			.shopSortBy {
				padding-top: 5px;
			}
			.shopSortByBreak {
			    display: block;
    			-webkit-margin-before: 1em;
   				-webkit-margin-after: 1em;
    			-webkit-margin-start: auto;
    			-webkit-margin-end: auto;
			}
			</style>
			<div id="column" style="float:right; width:695px;">
			<div style="overflow:auto;">
				<div id="column" style="float:left; width:500px;">
					<div id="box" style="display:inline-block;text-align:center;width:100%;">
						<form action="" method="GET" style="margin:15px;">
							<input style="width:300px; height:20px;" type="text" name="search" placeholder="I'm looking for..." 
							<?php
								if(!empty($searchQ)) {
									echo 'value="'.$searchQ.'"';
								}
							?>
							>
							<input style="height:24px;" type="submit" value="Submit">
							<a href="upload/" style="font-size:12px;background-color: #03c303;padding:4px 5px 4px 5px;text-decoration:none;" class="button-style">Create</a>
						</form>
					</div>
				</div>
				<div id="column" style="float:right; width:181px;">
					<div id="box" style="text-align:center;height:64px;padding:0px;">
						<h6>Price:</h6>
						<form action="" method="GET">
							<input style="height:24px;" type="submit" value="Submit">
						</form>
					</div>
				</div>
			</div>
			<div id="box" style="margin-top:10px;padding-left: 20px;padding-top: 10px;">
				<div id="crate"></div>
			</div>
		</div>
	</div>
		<script>
		window.onload = function() {
			getPage('all','<?php echo $searchQ; ?>',0);
		};
	
		function getPage(type, search, page) {
			$("#crate").load("/shop/crate?item="+type+"&search="+search+"&page="+page);
		};
		</script>
		<?php
			include("../site/footer.php");
		?>
	</body>
<html>