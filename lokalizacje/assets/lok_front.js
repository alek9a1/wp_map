(function($){

	$('.woj').click(function(){
		//$('.wojewodztwa').slideDown(100);
    $('.wojewodztwa').slideToggle( "slow" );
	});

	$('.mias').click(function(){
		//$('.miasta').slideDown(100);

    $('.miasta').slideToggle( "slow" );
	});




	$('body').on('click','.miasta li',function(e){
		$('.miasta').slideUp();
		var wybraneMiasto = $(e.currentTarget).attr('data-id');
		//console.log(wybraneMiasto);
		$('.lista_sklepow .single_sklep').hide();
		$('.lista_sklepow .single_sklep[data-id="'+wybraneMiasto+'"]').show();

    var thisNazwa = $(e.currentTarget).text();
    $('.mias').text(thisNazwa);


	});

	function initMap(dane, przyblizenie) {

    var gdzie = dane[0];

	 if (przyblizenie === undefined) {
        przyblizenie = 8;
    }

    if (przyblizenie === 'cala') {
        przyblizenie = 6;
        gdzie[7] = '52.5503193,19.721267500000067';
    }

	   
	   console.log(gdzie);
    var lati = gdzie[7].split(",");
    //console.log(parseFloat(lati[0])+' '+parseFloat(lati[1]));

    if (parseFloat(lati[0])) {
    	positioner = {lat: parseFloat(lati[0]), lng: parseFloat(lati[1])}
    } else {
    	positioner = {lat: 50, lng: 19}
    }


	  var map = new google.maps.Map(document.getElementById('map'), {
	    zoom: przyblizenie,
	    center: positioner 
	  });

	  setMarkers(map,dane);
	}

// Data for the markers consisting of a name, a LatLng and a zIndex for the
// order in which these markers should display on top of each other.

function setMarkers(map,dane) {

	var beaches = dane;
  // Adds markers to the map.

  // Marker sizes are expressed as a Size of X,Y where the origin of the image
  // (0,0) is located in the top left of the image.

  // Origins, anchor positions and coordinates of the marker increase in the X
  // direction to the right and in the Y direction down.
  var image = {
    url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(20, 32),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };

   var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.
 
  for (var i = 0; i < beaches.length; i++) {
    var beach = beaches[i];
    var lati = beach[7].split(",");
    //console.log(parseFloat(lati[0])+' '+parseFloat(lati[1]));
    if (beach[0]) {
    	contentString = '<h2>'+beach[0]+'</h2>ul. '+beach[2]+'<br>'+beach[5]+' '+beach[1]+'<br>tel.: '+beach[3]+'<br>mail: '+beach[4]+'   ';
    } else {
    	contentString = '';
    }

    var marker = new google.maps.Marker({
      position: {lat: parseFloat(lati[0]), lng: parseFloat(lati[1])},
      map: map,
      shape: shape,
      title: beach[0],
      zIndex: i
    });
    var prev_infowindow =false; 
    var infowindow = new google.maps.InfoWindow()

    google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow){ 
	    return function() {
	    	if( prev_infowindow ) {
          		 prev_infowindow.close();
        	}

        prev_infowindow = infowindow;

	        infowindow.setContent(contentString);
	        infowindow.open(map,marker);
	    };
	})(marker,contentString,infowindow));
	    

    

  }
}
	$('body').on('click','.single_sklep', function (e) {
		$('.single_sklep').removeClass('on');
		$(e.currentTarget).addClass('on');
		var thisone = $(e.currentTarget).attr('pozycja');

		var name = $(e.currentTarget).attr('pozycja');
		var ramk = $(e.currentTarget).data('ramka');

		

		var ramka = ramk.split(",");

		console.log(ramka);

		var data = [[ramka[0], ramka[1], ramka[2], ramka[3], ramka[4],'','', thisone]]
		initMap(data, 12);
	});

	

	$('body').on('click','.wojewodztwa li', function (e) {

			var loading = $('<div class="loader-box" style="z-index: 888"><div class="loader"></div></div>');

			$('.wojewodztwa').slideUp(100);
			$('.miasta').slideUp();

			$('.szukajka').append(loading);

			var thisone = $(e.currentTarget).attr('data-id');
			var thisNazwa = $(e.currentTarget).text();

			$('.woj').text(thisNazwa);

			//console.log('wyb: '+thisone);

            var dataString = {
                action:'getMiasta',
                woj: thisone
            };

            var urlik = $('#gdzie_kupic').attr('home-url')+"/wp-admin/admin-ajax.php";
            $.ajax({
            type:"POST",
            url: urlik,
            dataType : 'json',
            data: dataString,
            success:function(data){
                
              console.log(data);
            	$('.miasta, .lista_sklepow > .row').html('');
            	var a = data[0];
               
      				for (let index = 0; index < a.length; ++index) {
      				    let value = a[index];
      				    $('.miasta').append('<li data-id="'+value+'">'+value+'</li>');
      				}

      				var b = data[1];
      				for (let index = 0; index < b.length; ++index) {
      				    let value = b[index];
      				    $('.lista_sklepow > .row').append('\
      				    	<div data-ramka="'+b[index]+'" pozycja="'+b[index][7]+'" class="col-md-12 single_sklep mb-5" data-id="'+b[index][1]+'">\
      				    	<div class="row"><div class="col-lg-6"><span class="nazwa">'+b[index][0]+'</span><br>ul. '+b[index][2]+'<br>'+b[index][5]+' '+b[index][6]+'</div>\
      				    	<div class="col-lg-6">tel.: '+b[index][3]+'<br>mail: '+b[index][4]+'</div></div></div>');
      				}

      				$('.szukajka').find('.loader-box').remove();
              if (thisone == 'cala') {
                  initMap(data[1], thisone);
              } else {
                 initMap(data[1]);
              }
      				

            }

            });

});


  $('[data-id="cala"]').click();



	var mapkaFloat = $('.floater');

if (mapkaFloat.length > 0 && $(window).width() > 1200 ) {

var fixmeTop = mapkaFloat.offset().top;
var szerokosc = mapkaFloat.width();
$(window).scroll(function() {  

var currentScroll = $(window).scrollTop();  
var fixmeLeft = mapkaFloat.offset(); 
var lewa = fixmeLeft.left;



    if (currentScroll >= fixmeTop) {           
        mapkaFloat.css({                      
            position: 'fixed' ,
            top: '20px',
            left: lewa,
            width: szerokosc 
        });
    } else {                                   
        mapkaFloat.css({                     
            position: 'static'
        });
    }

});

}

})(jQuery);