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
   <div class="dataset_table">
      <table>
         <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Location</th>
            <th>Borrowed</th>
         </tr>
         <tr>
            <td><a href="item_detail.php?id=1">Hammer<a></td>
            <td>heavy, bang-y</td>
            <td><a href="location_map.php?id=1">A2</a></td>
            <td>No</td>
         </tr>
         <tr>
            <td>Screwdriver</td>
            <td>Brother Tonk's gave it to me.</td>
            <td>A3</td>
            <td><a href="lending.php?id=1">Yes</a></td>
         </tr>
         <tr>
            <td>Chair covers</td>
            <td>Scotchgard treated</td>
            <td>K5</td>
            <td>No</td>
         </tr>
         <tr>
            <td>Lawn Mover</td>
            <td>Electric goat</td>
            <td>G1</td>
            <td>No</td>
         </tr>
      </table>
   </div>
</div>
<div>
<?=$date?> &nbsp; Welcome to the future home of <?php echo 'CS313-GOp Garage Organizer!'; ?>
<div class="notes">
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


