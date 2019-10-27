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
   <meta name="description" content="Meta Tags GOp">
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
      <div class="add_item">
         <div class="edit_link new_item"><a href="meta_edit.php?new=1">+ Enter new category</a></div><div class="new_item_buffer"></div>
      </div>
   <div class="dataset_table">
      <table>
         <tr>
            <th>Category</th>
            <th>Description</th>
            <th>Parent Category</th>
         </tr>

<?php include("db_connect.php");
// this query is in the works. I'm working on pulling out hierarchical info results.
   $qstring = "select m.id, m.name as name, m.description as descr, m2.name as parent, m2.id as pid from metas m left join metas m2 on m.parent_id = m2.id order by name";
   foreach ($db->query($qstring)as $row) {
      echo '<tr>';
      echo '<td><a href="meta_detail.php?id=' .$row['id'] .'">' . $row['name'] .'</a></td>';
      echo '<td>' .$row['descr'] . '</td>';
      echo '<td>' . $row['parent'] . '</td>';
      echo '</tr>';
   }

?>
      </div>  
   </div>
</body>
</html>