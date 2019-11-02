<?php
session_start();
include('functions.php');
include("db_connect.php");

date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());

if (isset($_POST['lid'])) {
   $lid = _e($_POST['lid']);
   
   try {
      $query = "select id, name, description from locations where id = $lid";
      foreach ($db->query($query)as $row) {
         $lname = $row['name'];
         $desc = $row['description'];
      }
   } catch (Exception $e) {
      print ("EXCEPTION: $e");
      die();
   }
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
   <meta name="description" content="Item Location GOp">
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

      <div class="item_detail">         
<?php
if(!isset($desc)) {
      echo '<h3>Select location:</h3>';
} else {
   echo '<h3>'.$lname .':</h3>';
}
?>    
         <form name="show" action="" id="show" method="POST">
               <div class="d-flex p-2 bg-secondary">
                  <div class="form-group">
                     <input type="hidden" name="lid_changed" value="false" id="lid_changed"/>
                     <input type="hidden" name="lid_reload" value="true" id="lid_reload"/>
                     <label for="lid">Location</label>
                     <select class="form-control" id="lid" name="lid">
                     <?php
                     foreach ($locations_array as $id=>$name) {
                        if ($lid == $id) {
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
         </form>
         <?php
            if(isset($lid)) {
               echo '<br><h3>Items in this location</h2>';  
               // $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, l.description as location from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where m.id  = $id order by item";
               // $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.name as lname, l.description as location, l.id as lid from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id where l.id = $lid order by item";
               $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.name as lname, l.description as location, l.id as lid, ip.start_date as start_date, ip.returned_date as returned_date from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id left join item_possession ip on i.id = ip.item_id where l.id = $lid order by item";
               include("item_list.php");
            }
         ?>
      </div>   
   </div>
</body>
</html>