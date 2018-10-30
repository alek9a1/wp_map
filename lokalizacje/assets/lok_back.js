(function($){

	var GOOGLE_MAP_KEY = "AIzaSyAV32EjqhtN04hf12oUDOPKTdZnEzuyeZk";

	function loadScript() {
	  var script = document.createElement('script');
	  script.type = 'text/javascript';
	  script.src = 'https://maps.googleapis.com/maps/api/js?key='+GOOGLE_MAP_KEY+''; //& needed
	  document.body.appendChild(script);
	}

	window.onload = loadScript;



	$('#wpcf-miejscowosc').focus(function() {
    	//console.log('in');
	}).blur(function() {
		var adres = $(this).val()+', '+$('#wpcf-ulica').val();
		console.log(adres);
	    var geocoder = new google.maps.Geocoder();

	    geocoder.geocode( { 'address': adres}, function(results, status) {
	    	if (status == google.maps.GeocoderStatus.OK) {
			    var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
			    $('#wpcf-pozycja').val(latitude+','+longitude);
			 } 
		});    
	});
	

})(jQuery);