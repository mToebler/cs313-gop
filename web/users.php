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
   <meta name="description" content="Users GOp">
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
   <div class="dataset_table">
      <table>
         <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Contact</th>
         </tr>

<?php include("db_connect.php");
// this query is in the works. I'm working on pulling out hierarchical info results.
   $qstring = "select u.id, first_name, last_name, city, s.name as sa, address, email from users u left join states s on u.state_id = s.id order by first_name";
   foreach ($db->query($qstring)as $row) {
      echo '<tr>';
      echo '<td><a href="user_detail.php?id='. $row['id'] .'">'. $row['first_name'] .' ' . $row['last_name'] .'</a></td>';
      echo '<td>' .$row['address'] . ', ' . $row['city'] . ', '. $row['sa'] . '</td>';
      echo '<td><a href="mailto:' . $row['email'] . '" target="_top">'. $row['email'] . '</td>';
      echo '</tr>';
   }

?>
      </div>  
   </div>
</body>
</html>