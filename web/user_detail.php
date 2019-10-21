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
   <meta name="description" content="User detail GOp">
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
   $qstring = "select u.id, first_name, last_name, city, s.name as sa, address, email from users u join states s on u.state_id = s.id where u.id = $id";
   foreach ($db->query($qstring)as $row) {

?>
      <div class="item_detail">
         
      
<?php
      echo '<h1>';
      echo $row['first_name'] .' ' . $row['last_name'];
      echo '</h1>';
      echo '<br><h3>Address:</h3>';
      echo $row['address'] . ', ' . $row['city'] . ', '. $row['sa'];
      echo '<br><h3>Contact:</h3>';
      echo $row['email'];
      echo '<br><br><br><h2>Editing ability coming soon!</h2>';
   }

}
      else {
         echo 'Woops - unknown user. Please return to the <a href="index.php">main page</a>.';
      }
?>    
      </div>  
   </div>
</body>
</html>