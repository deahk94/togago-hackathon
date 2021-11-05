var cityName;
var destinationId;
var lat;
var lon;
var page = 1;

fetch("https://geoip.aposcb.org/api/", {
	"method": "GET",
	// "headers": {
	// 	"x-rapidapi-host": "hotels-com-provider.p.rapidapi.com",
	// 	"x-rapidapi-key": "f98d58e245msh822a7db8cd5a5a7p186255jsn76c1ff16b0cf"
	// }
})
.then(response => {
	return response.json();
}).
then(data => {
	console.log(data);
	if (document.getElementById("cityName") && !document.getElementById("cityName").value) document.getElementById("cityName").value = data.city;
	cityName = data.city;
	lat = data.lat;
	lon = data.lon;
})
.catch(err => {
	console.error(err);
});

function search()
{
	fetch("https://hotels-com-provider.p.rapidapi.com/v1/destinations/search?query=" + $("#cityName").val() + "&currency=USD&locale=en_US", {
		"method": "GET",
		"headers": {
			"x-rapidapi-host": "hotels-com-provider.p.rapidapi.com",
			"x-rapidapi-key": "f98d58e245msh822a7db8cd5a5a7p186255jsn76c1ff16b0cf"
		}
	})
	.then(response => {
		return response.json();
	}).
	then(data => {
		destinationId = data.suggestions[0].entities[0].destinationId;
		searchAPI(true);
	})
	.catch(err => {
		console.error(err);
	});
}

function searchAPI(resetList = false)
{
	//event.preventDefault();
	var queryParam = "?locale=en_US&currency=USD&page_number=" + page;
		queryParam += "&destination_id=" + destinationId;
		if ($("#checkInDate").val()) {
			queryParam += "&checkin_date=" + $("#checkInDate").val();
		}

		if ($("#checkOutDate").val()) {
			queryParam += "&checkout_date=" + $("#checkOutDate").val();
		}

		if ($("#sortBy").val()) {
			queryParam += "&sort_order=" + $("#sortBy").val();
		}

		if ($("#guests").val()) {
			queryParam += "&adults_number=" + $("#guests").val();
		}

		if ($("#minPrice").val()) {
			queryParam += "&price_min=" + $("#minPrice").val();
		}

		if ($("#maxPrice").val()) {
			queryParam += "&price_max=" + $("#maxPrice").val();
		}

		console.log(queryParam);
		const settings = {
			"async": true,
			"crossDomain": true,
			"url": "https://hotels-com-provider.p.rapidapi.com/v1/hotels/search" + queryParam,
			"method": "GET",
			"headers": {
				"x-rapidapi-host": "hotels-com-provider.p.rapidapi.com",
				"x-rapidapi-key": "f98d58e245msh822a7db8cd5a5a7p186255jsn76c1ff16b0cf"
			}
		};

		$.ajax(settings).done(function (response) {
			console.log(response);
			// $("#searchButton").prop("disabled",false);
			if (resetList)
				$('#hotelList').empty();

			if (response.searchResults.results.length < 0) {
				$('#hotelList').append('<h4 id="searchResult">No search result!</h4>');
				return;
			}

			$("#continueSearch").remove();

			for (var i = 0; i < response.searchResults.results.length; i++) {
				var hotelItem = response.searchResults.results[i];
				$('#hotelList').append('<div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms"><div class="room-thumbnail"><img src="' + hotelItem.optimizedThumbUrls.srpDesktop + '" alt="" width=365 height=264.02></div><div class="room-content"><h2>' + hotelItem.name + '</h2><h4>' + hotelItem.ratePlan.price.current + '$ <span>/ Day</span></h4><div class="room-feature"><h6>Rating: <span>' + hotelItem.starRating + '</span></h6><h6>Area: <span>' + hotelItem.neighbourhood + '</span></h6><h6>Address: <span>' + (hotelItem.address.streetAddress ?? "") + " " + (hotelItem.address.locality ?? "") + " " + (hotelItem.address.postalCode ?? "") + " " + (hotelItem.address.region ?? "") + '</span></h6></div><a href="#" class="btn view-detail-btn">View Details <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div></div>');
			}

			page++;
			$('#hotelList').append('<button id="continueSearch" onclick="searchAPI()" class="btn roberto-btn w-100">Load More</button><br><br>');
		})
		.error(function (error) {
			$('#hotelList').empty();
			$('#hotelList').append('<h4 id="searchResult">Search Error!</h4>');
		});
}

