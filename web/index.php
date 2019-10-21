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
   <meta name="description" content="CS313 Project 1 - GOp">
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
   <?php
      include("db_connect.php");
      // the big items query, mutliple joins and aliases.
      $qstring = 'select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id;';
         
      include("item_list.php");
   ?>
</div>
<div>
<div class="notes">
   <?=$date?> <br/> Welcome to the future home of <?php echo 'CS313-GOp Garage Organizer!'; ?>
   Requirements for this assignment:
   <ol>
      <li>Your application must be running on Heroku with your source code in GitHub.</li>

      <li>Your application must have well organized and cleanly written PHP, HTML, CSS, and JavaScript.</li>

      <li>Your database must have at least one foreign key relationship.</li>

      <li>Your PHP code must have at least one SQL join query.</li>

      <li>Your PHP code must have at least one SQL update statement.</li>
   </ol>
</div>
</div>
</body>
</html>


