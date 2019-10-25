// $(document).ready(function () {
//    $(this).parent().fadeToggle(1000);
// });

$(document).ready(function () {
   // get current URL path and assign 'active' class
   var pathname = window.location.pathname;
   // $('.navbar > li > a[href="'+pathname+'"]').parent().addClass('active');
   $('a[href="' + pathname + '"]').addClass('active');
});

$(document).on('change', '#lid', function () {
   $('#lid_changed').val('true');
});

function clicked() {
   alert('Clicked');
}

function colorClicked() {
   var selectedColor = document.getElementById("div1color_input").value;
   document.getElementById("div1").style.backgroundColor = selectedColor;
}

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