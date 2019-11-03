<!-- Not starting sessino in this menu file as it's meant to be included in other files. -->
<?php 
   /* meant to be included immediately after the opening <body> tag. 
      First we need to know the name of the file we've been included in to offset 
      the menu. 
   */
if (isset($_POST['search_text'])) {
   $search_text = _e($_POST['search_text']);
} else {
   $search_text = "";
}

   
?>
<div class="header">
   <div class="container">
      <div class="site-title" id="gop">
         GOp
      </div>
      <div class="navbar"> 
         <ul> 
            <li><a href="/web/index.php">Items</a></li> 
            <li><a href="/web/metatags.php">Categories</a></li> 
            <li><a href="/web/item_location.php">Location Map</a></li> 
            <li><a href="/web/users.php">Users</a></li> 
            <li><a href="/web/lending.php">Borrowed</a></li> 
         </ul> 
      </div>
      <div class="site-tagline">
         Garage Organizer (php) <br><?=$_SESSION['user']['name']?>  
         <div class="reverse_edit_link"><a href="logout.php">logout</a></div>
      </div>
      <div class="search-bar">
         <form action="index.php" id="search_form" method="POST">
            
          <input class="form-control" type="search" id="search" name="search_text" placeholder="Search" value="<?=$search_text?>" aria-label="Search" size="10" /> 
         
         </form>
      </div>
   </div>
</div>