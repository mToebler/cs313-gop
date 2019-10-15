// $(document).ready(function () {
//    $(this).parent().fadeToggle(1000);
// });

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

$(document).ready(function(){
   $("#id_cheat").click(function(){
      $("img").fadeToggle();
      $(".mark-photo1").fadeToggle();
      $(".cool-photo2").fadeToggle();
      //$("#id_cheat").html($("#id_cheat").html() == "Show Images" ? "Hide Images" : "Show Images"));
   });
   // defunct
   $("h2").click(function(){
     $("img").show();
   });
 });

/* Applying the "open" class when you click the menu button, which triggers the mobile menu to open/close; Toggle Menu/Close menu text. */
$(document).ready(function() {
   $(".mobile-button a").click(function(e) {
    $(this).parent().parent().toggleClass("open");
   $(this).html($(this).html() == "Close Menu" ? "Menu" : "Close Menu");
     e.preventDefault();
   });
 });