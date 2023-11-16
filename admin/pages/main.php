<?php 

    require("adminOnly.php");
    include("../../site/config.php");
  
    if($power < 4) {header("Location: ../");die(); }

$econSQL = "SELECT SUM(`bits`) AS 'totalBits' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBits = $econRow['totalBits'];

$econSQL = "SELECT SUM(`bucks`) AS 'totalBucks' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBucks = $econRow['totalBucks'];

$econ = $totalBits+($totalBucks*10);
?>
<div id="box" style="margin-bottom:10px; padding:5px;">
        <div id="subsect">
          <h3>Admin Panel</h3>
          <h4>Economy (in bits): <?php echo $econ; ?></h4>
        </div>
        <i> Fun fact: administration actions are kept in logs of tdbdnh database. </i>
        <h4>Item (don't give specials to people who ask for it)</h4>
        <form action="" method="POST" style="margin:10px;">
          User ID: <input type="text" name="user"><br>
          Item ID: <input type="text" name="item"><br>
          <input type="submit" name="grant" value="Grant Item">
        </form><br>
        <h4>Currency (for the god's sake, don't abuse it)</h4>
        <form action="" method="POST" style="margin:10px;">
          User ID: <input type="text" name="user"><br>
          Bits: <input type="text" name="bits"><br>
          Bucks: <input type="text" name="bucks"><br>
          <input type="submit" name="money" value="Add Currency">
        </form><br>
        <h4>Password Reset</h4>
        <h6>WARNING: reset password ONLY in a case if the random user forgot the password from its account.</h6>
        <form action="" method="POST" style="margin:10px;">
          User ID: <input type="text" name="user"><br>
          <input type="submit" name="password" value="Reset Password" style="margin-top:10px;">
      </div>
<div id=box>
<center><h3 style="margin-top:15px;">don't abuse administration perms</h3><center>
</div>
    </div>
