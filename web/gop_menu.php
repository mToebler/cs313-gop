<!-- Not starting sessino in this menu file as it's meant to be included in other files. -->
<?php 
   /* meant to be included immediately after the opening <body> tag. 
      First we need to know the name of the file we've been included in to offset 
      the menu. 
   */

   
?>
<div class="header">
   <div class="container">
      <div class="site-title">
         GOp
      </div>
      <div id="navbar"> 
         <ul> 
            <li><a href="index.php">GOp Home</a></li> 
            <li><a href="metatags.php">Categories</a></li> 
            <li><a href="item_location.php">Location Map</a></li> 
            <li><a href="users.php">Users</a></li> 
            <li><a href="lending.php">Borrowed</a></li> 
         </ul> 
      </div>
      <div class="site-tagline">
         Garage Organizer (php)  
      </div>
      <div class="search-bar">
         <form action="" method="POST">
         Search: <input type="search" name="search_text" size="10"/> 
         </form>
      </div>
   </div>
</div>