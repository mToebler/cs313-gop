<?php
session_start();
include('functions.php');

date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());
include("db_connect.php");

// var_dump($_POST); // for testing
if (isset($_POST['new'])) {
   // new item. Prepare insert
   $name = _e($_POST['iname']);
   $desc = _e($_POST['idesc']);
   $lid = _e($_POST['lid']);
   $cid = _e($_POST['cid']);
   
   try {
      $istatement = 'insert into items (name, location_id, description) values (:name, :lid, :desc)';
      $statement = $db->prepare($istatement);
      $statement->bindValue(':name', $name);
      $statement->bindValue(':lid', $lid);
      $statement->bindValue(':desc', $desc);

      $dbresult = $statement->execute(); 
      if (!$dbresult) {
         print "Insert failed!! $lid, $name, $desc <br>";
         var_dump($_POST);
      } else {
         // this will set the $id triggering the display.
         $id = $db->lastInsertId("item_id_seq");
         // need to insert into meta_item
         $istatement = 'insert into meta_item (item_id, meta_id) values (:id, :cid)';
         $statement = $db->prepare($istatement);
         $statement->bindValue(':id', $id);
         $statement->bindValue(':cid', $cid);

         $dbresult = $statement->execute(); 
         if (!$dbresult) {
            print "Meta_item insert failed!! $id, $cid <br>";
            var_dump($_POST);
         }
      }
   } catch (Exception $e) {
      print ("EXCEPTION: $e");
      die();
   }

} else if(isset($_POST['submit'])) {
   // var_dump($_POST); // for testing
   //put insert database stuff here
   // first need to validate.
   $id = _e($_POST['e_id']);
   $name = _e($_POST['iname']);
   $desc = _e($_POST['idesc']);
   $lid = _e($_POST['lid']);
   // this is modeled after Burton's solution from the team activity this week
   try {
      $uqstring = 'update items set name = :name, description = :desc, location_id = :lid where id = :id';
      $statement = $db->prepare($uqstring);
      $statement->bindValue(':name', $name);
      $statement->bindValue(':desc', $desc);
      $statement->bindValue(':lid', $lid);
      $statement->bindValue(':id', $id);

      $dbresult = $statement->execute(); 
      if (!$dbresult) {
         print "Update failed!! $id, $name, $desc <br>";
         var_dump($_POST);
      } 
   } catch (Exception $e) {
      print ("EXCEPTION: $e");
      die();
   }
}

if(!isset($categories_array)) {
   $qstring = "select m.id as id, m.name as name, m.description as descr, m2.name as parent, m2.id as pid from metas m left join metas m2 on m.parent_id = m2.id order by name";
   foreach($db->query($qstring) as $row) {
      $categories_array[$row['id']] = $row['name'];
   }
   // it's tricky cuz these could change.
   // $_SESSION["categories_array"] = $categories_array;
   
   unset($qstring);
   unset($row);
}

