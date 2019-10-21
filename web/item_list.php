
<?php
// THIS FILE IS TO BE INCLUDED AFTER DB ESTABLISHED AND $qstring IS DEFINED
// DIV and TABLE are taken care of here.
// I'm wondering if these vars need to be defined or not locally?
?>
<div class="dataset_table">
   <table>
      <tr>
         <th>Name</th>
         <th>Description</th>
         <th>Category</th>
         <th>Location</th>
         <th>Borrowed</th>
      </tr>
<?php
foreach ($db->query($qstring)as $row) {
   echo '<tr>';
   echo '<td><a href="item_detail.php?id='. $row['id'] .'">';
   echo $row['item'] . '<a></td>';
   echo '<td>' .$row['idesc'] . '</td>';
   echo '<td>' .$row['cat'] . '</td>';
   echo '<td>' .$row['location'] . '</td>';
   echo '<td>' . 'No' . '</td>';
   echo '</tr>';
}
?>
 </table>
</div>