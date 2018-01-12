$(function() {
	
	// filter movie list when text entered in search field
	$('#movieSearch').on('input', function(){

		var matchString = $(this).val().trim().toLowerCase();
		var $movies = $('.js-movie');

		if (matchString === ""){
			$movies.show();
			return;
		}

		$movies.each(function(){
			
			var $this = $(this);
			var matchFound = false;
			
			$this.hide();
			
			$this.find('.js-searchable').each(function(){
				
				if ($(this).text().toLowerCase().includes(matchString)) {
					matchFound = true;
				}
			});
			
			if (matchFound) {
				$this.show();
			}
		});
	});
	
	// initialize tablesorter plugin
	$('#movieTable').tablesorter({
        headers: { 
            4: { 
                sorter: false 
            }
        } 
    });
	
	// load film description from OMDB when movie title clicked
	$('.js-get-description').on('click', function(){
		$.getJSON('http://www.omdbapi.com/?t=' + encodeURI($(this).text()) + '&apikey=b71e0a07').then(function(response){
			$('#movieDescription').empty().html('<b>' + response.Title + '</b> (' + response.Year + ') ' + response.Plot);
		});
	});
});