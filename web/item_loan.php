<?php
session_start();
include('functions.php');

// this page needs an id.
if (!isset($_GET['id'])) {
   header('Location: ' . 'index.php');
   die();
} else {
   $id = $_GET['id'];
}

date_default_timezone_set('America/Los_Angeles');
$date = date('Y-m-d', time());

// The id is for the product being lent. We just need to pull a list of people from the database
// that it could be lent to.
try {
   include("db_connect.php");
   $query = "select id as uid, first_name || ' ' || last_name  as name from users";
   foreach ($db->query($query)as $row) {
      $users_array[$row['uid']] = $row['name']; 
   }
} catch (Exception $e) {
   error_log("item_loan: Exception: $e");
   die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo 'CS313-GOp Garage Organizer'; ?></title>
   <meta name="description" content="Item Loan GOp">
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
if (!is_null($id)) {
   // $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.name as lname, l.description as location, ip.returned_date as returned_date, ip.start_date as start_date from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id left join item_possession ip on i.id = ip.item_id where i.id = $id";
   // this new version is ONLY FOR LOANS as it picks out a suggested date 7 days from now called "suggested_end_date"
   $qstring = "select i.id as id, i.name as item, i.description as idesc, m.name as cat, m.id as mid, l.name as lname, l.description as location, ip.returned_date as returned_date, ip.start_date as start_date, (current_date + 7) as suggested_end_date from items i join meta_item mi on i.id = mi.item_id join metas m on mi.meta_id = m.id join locations l on i.location_id = l.id left join item_possession ip on i.id = ip.item_id where i.id = $id";
   foreach ($db->query($qstring)as $row) {

?>
      <div class="item_detail">
         
      
<?php
      //figure out if it's on loan or not.
      $onloan = false;
      if($row['start_date']=='') $onloan = false;
      else if ($row['returned_date'] == '') $onloan = true;

      echo '<h1>Lend ';
      echo $row['item'];
      echo '</h1>';
      // Lending functionality.
?>
      <div class="lend_form_container">
         <form name="lend_form" action="lending.php" method="POST">
            <!-- <div class="d-flex p-2 bg-secondary"> -->
               <div class="form-group">
                  <input type="hidden" name="iid" value="<?=$row['id']?>"/>
                  <label for="userid">Lend to:</label>
                  <select class="form-control form-control-sm" id="userid" name="userid" required>
                     <option value="">Select from list</option>
                  <?php
                     foreach ($users_array as $u_id=>$u_name) {                     
                        echo '<option value="' . $u_id . '">'.$u_name.'</option>';                             
                     }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="end_date">Until <span style="font-size:small">(default 7 days)</span>:</label>
                  <input class="form-control form-control-sm" type="date" id="end_date" name="end_date" value="<?=$row['suggested_end_date']?>" min="<?=$date?>">
               </div>
               <div class="form-group">
                  <label for="notes">Notes:</label>
                  <textarea class="form-control form-control-sm" id="notes" name="notes" rows="2" placeholder="Any relevant notes here"></textarea>
               </div>
               <button type="submit" name="lend" class="btn-sm btn-warning">Lend</button>
            <!-- </div> -->
         </form>
      </div>
<?php
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