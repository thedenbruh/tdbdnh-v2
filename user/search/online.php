				<?php
					if(isset($_GET['search'])) {$query = mysqli_real_escape_string($conn,strtolower($_GET['search']));} else {$query = '';}
					
					$sql1Search = "SELECT * FROM `beta_users` WHERE  `usernameL` LIKE '%$query%'";
					$result1 = $conn->query($sql1Search);
					echo '<table width="100%"cellspacing="0"cellpadding="4"border="0"style="background-color:#000;"><tbody>';
					while($searchRow=$result1->fetch_assoc()){ 
						$lastonline = strtotime($curDate)-strtotime($searchRow['last_online']);
						if ($lastonline <= 300) {
						echo '<tr class="searchColumn"><td><img style="vertical-align:middle; width:40px;" src="/assets/images/avatars/'?><?php echo $searchRow["id"];
						echo '.png?c=';
						echo $searchRow['avatar_id']; 
						echo '">';
						echo '<a style="color:black;" href="/user?id=' . $searchRow['id'] . '">' . $searchRow['username'] . '</a></td>';
						echo '<td style="text-align:center;"><p>'; if($searchRow['description'] > null) {echo substr(htmlentities($searchRow['description']),0,75) , str_repeat("...",(strlen($searchRow['description']) >= 75)); }
						echo'</p></td>';
						if ($lastonline <= 300) {echo '</tbody>';}
						else {echo '</tbody>';}
					}
				}echo '</table>';

if(isset($_GET['search'])) {
					echo '<div class="numButtonsHolder" style="margin-left:auto;margin-right:auto;margin-top:10px;">';
					if($page-2 > 0) {
					    echo '<a style="color:#333;" href="?search='.$query.'&page=0">1</a> ... ';
					}
					if($count/20 > 1) {
				          for($i = max($page-2,0); $i < min($count/20,$page+2); $i++)
				          {
				            echo '<a style="color:#333;" href="?search='.$query.'&page='.($i+1).'">'.($i+1).'</a> ';
				          }
				        }
				        if($count/20 > 4) {
				            echo '... <a style="color:#333;" href="?search='.$query.'&page='.round($count/20).'">'.round($count/20).'</a> ';
				        }
					
					echo '</div>';
				}

				?>
				</div>
			</div>
		</div>
