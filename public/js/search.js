$(function(){
	//BUILD MAP
	var show_map = false;
	var map;
	var mapOptions = {
			zoom: 6,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

	map = new google.maps.Map(('#map_canvas'),mapOptions);	

	//ONLY SUBMIT FORM VIA AJAX
	$('#get_location_form').submit(function() {
		if ($("#cur_loc_lat").val() && $("#cur_loc_lon").val()) {
			search();
		} else {
			alert('Please enter your latitude and longitude');
		}
		return false;
	});

	/*FILTER ALL INPUTS BEFORE POST*/
    $('.point').bind('input', function() {
    	$(this).val($(this).val().replace(/[^0-9.-]/gi, ''));
    });	

    $('.local').bind('input', function() {
    	$(this).val($(this).val().replace(/[^a-z0-9,. '-]/gi, ''));
    });	
    
	function search() {
		$.ajax({
			url:"ajaxsearch",
			type:"POST",
			data:$(".search_param").serialize(),
			success: function(msg) {
				$("#local_image_list").html('');
				$("#local_image_list").html(msg);
				show_map = true;
			} 
		});
	}

	
	$('#get_location').click(function() {
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
				$('#cur_loc_lat').val(position.coords.latitude);
				$('#cur_loc_lon').val(position.coords.longitude);
				map.setCenter(pos);
			}, function() {
				handleNoGeolocation(true);
			});
		} else {
			handleNoGeolocation(false);
		}
	});

	//INFORM USER THERE BROWSER SUCKS	
	function handleNoGeolocation(errorFlag) {
		if (errorFlag) {
			var content = 'Error: The Geolocation service failed.';
		} else {
			var content = 'Error: Your browser doesn\'t support geolocation.';
		}

		if (show_map) {
		  var options = {
				map: map,
				position: new google.maps.LatLng(60, 105),
				content: content
			};
		
			var infowindow = new google.maps.InfoWindow(options);
			map.setCenter(options.position);
		}
		alert(content);
	}
});