function nearby()
{
	nearbyAPI(true);
}

function nearbyAPI(resetList = false)
{
	//event.preventDefault();
	var queryParam = "?locale=en_US&currency=USD&page_number=" + page;
		queryParam += "&latitude=" + lat + "&longitude=" + lon;
		if ($("#checkInDate").val()) {
			queryParam += "&checkin_date=" + $("#checkInDate").val();
		}

		if ($("#checkOutDate").val()) {
			queryParam += "&checkout_date=" + $("#checkOutDate").val();
		}

		if ($("#sortBy").val()) {
			queryParam += "&sort_order=" + $("#sortBy").val();
		}

		if ($("#guests").val()) {
			queryParam += "&adults_number=" + $("#guests").val();
		}

		if ($("#minPrice").val()) {
			queryParam += "&price_min=" + $("#minPrice").val();
		}

		if ($("#maxPrice").val()) {
			queryParam += "&price_max=" + $("#maxPrice").val();
		}

		console.log(queryParam);
		const settings = {
			"async": true,
			"crossDomain": true,
			"url": "https://hotels-com-provider.p.rapidapi.com/v1/hotels/nearby" + queryParam,
			"method": "GET",
			"headers": {
				"x-rapidapi-host": "hotels-com-provider.p.rapidapi.com",
				"x-rapidapi-key": "f98d58e245msh822a7db8cd5a5a7p186255jsn76c1ff16b0cf"
			}
		};

		$.ajax(settings).done(function (response) {
			console.log(response);
			// $("#searchButton").prop("disabled",false);
			if (resetList)
				$('#hotelList').empty();

			if (response.searchResults.results.length < 0) {
				$('#hotelList').append('<h4 id="searchResult">No search result!</h4>');
				return;
			}

			$("#continueNearby").remove();

			for (var i = 0; i < response.searchResults.results.length; i++) {
				var hotelItem = response.searchResults.results[i];
				$('#hotelList').append('<div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms"><div class="room-thumbnail"><img src="' + hotelItem.optimizedThumbUrls.srpDesktop + '" alt="" width=365 height=264.02></div><div class="room-content"><h2>' + hotelItem.name + '</h2><h4>' + hotelItem.ratePlan.price.current + '$ <span>/ Day</span></h4><div class="room-feature"><h6>Rating: <span>' + hotelItem.starRating + '</span></h6><h6>Area: <span>' + hotelItem.neighbourhood + '</span></h6><h6>Address: <span>' + (hotelItem.address.streetAddress ?? "") + " " + (hotelItem.address.locality ?? "") + " " + (hotelItem.address.postalCode ?? "") + " " + (hotelItem.address.region ?? "") + '</span></h6></div><a href="#" class="btn view-detail-btn">View Details <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div></div>');
			}

			page++;
			$('#hotelList').append('<button id="continueNearby" onclick="nearbyAPI()" class="btn roberto-btn w-100">Load More</button><br><br>');
		})
		.error(function (error) {
			$('#hotelList').empty();
			$('#hotelList').append('<h4 id="searchResult">Search Error!</h4>');
		});
}

$("#searchButton").click(function () {
	//event.preventDefault();
	search();
	// $("#searchButton").prop("disabled",true);
});

$("#nearbyButton").click(function () {
	//event.preventDefault();
	nearby();
	// $("#searchButton").prop("disabled",true);
});

// $("#continueSearch").click(function () {
// 	event.preventDefault();
// 	searchAPI();
// 	// $("#searchButton").prop("disabled",true);
// });
