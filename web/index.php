<?php
session_start();
include('functions.php');

// login moved into functions.php
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
   <?php include("favicon.html");?>
</head>
<body>
   <?php include("gop_menu.php"); ?>
<div class="container">
   <div class="add_item">
   <div class="edit_link new_item"><a href="item_edit.php?new=1">+ Enter new item</a></div><div class="new_item_buffer"></div>
   </div>
   <?php
      include("db_connect.php");
      // the big items query, mutliple joins and aliases.
      if(isset($search_text) && strlen($search_text)) {
         //$qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where i.name like '%$search_text%' OR i.description like '%$search_text%' order by item";
         // $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location, ip.start_date as start_date, ip.returned_date as returned_date from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id left join item_possession ip on i.id = ip.id where i.name like '%$search_text%' OR i.description like '%$search_text%' order by item";
         $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location, ip.start_date as start_date, ip.returned_date as returned_date from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id left join item_possession ip on i.id = ip.id where LOWER(i.name) like LOWER('%$search_text%') OR LOWER(i.description) like LOWER('%$search_text%') order by item;";
      } else {
         $qstring = 'select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.name as lname, l.description as location, ip.returned_date as returned_date, ip.start_date as start_date from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id left join item_possession ip on i.id = ip.item_id order by item';
      }
      include("item_list.php");
   ?>
</div>
<div>
</div>
</body>
</html>


