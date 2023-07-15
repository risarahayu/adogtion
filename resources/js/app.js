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