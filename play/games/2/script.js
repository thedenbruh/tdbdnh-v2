document.getElementById("userrows").addEventListener("keyup", function(){
		document.getElementById("userbombs").setAttribute("placeholder", "max "+document.getElementById("userrows").value*document.getElementById("usercols").value);
		if(document.getElementById("userrows").value > 30){
			document.getElementById("userrows").style.background = "red";
		}
		else{
			document.getElementById("userrows").style.background = "white";	
		}
}); 
document.getElementById("usercols").addEventListener("keyup", function(){
		document.getElementById("userbombs").setAttribute("placeholder", "max "+document.getElementById("userrows").value*document.getElementById("usercols").value);
		if(document.getElementById("usercols").value > 30){
			document.getElementById("usercols").style.background = "red";
		}
		else{
			document.getElementById("usercols").style.background = "white";	
		}
}); 
document.getElementById("userbombs").addEventListener("keyup", function(){
	if(document.getElementById("userbombs").value > document.getElementById("userrows").value*document.getElementById("usercols").value || document.getElementById("userbombs").value == 0){
		document.getElementById("userbombs").style.background = "red";
	}
	else{
		document.getElementById("userbombs").style.background = "white";	
	}
});

function startgame(){

	var rows = document.getElementById("userrows").value;
	var cols = document.getElementById("usercols").value;
	var bombs = document.getElementById("userbombs").value;

	document.getElementById("userrows").value = "";
	document.getElementById("usercols").value = "";
	document.getElementById("userbombs").value = "";

	if(bombs >= (rows*cols) || bombs == 0 || rows > 30 || cols > 30){alert("Invalid entry(ies)!"); location.reload();}

	var table = document.getElementsByTagName("table")[0];

	//creating the rows x cols table as required
	for(i=1;i<=rows;i++){
		var tr = document.createElement("tr");
		table.appendChild(tr);
		for(j=1;j<=cols;j++){
			var currenttr = document.getElementsByTagName("tr")[i-1];
			var td = document.createElement("td");
			currenttr.appendChild(td);
		}
	}

	//planting the bombs
	for(i=1;i<=bombs;i++){
		var randx, randy;
		function randtwodigNum(){
			var x = Math.floor(Math.random()*100);
			var y = Math.floor(Math.random()*100);
			if(x > rows || x < 1){
				randtwodigNum();
			}
			else if(y > cols || y < 1){
				randtwodigNum();
			}
			else{
				if(document.getElementsByTagName("tr")[x-1].childNodes[y-1].className == 'bomb'){
					randtwodigNum();
				}
				else{
					randx = x; randy = y;
				}
			}
		}
		randtwodigNum();
		
		document.getElementsByTagName("tr")[randx-1].childNodes[randy-1].className = 'bomb';
	}

	//adding the number of mines in the vicinity of a particular tile
	for(i=1;i<=rows;i++){
		for(j=1;j<=cols;j++){
			var bombcount = 0;
			for(p=i-1;p<=i+1;p++){
				for(q=j-1;q<=j+1;q++){
					if(p == i && q == j){continue;}

					else{
						if(p<=0 || q<=0 || p>rows || q>cols){continue;}
						else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className == 'bomb'){
							bombcount++;
						}
					}
				}
			}
			if(bombcount == 0){
				if(document.getElementsByTagName("tr")[i-1].childNodes[j-1].className != "bomb"){
					document.getElementsByTagName("tr")[i-1].childNodes[j-1].className = "empty";
				}
			}
			else{
				document.getElementsByTagName("tr")[i-1].childNodes[j-1].innerHTML = bombcount;
			}
			
		}
	}


	//function to be called on clicking a tile
	// $('td').on("click",function(){
	// 	if(this.className == 'bomb'){
	// 		for(i=0;i<bombs;i++){
	// 			document.getElementsByClassName("bomb")[i].style.background = 'red';
	// 		}
	// 		setTimeout(function(){alert("game over, play again");location.reload();}, 500);
	// 	}

	// 	else{
	// 		this.setAttribute("id", "selected");
	// 		this.classList.add("open");
	// 		var a,b;
	// 		for(i=1;i<=rows;i++){
	// 			for(j=1;j<=cols;j++){
	// 				if(document.getElementsByTagName("tr")[i-1].childNodes[j-1].id == 'selected'){
	// 					a = i;
	// 					b = j;
	// 					break;
	// 				}
	// 			}
	// 		}


	// 		function digging(x,y){
	// 			for(p=x-1;p<=x+1;p++){
	// 			for(q=y-1;q<=y+1;q++){
	// 				if(p == x && q == y){continue;}

	// 				else{
	// 					if(p<=0 || q<=0 || p>rows || q>cols){continue;}
	// 					else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className == 'empty'){
	// 						document.getElementsByTagName("tr")[p-1].childNodes[q-1].className = "empty open";
	// 						var l = p;
	// 						var m = q;
	// 						digging(l,m);
	// 						digging(l,m);
	// 						digging(l,m);
	// 						digging(l,m);
	// 						digging(l,m);
	// 						digging(l,m);
	// 					}
	// 					else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className == "empty open"){
	// 						continue;
	// 					}
	// 					else{
	// 						continue;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		}
	// 		digging(a,b);
	// 		digging(a,b);
	// 		digging(a,b);
	// 		digging(a,b);
	// 		digging(a,b);
	// 		digging(a,b);

	// 		var emptytiles = 0;
	// 		for(i=1;i<=rows;i++){
	// 			for(j=1;j<=cols;j++){
	// 				if(document.getElementsByTagName("tr")[i-1].childNodes[j-1].className == 'empty open'){
	// 					for(p=i-1;p<=i+1;p++){
	// 			for(q=j-1;q<=j+1;q++){
	// 				if(p == i && q == j){continue;}

	// 				else{
	// 					if(p<=0 || q<=0 || p>rows || q>cols){continue;}
	// 					else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className != 'bomb' && document.getElementsByTagName("tr")[p-1].childNodes[q-1].className != 'empty open'){
	// 						document.getElementsByTagName("tr")[p-1].childNodes[q-1].className = 'open';
	// 					}
	// 				}
	// 			}
	// 		}
	// 				}
	// 			}
	// 		}
	// 		this.removeAttribute("id");
	// 	}

	// 	var remaining = 0;

	// 	for(i=0;i<rows;i++){
	// 		for(j=0;j<cols;j++){
	// 			if(document.getElementsByTagName("tr")[i].childNodes[j].className != 'open' && document.getElementsByTagName("tr")[i].childNodes[j].className != 'empty open'){
	// 				remaining++;
	// 			}
	// 		}
	// 	}
	// 	if(remaining == bombs){
	// 		alert("you have won the game");
	// 		for(i=0;i<bombs;i++){
	// 			document.getElementsByClassName("bomb")[i].style.background = 'red';
	// 		}
	// 		setTimeout(function(){location.reload();}, 500);
	// 	}
	// });

	function tileClick(){
		if(this.className == 'bomb'){
			for(i=0;i<bombs;i++){
				document.getElementsByClassName("bomb")[i].style.background = 'red';
			}
			setTimeout(function(){alert("game over, play again");location.reload();}, 500);
		}

		else{
			this.setAttribute("id", "selected");
			this.classList.add("open");
			var a,b;
			for(i=1;i<=rows;i++){
				for(j=1;j<=cols;j++){
					if(document.getElementsByTagName("tr")[i-1].childNodes[j-1].id == 'selected'){
						a = i;
						b = j;
						break;
					}
				}
			}


			function digging(x,y){
				for(p=x-1;p<=x+1;p++){
				for(q=y-1;q<=y+1;q++){
					if(p == x && q == y){continue;}

					else{
						if(p<=0 || q<=0 || p>rows || q>cols){continue;}
						else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className == 'empty'){
							document.getElementsByTagName("tr")[p-1].childNodes[q-1].className = "empty open";
							var l = p;
							var m = q;
							digging(l,m);
							digging(l,m);
							digging(l,m);
							digging(l,m);
							digging(l,m);
							digging(l,m);
						}
						else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className == "empty open"){
							continue;
						}
						else{
							continue;
						}
					}
				}
			}
			}
			digging(a,b);
			digging(a,b);
			digging(a,b);
			digging(a,b);
			digging(a,b);
			digging(a,b);

			var emptytiles = 0;
			for(i=1;i<=rows;i++){
				for(j=1;j<=cols;j++){
					if(document.getElementsByTagName("tr")[i-1].childNodes[j-1].className == 'empty open'){
						for(p=i-1;p<=i+1;p++){
				for(q=j-1;q<=j+1;q++){
					if(p == i && q == j){continue;}

					else{
						if(p<=0 || q<=0 || p>rows || q>cols){continue;}
						else if(document.getElementsByTagName("tr")[p-1].childNodes[q-1].className != 'bomb' && document.getElementsByTagName("tr")[p-1].childNodes[q-1].className != 'empty open'){
							document.getElementsByTagName("tr")[p-1].childNodes[q-1].className = 'open';
						}
					}
				}
			}
					}
				}
			}
			this.removeAttribute("id");
		}

		var remaining = 0;

		for(i=0;i<rows;i++){
			for(j=0;j<cols;j++){
				if(document.getElementsByTagName("tr")[i].childNodes[j].className != 'open' && document.getElementsByTagName("tr")[i].childNodes[j].className != 'empty open'){
					remaining++;
				}
			}
		}
		if(remaining == bombs){
			alert("you have won the game");
			for(i=0;i<bombs;i++){
				document.getElementsByClassName("bomb")[i].style.background = 'red';
			}
			setTimeout(function(){location.reload();}, 500);
		}
	}

	for(i=0;i<document.getElementsByTagName("td").length;i++){
		document.getElementsByTagName("td")[i].addEventListener("click", tileClick);
	}

			var prevcontent;
	for(i=0;i<document.getElementsByTagName("td").length;i++){
		document.getElementsByTagName("td")[i].addEventListener("contextmenu", function(e){
			e = window.event;
			e.preventDefault();

			if(this.innerHTML == "<img src=\"flag.svg\">"){
				this.innerHTML = prevcontent;
			}
			else if(!this.classList.contains("open")){
				prevcontent = this.innerHTML;
				this.innerHTML = "<img src = 'flag.svg'>";
			}
		});
	}
}
