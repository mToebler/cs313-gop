// $(document).ready(function () {
//    $(this).parent().fadeToggle(1000);
// });

// For dynamic menu coloring
$(document).ready(function () {
   // get current URL path and assign 'active' class
   var pathname = window.location.pathname;
   // $('.navbar > li > a[href="'+pathname+'"]').parent().addClass('active');
   $('a[href="' + pathname + '"]').addClass('active');
});

$(document).on('change', '#search', function () {
   $($('#search_form').submit());
});

// Location map notes: The idea is to use a small semi-transparant overlay with an 'X'
// on top of the location map. When the location changes, the overlay moves to the 
// new location. This would happen when selecting the new option from the drop down, 
// and be written to the database on submit. These notes are the %'s for various positions,
// so that I can see what the function is for the remainder positions. All I need is 3
// points: two sets of neihbors with one point in common between them.
//
// B5: bottom: 58%, left:52%
// A5: bottom: 71%, left 52%
// A4: bottom: 71%, left: 42%
// moving 1 position vertically(y): 13%
// moving 1 spot horizontally  (x): 10%
// If A5 is the SE corner, values can be subtracted from it's point.
// let A be the x value, and v be the y value, and x the # of spots along the X-axis, y along the Y-axis:
// A - 10x =  left value
// v - 13y =  bottom value
// bottom: (71 - 13y); left: (52 - 10x);  
// Will need to setup a way to convert positions, e.g., D3, into values. 
// Take first char: charAt(0).charCodeAt(); for ascii value. A->65, E->69, 
// subtract 65: charAt(0).charCodeAt() - 65
// mult by 13: (charAt(0).charCodeAt() - 65) * 13
// subt from 71: 71 - ((charAt(0).charCodeAt() - 65) * 13) BOTTOM EQUATION
// LEFT EQUATION: 52 - (5 - (parseInt(charAt(1))) * 10);
// PROVE: E1: bottom: (71- 4*13)= 19%; left: (52-40)= 12% : which matches pretty closely
$(document).ready(function () {
   // make sure we're on the right page.
   if ($('#lid').length) {
      var lid = $('#lid.form-control').children("option:selected").text();
      var bottom = 71 - ((lid.charAt(0).charCodeAt() - 65) * 13);
      var left = 52 - ((5 - (parseInt(lid.charAt(1)))) * 10);
      $('#overlay').css('bottom', bottom + "%").css('left', left + "%");
   }
});

// Same as above, but now for when a new location is selected 
// can multiple jquery selectors be  applied to the same function?
// like with css using a "," separator. Look into it.
$(document).on('change', '#lid', function () {
   if ($('#lid_reload').length) {
      $($('#show').submit());
   } else {
      $('#lid_changed').val('true');
      var lid = $('#lid.form-control').children("option:selected").text();
      var bottom = 71 - ((lid.charAt(0).charCodeAt() - 65) * 13);
      var left = 52 - ((5 - (parseInt(lid.charAt(1)))) * 10);
      $('#overlay').css('bottom', bottom + "%").css('left', left + "%");
   }
});

// ARG! Now I need another form of the function above that pulls from a hidden value rather than a select option.
// ID will reflect the change to #lname. What needs to happen is get the size of the picture and go from there.
// The view can change the size. (CSS fix?) E1:(11,17) A5:(46,72) (x:7.5%(slot), y:14%(slot))
$(document).ready(function () {
   if ($('#lname').length) {
      var lid = $('#lname').val();
      var bottom = 71 - ((lid.charAt(0).charCodeAt() - 65) * 13);
      var left = 52 - ((5 - (parseInt(lid.charAt(1)))) * 10);
      //var bottom = 72 - ((lid.charAt(0).charCodeAt() - 65) * 13.5);
      //var left = 46 - ((5 - (parseInt(lid.charAt(1)))) * 8.5);
      $('#overlay').css('bottom', bottom + "%").css('left', left + "%");
   }
});


// for testing, debugging
function clicked() {
   alert('Clicked');
}

// THESE FUNCTIONS BELOW ARE FOR REFERENCE
// JQuery is newish to me. The selector syntax
// can be a little confusing. I haven't made that
// CSS link yet, which is odd, cause I feel I got that
// one down.
function jqColorClicked() {
   var selectedColor = $("#div2color_input").val();
   //alert('color value is' + selectedColor);
   $("#div2").css("background-color", selectedColor);
}

function jqFade() {
   //$("#div3").fadeToggle(5000);
   //$(this).parent().parent().hide();
}

/* Applying the "open" class when you click the menu button, which triggers the mobile menu to open/close; Toggle Menu/Close menu text. */
$(document).ready(function() {
   $(".mobile-button a").click(function(e) {
    $(this).parent().parent().toggleClass("open");
   $(this).html($(this).html() == "Close Menu" ? "Menu" : "Close Menu");
     e.preventDefault();
   });
 });