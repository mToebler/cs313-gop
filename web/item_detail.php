<?php
session_start();

date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo 'CS313-GOp Garage Organizer'; ?></title>
   <meta name="description" content="Item detail GOp">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="project1.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src="project1.js" async defer></script>
</head>
<body>
   <?php include("gop_menu.php"); ?>
   <div class="container">
<?php include("db_connect.php");
$id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
if (!is_null($id)) {
   $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where i.id = $id";
   foreach ($db->query($qstring)as $row) {

?>
      <div class="item_detail">
         
      
<?php
      echo '<h1>';
      echo $row['item'];
      echo '</h1>';
      echo '<br><h3>Description:</h3>';
      echo $row['idesc'];
      echo '<br><h3>Location:</h3>';
      echo $row['location'];
      echo '<br><h3>Category:</h3>';
      echo $row['cat'];
      echo '<br><br><br><h2>Editing & Images coming soon!</h2>';
   }

}
      else {
         echo 'Woops - unknown item. Please return to the <a href="index.php">main page</a>.';
      }
?>    
      </div>  
   </div>
</body>
</html>