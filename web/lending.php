<?php
session_start();
include('functions.php');

date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo 'CS313-GOp Garage Organizer'; ?></title>
   <meta name="description" content="Borrowed Items GOp">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="project1.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src="project1.js" async defer></script>
   <?php include("favicon.html");?>
</head>
<body>
   <?php include("gop_menu.php"); ?>
   <div class="container">
      <!-- <div class="item_detail max-width"> -->
         <div class="dataset_table">
            <table id="items_table"> 
               <tr>
                  <th class="col-1 colb-name">Name</th>
                  <th class="col-2 colb-item">Item</th>
                  <th class="col-3 colb-start">Start</th>
                  <th class="col-4 colb-end">End</th>
                  <th class="col-5 colb-returned">Returned</th>
                  <th class="col-6 colb-notes">Notes</th>
               </tr>
<?php
      include("db_connect.php");
      $query = "select u.id, u.first_name, u.last_name, i.id as iid, i.name as iname, ip.start_date, ip.end_date, ip.returned_date, ip.id as ipid, ip.notes as notes from users u JOIN item_possession ip ON u.id = ip.user_id JOIN items i on i.id = ip.item_id order by end_date";
      try {
         foreach ($db->query($query)as $row) {
            echo '<tr>';
            echo '<td><a href="user_detail.php?id='. $row['id'] .'">'. $row['first_name'] .' ' . $row['last_name'] .'</a></td>';
            echo '<td><a href="item_detail.php?id='. $row['iid'] .'">' . $row['iname'] . '<a></td>';
            echo '<td>' .$row['start_date'] . '</td><td>'. $row['end_date'] . '</td><td class="returned">'. $row['returned_date'] . '</td>';
            echo '<td>' .$row['notes'] . '</td>';
            echo '</tr>';
         }
      } catch (Exception $e) {
         print ("EXCEPTION: $e");
         die();
      }
?>    
         </table>
         </div>
      <!-- </div>   -->
   </div>
</body>
</html>