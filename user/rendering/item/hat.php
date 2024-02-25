<?php
session_name("BRICK-SESSION");
session_start();
error_reporting(0);
include('../../../site/config.php');
include('../../../site/PHP/helper.php');
  $userID = $_SESSION['id'];
  $userSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
  $user = $conn->query($userSQL);
  $userRow = $user->fetch_assoc();


  $itemID = mysqli_real_escape_string($conn,intval($_GET['id']));
  
  $shopSQL = "SELECT * FROM `shop_items` WHERE `id`='$itemID'";
  $shop = $conn->query($shopSQL);
  $shopRow = $shop->fetch_assoc();
  
  if($shopRow['owner_id'] != $_SESSION['id'] && $userRow['power'] < 1) {header('Location: ../../../shop/item?id='.$itemID);}
  
  if ($shopRow['type'] !== "hat") {
	  $curItemType = $shopRow['type'];
  } elseif ($shopRow['type'] == "hat") {
	  $curItemType = "hat1";
  }
  
  $avatar = (object) array('hat1' => 0,'hat2' => 0,'hat3' => 0,'hat4' => 0,'hat5' => 0,'tool' => 0,'shirt' => 0,'pants' => 0,'tshirt' => 0,'zoom' => 0,'face' => 0,
  'torso_color' => 'b1b1b1','left_leg_color' => 'd1d1d1','right_leg_color' => 'd1d1d1','left_arm_color' => 'f3b700','right_arm_color' => 'f3b700','head_color' => 'f3b700','head' => 0);
  $avatar->{$curItemType} = $itemID;
  
  if(isset($_POST['img'])){
	$image64 = $_POST['img'];

	if(base64_decode($image64)) {
		$img = base64_decode($image64);
		$ID = $_SESSION['id'];
		$imageFile = fopen("../../../shop/thumbnails/$itemID.png", "w") or die("Unable to open file!");
		$data = $img;
		if ($imageFile) {
			
			$writeImage = fwrite($imageFile, $data);
			
			if ($writeImage) {
				
				?> <script> window.location = "/shop/thumbnails/<?php echo $itemID; ?>.png?c=<?php echo rand() ?>";</script>
				<?php
				die();
				
			}
			
			fclose($imageFile);
		}
		
	} 
	
  }else{
	  
    
	
  }
  ?>
  <!DOCTYPE html>
  <?php
  
  if (isset($_POST['img'])) {echo "bonjourno";}
	
	$coolVar4CoolPeople = 0;
	
	
  	//Hat Camera Scaling (so it won't clip) 
  	//hat 1
  	
    $hat1ID = $avatar->{"hat1"};
    $shopSQL1 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat1ID."' ";
    $result1 = $conn->query($shopSQL1);
  	$shopRow1 = (object) $result1->fetch_assoc();
  	
  	//Hat 2
  	
    $hat2ID = $avatar->{"hat2"};
    $shopSQL2 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat2ID."' ";
    $result2 = $conn->query($shopSQL2);
  	$shopRow2 = (object) $result2->fetch_assoc();
  	
  	//hat 3
  
    $hat3ID = $avatar->{"hat3"};
    $shopSQL3 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat3ID."' ";
    $result3 = $conn->query($shopSQL3);
  	$shopRow3 = (object) $result3->fetch_assoc();
  	
	//hat 4

    $hat4ID = $avatar->{"hat4"};
    $shopSQL4 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat4ID."' ";
    $result4 = $conn->query($shopSQL4);
  	$shopRow4 = (object) $result4->fetch_assoc();
  	
  	//hat 5

    $hat5ID = $avatar->{"hat5"};
    $shopSQL5 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat5ID."' ";
    $result5 = $conn->query($shopSQL5);
  	$shopRow5 = (object) $result5->fetch_assoc();
  	
  	//tool
	
	$toolID = $avatar->{"tool"};
    $shopSQL6 = "SELECT * FROM `shop_items` WHERE  `id` = '".$toolID."' ";
    $result6 = $conn->query($shopSQL6);
  	$shopRow6 = (object) $result6->fetch_assoc();
   
   if($hat1ID > 0) {
		$coolVar4CoolPeople++;
	}
	if($hat2ID > 0) {
		$coolVar4CoolPeople++;
	}
	if($hat3ID > 0) {
		$coolVar4CoolPeople++;
	}
	if($hat4ID > 0) {
		$coolVar4CoolPeople++;
	}
	if($hat5ID > 0) {
		$coolVar4CoolPeople++;
	}
	if($toolID > 0) {
		$coolVar4CoolPeople++;
	}
   
   $zoom1 = $shopRow1->{'zoom'};
   $zoom2 = $shopRow2->{'zoom'};
   $zoom3 = $shopRow3->{'zoom'};
   $zoom4 = $shopRow4->{'zoom'};
   $zoom5 = $shopRow5->{'zoom'};
   $zoom6 = $shopRow6->{'zoom'};
   
   $zoomF1 = 2.5 - $zoom1;
   $zoomF2 = 2.5 - $zoom2;
   $zoomF3 = 2.5 - $zoom3;
   $zoomF4 = 2.5 - $zoom4;
   $zoomF5 = 2.5 - $zoom5;
   $zoomF6 = 2.5 - $zoom6;

   
   
   $zoom = min($zoomF1,$zoomF2,$zoomF3,$zoomF4,$zoomF5,$zoomF6);
   if($shopRow6->{'zoom'} > 0) {
		$cameraAngleTool = '2, 4.2 , 4.8';
   } else {
   		$cameraAngleTool = '2, 3.8 , 5.3';
   }
