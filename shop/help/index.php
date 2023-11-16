<a name="goUp"></a>
<?php
    include("../../site/header.php");
?>
	<!DOCTYPE html>
	<html>
	<head>

		<style>
			#center {
				text-align: center;
			}
		</style>
		<title>plutonium things exporting tutorial</title>
	</head>

	<body>
		<div id="body">
			<h5>
				<a href="/shop/upload/"><span style="color:#3f89e3;">Upload</span></a>
			</h5>
			<div id="column" style="width: 26%;">
				<div id="box" style="padding:5px;float:left;">
					<h3>Help on Exporting</h3>
					<a href="#blender" style="color: #3f89e3;">Blender</a>
				</div>
			</div>
			<div id="column" style="width:74%; float:right;">
				<div id="box" style="padding:5px;">
					<a name="blender"></a>
					<h4>Blender Exporting:</h4>
					<p>Step 1</p>
					<p>Position and scale your model down to the size of the avatar. If you do not have this avatar file, download it <a style="color: #3f89e3;" href="/assets/Avatar.blend">here.</a></p>
					<p>Step 2</p>
					<p>Select your model(s), (Join them together),press Shift+C (This puts the 3D cursor at 0,0,0).</p>
					<p>Step 3</p>
					<p>When you're done making or porting an asset from somewhere, press Right Click on your mouse on your asset and press Set Origin > Origin to 3D Cursor</p>
					<img src="bh1.png" />
					<p>Step 4</p>
					<p>Press (at the very top) File > Export > Wavefront (.obj). Navigate to somewhere you can find your model.</p>
					<p>Step 5 (important!)</p>
					<p>You should see on the left hand side (Press T if you do not have the left hand side) a 'Export OBJ' settings panel. You need to check the following things. 'Selection Only','Triangulate Faces' and then press 'Export OBJ' in the top right.</p>
					<i>Note: If anything is not working, please refer to the image below.</i>
					<img src="bh2.png" width="100%" /><br>
					<a href="#goUp"><span style="color:#3f89e3; float:right;">^ Go Up</span></a>
				</div>
			</div>
		</div>
		<?php
	include("../../site/footer.php");
	?>
	</body>

	</html>