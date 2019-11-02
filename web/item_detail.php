<?php
session_start();

include('functions.php');
 
date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());
include("db_connect.php");

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
   <?php include("favicon.html");?>
</head>
<body>
   <?php include("gop_menu.php"); ?>
   <div class="container">
<?php 
if (!isset($id)) $id = _e($_GET['id']);
if (!is_null($id)) {
   $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.name as lname, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where i.id = $id";
   foreach ($db->query($qstring)as $row) {

?>
      <div class="item_detail">
         
      
<?php
      echo '<h1>';
      echo $row['item'];
      echo '</h1><div class="edit_link"><a href="item_edit.php?id='. $row['id'] . '">edit</a></div>';
      echo '<br><h3>Description:</h3>';
      echo $row['idesc'];
      ?>
      </div>
      <!--wanted to separate these so it doesn't affect the location mapping-->
      <div class="item_detail">
<?php 
      echo '<br><h3>Location:</h3>';
      echo $row['location'];
      echo '<input type="hidden" id="lname" name="lname" value="'.$row['lname'] .'">';
 ?>
         <div class="img_overlay">
            <img src="images/gop_locations_sm.png" class=".img-fluid" alt="Indexed Garage Locations"/>
            <div class="overlay" id="overlay">
               X
            </div>
         </div>
 <?php
      echo '<br><h3>Category:</h3>';
      echo '<a href="meta_detail.php?id=' . $row['mid'] . '">' . $row['cat'] . '</a>';
      // echo '<br><br><br><h2>Editing & Images coming soon!</h2>';
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