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
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo 'CS313-GOp Garage Organizer'; ?></title>
   <meta name="description" content="Category Edit GOp">
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
   <div class="container pad_me">
<?php 

if (!isset($id) && isset($_GET['id'])) $id = _e($_GET['id']);
// $id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
if (isset($id)) {
   $qstring = "select m.id, m.name as name, m.description as descr, m2.name as parent, m2.id as pid from metas m left join metas m2 on m.parent_id = m2.id where m.id = $id";
   
   foreach ($db->query($qstring)as $row) {

?>
      <form name="update" action="meta_detail.php" method="POST">
         <div class="form_row item_edit">
            <input type="hidden" name="e_id" value="<?=$row['id']?>"/>
            <div class="form-group">
               <label for="mname">Category name:</label>
               <input type="text" class="form-control" id="mname" name="mname" value="<?=$row['name']?>" required>
               <div class="valid-feedback">Valid.</div>
               <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
               <label for="mdesc">Description:</label>
               <textarea class="form-control" id="mdesc" name="mdesc" rows="3"><?=$row['descr']?></textarea>
            </div>
            <div class="d-flex p-2 bg-secondary">
               <div class="form-group">
                  <label for="pid">Parent category:</label>
                  <select class="form-control" id="pid" name="pid">
                     <option value="0">No parent category</option>
            <?php
                  foreach ($categories_array as $ca_id=>$ca_name) {
                     if ($row['pid'] == $ca_id) {
                           echo '<option value="' . $ca_id . '" selected>'.$ca_name.'</option>';     
                     }
                     // we don't want categories to be self-realizing
                     else if($id != $ca_id) {
                           echo '<option value="' . $ca_id . '">'.$ca_name.'</option>';     
                     }
                  }
            ?>
                  </select>
               </div>
            </div>
            <!-- <div class> -->
            <button type="submit" name="submit" class="btn btn-warning">Update</button>
            <!-- </div> -->
         </div>
      </form>
<?php
   }
} else {
   // new category/meta
   ?>
   <form name="new" action="meta_detail.php" method="POST">
         <div class="form_row item_edit">
            <input type="hidden" name="e_id" value="new"/>
            <div class="form-group">
               <label for="mname">Category name:</label>
               <input type="text" class="form-control" id="mname" name="mname" required>
               <div class="valid-feedback">Valid.</div>
               <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
               <label for="mdesc">Description:</label>
               <textarea class="form-control" id="mdesc" name="mdesc" rows="4"></textarea>
            </div>
            <div class="d-flex p-2 bg-secondary">
               <div class="form-group">
                  <label for="pid">Parent category:</label>
                  <select class="form-control" id="pid" name="pid">
                     <option value="0">No parent category</option>
            <?php
                  foreach ($categories_array as $ca_id=>$ca_name) {                     
                        echo '<option value="' . $ca_id . '">'.$ca_name.'</option>';                          
                  }
            ?>
                  </select>
               </div>
            </div>
            <!-- <div class> -->
            <button type="submit" name="new" class="btn btn-warning">Create</button>
            <!-- </div> -->
         </div>
      </form>
<?php      
}
?>
      </div>  
</body>
</html>