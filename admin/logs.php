<?php
    include("../site/config.php");
    include("../site/header.php");
    include("../site/PHP/helper.php");
    
    if($power < 5) {header("Location: ../");} // Will be changed to 5 later :^) | did it - dentehbruh
?>
<div id="body" >

	<div id="box">
		<h2>
			Admin Logs
		</h2>
		<hr>
	</div>

</div>
<?php 
    include("../core/footer.php");
?>