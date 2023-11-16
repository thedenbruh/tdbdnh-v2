<?php 

  $conn = mysqli_connect( "localhost" , "root", "" , "tdbdnh");
  
  //gonna change to cookies soon
  if(session_status() == PHP_SESSION_NONE) {
    session_name("BRICK-SESSION");
    session_start();
  }
error_reporting(0);


//die('<body><center><h1>hi there tdbdnh community<br>we are changing into a new brick hill clone<br>so yeah tdbdnh is no more</h1></body><audio controls><source src="/assets/tne.mp3" type="audio/mpeg"></audio><br>listen to the big ego during the tdbdnh turning into plutonium<br>is not that cool?');
?>