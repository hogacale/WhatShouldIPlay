displayNewGames();

function displayNewGames(){
	console.log("Refreshing page");
	let params = new URLSearchParams(location.search);
	var gameId = params.get('gameId');
	
	
	getData('http://localhost/whatshouldiplay2/gameApi.php?type=gameView&gameId='+gameId).then(function(response) {
		console.log(response);
		
		const apiResponse = JSON.parse(response);
		if (apiResponse.length > 0) {
			const tRows = prepareHTMLContent(apiResponse);
			return true;
		}
		return false;
	});
	//console.log('apiResp: ' + apiResponse);
}


function getData(url) {
	if (url) {
		const task = new Promise( function(resolve, reject) {
		const req = new XMLHttpRequest();
		req.open('GET', url);
		req.send();
		req.onload = function(){
			req.status === 200 ? resolve(req.response) : reject(Error(req.statusText));
		}
		req.onerror = function(e) { reject(Error(`Network Error: ${e}`));} 
		});
		return task;
	}
	return false;
}

function prepareHTMLContent(list) {
	let output = "";
	for(let i in list ) {
	const games = list[i];
		document.getElementById('gamePage-gameName').innerHTML = games.name;
		document.getElementById('gamePage-description').innerHTML = games.description;
		document.getElementById('gamePage-releaseDate').innerHTML = games.releaseDate;
		document.getElementById('gamePage-publisher').innerHTML = games.publisherName;
		document.getElementById('gamePage-genres').innerHTML = games.genreName;
		document.getElementById('gamePage-categories').innerHTML = games.categoryName;
		document.getElementById('gamePage-platforms').innerHTML = games.platformName;
		document.getElementById('gamePage-postiveRatings').innerHTML = games.totalPositive;
		document.getElementById('gamePage-negativeRatings').innerHTML = games.totalNegative;
		document.getElementById('gamePage-averageRatings').innerHTML = games.averageRatings;
		document.getElementById('gamePage-gamePrice').innerHTML = "$" + games.price;
		
		//output += `<tr><td>${games.name}</td><td>${games.publisherName}</td><td>${games.averageRatings}</td><td>${games.price}</td><td>${games.genreName}</td></tr>`;
	}
	return output;
}

//function prepareHTMLContent(list) {
//	let output = "";
//	for(let i in list ) {
//	const games = list[i];
//		output += `<tr><td>${games.name}</td><td>${games.publisherName}</td><td>${games.averageRatings}</td><td>${games.price}</td><td>${games.genreName}</td></tr>`;
//	}
//	return output;
//}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function addToCart(){
	let params = new URLSearchParams(location.search);
	var gameId = params.get('gameId');
	let userId = sessionStorage.getItem('userId');
	console.log(userId + gameId);
	
	
	getData('http://localhost/whatshouldiplay2/gameApi.php?type=AddtoCart&gameId='+gameId + '&userId=' + userId).then(function(response) {
		console.log(response);
		
		const apiResponse = JSON.parse(response);
		if (apiResponse.length > 0) {
			const tRows = prepareHTMLContent(apiResponse);
			return true;
		}
		return false;
	});
	
	alert("Item added to cart");
}