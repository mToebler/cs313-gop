
<?php
// THIS FILE IS TO BE INCLUDED AFTER DB ESTABLISHED AND $qstring IS DEFINED
// DIV and TABLE are taken care of here.
// I'm wondering if these vars need to be defined or not locally?
?>
<div class="dataset_table">
   <table id="items_table"> 
      <tr>
         <th class="col-1 col-name">Name</th>
         <th class="col-2 col-desc">Description</th>
         <th class="col-3 col-cat">Category</th>
         <th class="col-4 col-loc">Location</th>
         <th class="col-5 col-bor"><span title="Borrowed">Borrowed</span></th>
      </tr>
<?php
$last_id = 0;
foreach ($db->query($qstring)as $row) {
   // deal with mulit-loaned items showing up multi-times
   // don't have time to build a view and change all queries. =<()
   if($row['id'] != $last_id) {
      // figure out if onloan
      $onloan = false;
      if($row['start_date']=='') $onloan = false;
      else if ($row['returned_date'] == '') $onloan = true;

      echo '<tr>';
      echo '<td><a href="item_detail.php?id='. $row['id'] .'">';
      echo $row['item'] . '<a></td>';
      echo '<td><span title="' .$row['idesc'] . '">' .$row['idesc'] . '</td>';
      echo '<td><span title="' .$row['cat'] .'">' .$row['cat'] . '</td>';
      echo '<td><span title="' .$row['location'] .'">'.$row['location'] .'</td>';
      if($onloan) echo '<td class="onloan">' . 'Yes' . '</td>';
      else echo '<td>' . 'No' . '</td>';
      echo '</tr>';
   }
   $last_id = $row['id'];
}
?>
 </table>
</div>