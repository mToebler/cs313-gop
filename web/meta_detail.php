<?php
session_start();
include('functions.php');
include("db_connect.php");

date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());

if (isset($_POST['new'])) {
   // new item. Prepare insert
   $name = _e($_POST['mname']);
   $desc = _e($_POST['mdesc']);
   $pid = _e($_POST['pid']);
   if ($pid == "0") $pid = "";
   
   try {
      $istatement = 'insert into metas (name, description, parent_id) values (:name, :desc, :pid)';
      $statement = $db->prepare($istatement);
      $statement->bindValue(':name', $name);
      $statement->bindValue(':desc', $desc);
      if ($pid == "") {
         $statement->bindParam(':pid', $pid, PDO::PARAM_NULL);
      } else {
         $statement->bindValue(':pid', $pid);
      }

      $dbresult = $statement->execute(); 
      if (!$dbresult) {
         print "Insert failed!! $pid, $name, $desc <br>";
         print $istatement . "<br>";
         // print $statement;
         var_dump($_POST);
      } else {
         // this will set the $id triggering the display.
         $id = $db->lastInsertId("meta_id_seq");
      }
   } catch (Exception $e) {
      print ("EXCEPTION: $e");
      die();
   }

} else if(isset($_POST['submit'])) {
   // var_dump($_POST); // for testing
   
   // first scrub data.
   $id = _e($_POST['e_id']);
   $name = _e($_POST['mname']);
   $desc = _e($_POST['mdesc']);
   $pid = _e($_POST['pid']); 
   if ($pid == "0") $pid = "";
   
   // this is modeled after Burton's solution from the team activity this week
   try {
      $uqstring = 'update metas set name = :name, description = :desc, parent_id = :pid  where id = :id';
      $statement = $db->prepare($uqstring);
      $statement->bindValue(':name', $name);
      $statement->bindValue(':desc', $desc);
      if ($pid == "") {
         $statement->bindParam(':pid', $pid, PDO::PARAM_NULL);
      } else {
         $statement->bindValue(':pid', $pid);
      }
      $statement->bindValue(':id', $id);

      $dbresult = $statement->execute(); 
      if (!$dbresult) {
         print "Update failed!! $id, $name, $desc, $pid <br>";
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
   <meta name="description" content="Category detail GOp">
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
if (!isset($id) && isset($_GET['id'])) $id = _e($_GET['id']);

if (isset($id)) {
   $qstring = "select m.id, m.name as name, m.description as descr, m2.name as parent, m2.id as pid from metas m left join metas m2 on m.parent_id = m2.id where m.id = $id";

   foreach ($db->query($qstring)as $row) {

?>
      <div class="item_detail">         
<?php
      echo '<h1>';
      echo $row['name'];
      echo '</h1><div class="edit_link"><a href="meta_edit.php?id='. $row['id'] . '">edit</a></div>';
      echo '<br><h3>Description:</h3>';
      echo $row['descr'];
      echo '<br><h3>Parent category:</h3>';
      if(!empty($row['pid'])) {
         echo '<a href="meta_detail.php?id=' . $row['pid'] . '">' . $row['parent'] . '</a>';
      } else {
         echo '<div class="no_parent">No parent</div>';
      }
   }

      // Now list the associated items with this meta
      // fetch from db
      // and loop through.
      // should this be a smaller version of the items table or the whole 9 yards?
      // let's go with 9-yards version for now. Can always scale back. May want to put the 
      // items-listing in a separate php file, then it could just be plugged in.
      echo '<br><h2>Items in category</h2>';  
      // $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where m.id  = $id order by item";
      $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where m.id =$id or m.id in ( select id from metas where parent_id = $id) order by item";
      include("item_list.php");
} else {
   echo 'Woops - unknown category. Please return to the <a href="index.php">main page</a>.';
}

?>    
      </div>  
   </div>
</body>
</html>