if(!isset($locations_array)) {
   if(isset($_SESSION['locations_array'])) {
      $locations_array = $_SESSION['locations_array']; 
      // doesn't matter if it's a deep copy or not I believe. Just need the mem address.
   } else {
      $qstring = "select id, name, description from locations";
      foreach($db->query($qstring) as $row) {
         $locations_array[$row['id']] = $row['name'];  
      }
      $_SESSION["locations_array"] = $locations_array;
      unset($qstring);
      unset($row);
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo 'CS313-GOp Garage Organizer'; ?></title>
   <meta name="description" content="Item edit GOp">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="project1.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src="project1.js" async defer></script>
</head>
<body>
   <?php include("gop_menu.php"); ?>
   <div class="container pad_me">
<?php
// db_connect already included above
if (!isset($id) && isset($_GET['id'])) $id = _e($_GET['id']);
if (isset($id)) {
   $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.description as location, l.id as lid from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where i.id = $id";
   foreach ($db->query($qstring) as $row) {
?>
<form name="update" action="item_detail.php" method="POST">
   <div class="form_row item_edit">
      <input type="hidden" name="e_id" value="<?=$row['id']?>"/>
      <div class="form-group">
         <label for="iname">Item name:</label>
         <input type="text" class="form-control" id="iname" name="iname" value="<?=$row['item']?>" required>
         <div class="valid-feedback">Valid.</div>
         <div class="invalid-feedback">Please fill out this field.</div>
      </div>
      <div class="form-group">
         <!-- <label for="idesc">Description:</label>
         <textarea class="form-control" rows="5" name="n_desc" form="update" id="idesc"><?=$row['idesc']?></textarea>
         <div class="valid-feedback">Valid.</div>
         <div class="invalid-feedback">Please fill out this field.</div> -->
         <label for="idesc">Description:</label>
         <textarea class="form-control" id="idesc" name="idesc" rows="4"><?=$row['idesc']?></textarea>
      </div>
      <div class="d-flex p-2 bg-secondary text-white">
         <div class="form-group">
            <input type="hidden" name="lid_changed" value="false" id="lid_changed"/>
            <label for="lid">Location</label>
            <select class="form-control" id="lid" name="lid">
            <?php
            foreach ($locations_array as $id=>$name) {
               if ($row['lid'] == $id) {
                     echo '<option value="' . $id . '" selected>'.$name.'</option>';     
               }
               else {
                     echo '<option value="' . $id . '">'.$name.'</option>';     
               }
            }
            ?>
            </select>
         </div>
         <div class="img_overlay">
            <img src="images/gop_locations_sm.png" class=".img-fluid" alt="Indexed Garage Locations"/>
            <div class="overlay" id="overlay">
               X
            </div>
         </div>
      </div>
      <!-- <div class> -->
      <button type="submit" name="submit" class="btn btn-primary">Update</button>
      <!-- </div> -->
   </div>
</form>
<?php 
   }
} else {
   // new item
   ?>
   <form name="new" action="item_detail.php" method="POST">
   <div class="form_row item_edit">
      <input type="hidden" name="e_id" value="new"/>
      <div class="form-group">
         <label for="iname">Item name:</label>
         <input type="text" class="form-control" id="iname" name="iname" required>
         <div class="valid-feedback">Valid.</div>
         <div class="invalid-feedback">Please fill out this field.</div>
      </div>
      <div class="form-group">
         <label for="idesc">Description:</label>
         <textarea class="form-control" id="idesc" name="idesc" rows="3"></textarea>
      </div>
      <div class="d-flex p-2 bg-secondary text-white">
         <div class="form-group">
            <label for="cid">Category</label>
            <select class="form-control" id="cid" name="cid" required>
            <?php
            foreach ($categories_array as $ca_id=>$ca_name) {
               echo '<option value="' . $ca_id . '">'.$ca_name.'</option>';     
            }
            ?>
            </select>
         </div>
         <div> 
         </div>
      </div>
      <div class="d-flex p-2 bg-secondary text-white">
         <div class="form-group">
            <input type="hidden" name="lid_changed" value="false" id="lid_changed"/>
            <label for="lid">Location</label>
            <select class="form-control" id="lid" name="lid">
            <?php
            foreach ($locations_array as $la_id=>$la_name) {
               echo '<option value="' . $la_id . '">'.$la_name.'</option>';     
            }
            ?>
            </select>
         </div>
         <div class="img_overlay">
            <img src="images/gop_locations_sm.png" class=".img-fluid" alt="Indexed Garage Locations"/>
            <div class="overlay" id="overlay">
               X
            </div>
         </div>
      </div>
      <!-- <div class> -->
      <button type="submit" name="new" class="btn btn-primary">Create</button>
      <!-- </div> -->
   </div>
</form>
<?php

}
?>
      </div>  
   </div>
</body>
</html>