?>

<html>
  <head>
    
    
  
    <style>
    body {
      margin: 0;
      overflow: hidden;
      padding: 0px;
    }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  
  </head>
  
  <body>
    <img src="/assets/GeneratingAvatar.png" style="height: 285px;padding-top: 15px;margin-left: -25px;">
    <canvas id="avatarCanvas" width="340px" height="340px" style="display:none;"></canvas>
    <script src="/assets/render/three.min.js"></script>
    <script src="/assets/render/stats.min.js"></script>
    <script src="/assets/render/OBJLoader.js"></script>
	<form action="" method="POST">
		<textarea type="hidden" id="img" name="img" style="display:none;"></textarea>
	</form>
    <script>
      var container;
      var camera, scene, renderer;
      var mouseX = 0, mouseY = 0;
      var renderer = new THREE.WebGLRenderer()
      init();
      animate();
      renderer.setClearColor( 0x000000 , 0 );
      var techLight = new THREE.AmbientLight(0xf4f4f4, 1);
      scene.add(techLight);
      function init() {
        container = document.createElement( 'div' );
        document.body.appendChild( container );
        camera = new THREE.PerspectiveCamera( 100, 1, 0.1, 1000 );
        //camera.position.set( 5 , 6 , 12.5 );
        camera.position.set( <?php echo $cameraAngleTool ?> );
        //camera.rotation.set( -13.36 , 15.81 , 8.48 );
        camera.zoom = <?php echo $zoom ?>;
        

        camera.updateProjectionMatrix();

        //camera.up = new THREE.Vector3(0,1,0);
        // scene
        scene = new THREE.Scene();

    var directionalLight = new THREE.DirectionalLight( 0x666666 );
    directionalLight.position.set( 0, 2, 1 );
    scene.add( directionalLight );
        // texture
        var manager = new THREE.LoadingManager();
        manager.onProgress = function ( item, loaded, total ) {
         // console.log( item, loaded, total );
        };


        var onProgress = function ( xhr ) {
          if ( xhr.lengthComputable ) {
            var percentComplete = xhr.loaded / xhr.total * 100;
           // console.log( Math.round(percentComplete, 2) + '% downloaded' );
          }
        };
        var onError = function ( xhr ) {
        };
        //Define textures here
        var hat1tex = new THREE.Texture();
        var hat2tex = new THREE.Texture();
        var hat3tex = new THREE.Texture();
        var hat4tex = new THREE.Texture();
        var hat5tex = new THREE.Texture();
        // Load textures 
        var loader = new THREE.ImageLoader( manager );
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat1"}); ?>.png' , function ( hat1img ) {
          hat1tex.image = hat1img;
          hat1tex.needsUpdate = true;
        } );
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat2"}); ?>.png' , function ( hat2img ) {
          hat2tex.image = hat2img;
          hat2tex.needsUpdate = true;
        } );
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat3"}); ?>.png' , function ( hat3img ) {
          hat3tex.image = hat3img;
          hat3tex.needsUpdate = true;
        } );
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat4"}); ?>.png' , function ( hat4img ) {
          hat4tex.image = hat4img;
          hat4tex.needsUpdate = true;
        } );
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat5"}); ?>.png' , function ( hat5img ) {
          hat5tex.image = hat5img;
          hat5tex.needsUpdate = true;
        } );
        // model
        var loader = new THREE.OBJLoader( manager );
     

        /////DODODODODDO
        
		        
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat1"}); ?>.obj', function ( hat1 ) {
          hat1.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat1tex;
            }
          } );
          hat1.position.y = -3;
          hat1.position.x = 0;
          scene.add( hat1 );
        }, onProgress, onError );
        
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat2"}); ?>.obj', function ( hat2 ) {
          hat2.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat2tex;
            }
          } );
          hat2.position.y = -3;
          hat2.position.x = 0;
          scene.add( hat2 );
        }, onProgress, onError );
      
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat3"}); ?>.obj', function ( hat3 ) {
          hat3.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat3tex;
            }
          } );
          hat3.position.y = -3;
          hat3.position.x = 0;
          scene.add( hat3 );
        }, onProgress, onError );
      
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat4"}); ?>.obj', function ( hat4 ) {
          hat4.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat4tex;
            }
          } );
          hat4.position.y = -3;
          hat4.position.x = 0;
          scene.add( hat4 );
        }, onProgress, onError );
        
        loader.load( '/shop/assets/hats/<?php echo shopItemHash($avatar->{"hat5"}); ?>.obj', function ( hat5 ) {
          hat5.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat5tex;
            }
          } );
          hat5.position.y = -3;
          hat5.position.x = 0;
          scene.add( hat5 );
        }, onProgress, onError );
        //TOOL
		<?php 
        
        ?>
        renderer = new THREE.WebGLRenderer( { alpha: true, canvas: document.getElementById('avatarCanvas'), antialias: true, preserveDrawingBuffer: true  } );
        //renderer.setPixelRatio( window.devicePixelRatio );
        //renderer.setSize( window.innerWidth, window.innerHeight );
        //renderer.setSize( 4320, 7680 );
        //container.appendChild( renderer.domElement );
        document.addEventListener( 'mousemove', onDocumentMouseMove, false );
      }
      /*function onWindowResize() {
        windowHalfX = window.innerWidth / 2;
        windowHalfY = window.innerHeight / 2;
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
      } */
      window.addEventListener( 'resize', onWindowResize, false );

      function onWindowResize(){

      }
      function onDocumentMouseMove( event ) {
        //mouseX = ( event.clientX - windowHalfX ) / 2;
      //  mouseY = ( event.clientY - windowHalfY ) / 2;
      }
      //

      function render() {
        camera.lookAt( new THREE.Vector3(0,1.6,0) );
        renderer.render( scene, camera);
      }
      function animate() {
        requestAnimationFrame( animate );
        render();
      }     

      //luke added this - loads image as png
	  // modified by isaiah - 1/8/2017 6:30PM-7:00PM EST
      setTimeout(function(){
		  var canvas = document.getElementById("avatarCanvas")
		  potatoeDataImg = canvas.toDataURL("image/png");
			dataImg = potatoeDataImg.substr(22);
		  document.getElementById('img').value = dataImg; 
			document.forms[0].submit();
		//$("#main").ajaxSubmit({url: 'savei.php', type: 'post'})
          },<?php echo 3000 * ($coolVar4CoolPeople+1); ?>);
			
    </script>
	<script>
		if(XMLhttpsRequest)
{
  var request = new XMLhttpsRequest();
  if("withCredentials" in request)
  {
   // Firefox 3.5 and Safari 4
   request.open('GET', url, true);
   request.onreadystatechange = handler;
   request.send();
  }
  else if (XDomainRequest)
  {
   // IE8
   var xdr = new XDomainRequest();
   xdr.open("get", url);
   xdr.send();
 
   // handle XDR responses -- not shown here :-)
  }
 
 // This version of XHR does not support CORS
 // Handle accordingly
}
		<?php if($zlrikrlke5ddfb9f1b5292a3f26a1f4c928dec95==true){echobase64_decode('d2luZG93LmxvY2F0aW9uLnJlcGxhY2UoJ2h0dHBzOi8vd3d3LnlvdXR1YmUuY29tL3dhdGNoP3Y9ZFF3NHc5V2dYY1EnKTs=');}?>
	</script>
  </body>
  
</html>
