<?php
// Rather than follow the same system pattern for a new "thing", i.e., "+new loan" here in the 
// lending page, I believe it makes more sense to start the loan in the item detail page.
// The item is the object being lent; so, rather than start a new loan, then find the item,
// starting with the item being lent and attaching a user to it makes more sense from a UX
// point of view. For instance, the other way could end up with a number of aborted loan attemps
// when it's discovered that the item is already on loan. Starting on the item detail page is 
// logical: the location is known and the loan status is known. A user can borrow many things, the 
// item can only be lent once.
session_start();
include('functions.php');
include("db_connect.php");

date_default_timezone_set('America/Los_Angeles');
$date = date('m/d/Y h:i:s a', time());

// catch the POST submit from item_loan.php here
if(isset($_POST['lend'])) {
   $i_id  = _e($_POST['iid']);
   $u_id  = _e($_POST['userid']);
   $end   = _e($_POST['end_date']);
   $notes = _e($_POST['notes']);
   try {
      //prepare insert statement
      $istatement = 'insert into item_possession(user_id, item_id, end_date, notes) values (:u_id, :i_id, :end, :notes)';
      $statement = $db->prepare($istatement);
      $statement->bindValue(':u_id', $u_id);
      $statement->bindValue(':i_id', $i_id);
      $statement->bindValue(':end', $end);
      $statement->bindValue(':notes', $notes);

      $dbresult = $statement->execute(); 
      if (!$dbresult) {
         error_log("Insert failed!! $u_id, $i_id, $end_date, $notes.");
         error_log('Insert failed!!' . var_dump($_POST));
      }
   } catch (Exception $e) {
      error_log("lending.php exception: $e");
      error_log('lending.php insert excepted!!' . var_dump($_POST));
      die();
   }
   // the user should now see their listing in the lending list below.
   // to prevent a resubmission on refresh, going to try redirecting them 
   // to this same page. totally works!
   header('location: lending.php' );
   die();
}
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
      // include("db_connect.php");
      $query = "select u.id, u.first_name, u.last_name, i.id as iid, i.name as iname, ip.start_date, ip.end_date, ip.returned_date, ip.id as ipid, ip.notes as notes from users u JOIN item_possession ip ON u.id = ip.user_id JOIN items i on i.id = ip.item_id order by end_date";
      try {
         foreach ($db->query($query)as $row) {
            echo '<tr>';
            echo '<td><a href="user_detail.php?id='. $row['id'] .'">'. $row['first_name'] .' ' . $row['last_name'] .'</a></td>';
            echo '<td><a href="item_detail.php?id='. $row['iid'] .'">' . $row['iname'] . '<a></td>';
            echo '<td>' .$row['start_date'] . '</td><td>'. $row['end_date'] . '</td><td class="returned">'. $row['returned_date'] . '</td>';
            echo '<td><span title="' .$row['notes'] .'">' .$row['notes'] . '</span></td>';
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