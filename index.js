displayNewGames();

function previousPage(){
  let params = new URLSearchParams(location.search);
	var search = params.get('search');
	var page = params.getAll('page');
  const url = new URL(window.location);
	let params1 = new URLSearchParams(url.search);
	params1.set('search',search);
  if(page > 0)
	 params1.set('page',page - 1);
  url.search = params1;
	history.pushState({}, '', url);
	document.getElementById('pageNumber').innerHTML = page;	
  displayNewGames();
}

function nextPage(){
  let params = new URLSearchParams(location.search);
	var search = params.get('search');
	var page = params.getAll('page');
	page = parseInt(page);
	console.log(page);
	if(isNaN(page))
		page = 0;
  const url = new URL(window.location);
	let params1 = new URLSearchParams(url.search);
	page = page + 1;
	params1.set('search',search);
	params1.set('page',parseInt(page));
  url.search = params1;
  history.pushState({}, '', url);

	document.getElementById('pageNumber').innerHTML = page;		
  displayNewGames();
}

function changeFilter() {
	let params = new URLSearchParams(location.search);
	var search = params.get('search');
	var genre = params.get('genre');
	var publisher = params.get('publisher');
	var rating = params.get('rating');
	var page = 0;
	document.getElementById('pageNumber').innerHTML = page;	
	search = document.getElementById('search').value;
	genre = document.getElementById('genre').value;
	publisher = document.getElementById('publisher').value;
	rating = document.getElementById('rating').value;
	
  	if(search != null)
	 	document.getElementById('search').value = search;
	if(genre != null)
		document.getElementById('genre').value = genre;
	if(publisher != null)
  		document.getElementById('publisher').value = publisher;
  	if(rating != null)
  		document.getElementById('rating').value = rating
  		
	const url = new URL(window.location);
	let params1 = new URLSearchParams(url.search);
	params1.set('search',search);
	params1.set('page',page);
	params1.set('genre',genre);
	params1.set('publisher',publisher);
	params1.set('rating',rating);
  	url.search = params1;
	history.pushState({}, '', url);
	
  	displayNewGames();
}

function displayNewGames(){
	console.log("Refreshing page");
	let params = new URLSearchParams(location.search);
	var search = params.get('search');
	page = params.getAll('page');
	var genre = params.get('genre');
	var publisher = params.get('publisher');
	var rating = params.get('rating');
	
	if(search === "")
		search = null;
	if(genre === "")
		genre = null;
	if(publisher == "")
		publisher = null;
	if(rating == "")
		rating = null;
		
	//console.log("Genre: " + genre);
	//console.log("Search: " + search);
	//console.log("Page: " + page);
	//console.log('http://localhost/whatshouldiplay2/gameApi.php?type=search&search='+search+'&page='+page + '&genre=' + genre + '&publisher=' + publisher + '&rating=' + rating);
	getData('http://localhost/whatshouldiplay2/gameApi.php?type=search&search='+search+'&page='+page + '&genre=' + genre + '&publisher=' + publisher + '&rating=' + rating).then(function(response) {
		//console.log(response);
		
		const apiResponse = JSON.parse(response);
		if (apiResponse.length > 0) {
			const tRows = prepareHTMLContent(apiResponse);
			document.getElementById('gamelist').innerHTML = tRows;
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
		output += `<tr><td>${games.name}</td><td>${games.publisherName}</td><td>${games.averageRatings}</td><td>${games.price}</td><td>${games.genreName}</td><td><button onClick="gotoGameViewPage(this.id)" id=${games.gameId}>More Info</button></td></tr>`;
	}
	return output;
}

function gotoGameViewPage(clicked_id){
	location.replace(location.origin + "/whatshouldiplay2/gameView.html?gameId=" + clicked_id);
}