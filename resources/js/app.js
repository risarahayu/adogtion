require('./bootstrap');

import 'select2';

import Swal from 'sweetalert2';
window.Swal = Swal;

import Toastify from 'toastify-js';
window.Toastify = Toastify;

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

window.toastify = function (type, message) {
  Toastify({
    text: message,
    duration: 3000,
    destination: "https://github.com/apvarun/toastify-js",
    newWindow: true,
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "center", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    className: "bg-"+type+" bg-gradient",
    style: {
      "margin-top": "80px"
    },
    onClick: function(){} // Callback after click
  }).showToast();
}

$(function() {
  $('.select2').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
  });

  $('.area-select2').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    tags: true,
  });
})

// GOOGLE MAP API
var map;
var geocoder;
var markers = [];

$(function() {
  initMap();
});

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), { zoom: 18 });
  geocoder = new google.maps.Geocoder();

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      map.setCenter(pos);

      var marker = new google.maps.Marker({
        map: map,
        position: pos,
        draggable: true
      });

      marker.addListener('dragend', function() {
        updateMapLink(marker.getPosition().lat(), marker.getPosition().lng());
      });

      markers.push(marker);

      updateMapLink(pos.lat, pos.lng);

      // Menampilkan kecamatan dari lokasi saat ini
      geocoder.geocode({ 'location': pos }, function(results, status) {
        if (status === 'OK') {
          var kecamatan = findAddressComponent(results[0], 'administrative_area_level_3');
          if (kecamatan) {
            $('.selected-kecamatan').val(kecamatan.replace("Kecamatan ", ""));
          }
        }
      });
    }, function() {
      handleLocationError(true, map.getCenter());
    });
  } else {
    handleLocationError(false, map.getCenter());
  }

  var input = document.getElementById('addressInput');
  var autocomplete = new google.maps.places.Autocomplete(input);

  autocomplete.addListener('place_changed', function() {
    searchAddress();
  });
}

function handleLocationError(browserHasGeolocation, pos) {
  alert(browserHasGeolocation
    ? 'Error: The Geolocation service failed.'
    : 'Error: Your browser doesn\'t support geolocation.');
}

function searchAddress() {
  var address = $('#addressInput').val();

  geocoder.geocode({'address': address}, function(results, status) {
    if (status === 'OK') {
      clearMarkers();
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location,
        draggable: true
      });

      marker.addListener('dragend', function() {
        updateMapLink(marker.getPosition().lat(), marker.getPosition().lng());
      });

      markers.push(marker);
      updateMapLink(marker.getPosition().lat(), marker.getPosition().lng());

      // Menampilkan nama kecamatan
      var kecamatan = findAddressComponent(results[0], 'administrative_area_level_3');
      if (kecamatan) {
        $('.selected-kecamatan').val(kecamatan.replace("Kecamatan ", ""));
      } else {
        $('.selected-kecamatan').val('');
      }
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function updateMapLink(lat, lng) {
  var mapLinkElement = $('.map-link'); // Menggunakan class .map-link
  var mapLink = `https://www.google.com/maps?q=${lat},${lng}`;
  mapLinkElement.val(mapLink); // Menggunakan .val() untuk input hidden

  // Menampilkan kecamatan dari lokasi saat ini
  geocoder.geocode({ 'location': { lat: lat, lng: lng } }, function(results, status) {
    if (status === 'OK') {
      var kecamatan = findAddressComponent(results[0], 'administrative_area_level_3');
      if (kecamatan) {
        $('.selected-kecamatan').val(kecamatan.replace("Kecamatan ", ""));
      }
    }
  });
}

function clearMarkers() {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
  markers = [];
}

function findAddressComponent(result, componentType) {
  for (var i = 0; i < result.address_components.length; i++) {
    var component = result.address_components[i];
    for (var j = 0; j < component.types.length; j++) {
      if (component.types[j] === componentType) {
        return component.long_name;
      }
    }
  }
  return null;
}