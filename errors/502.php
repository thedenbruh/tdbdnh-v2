<?php
include('../site/header.php');
?>

<!DOCTYPE html>
	<head>
		<title>plutonium - Bad Gateaway</title>
	</head>

	<body>
		<div id="body" style="text-align:center;">
			<div id="box">
				<div id="subsect" style="padding: 0px;">
					<h3 style="margin-bottom: 0px;">502 - Bad Gateaway</h3>
					<h4 style="color:#444; margin-top:10px;">seems like, the site got ddosed</h4>
					
				</div>
				<img src="/assets/unapproved.png">
				<hr>
				<button onclick="location.href('/')" style="width:50%; height:auto;"><h4 style="color:#444; margin-top:10px;">go back</h4></button>
			</div>

		</div>
		<?php
		include('site/footer.php');
		?>
	</body>
</html>