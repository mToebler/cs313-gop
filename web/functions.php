<?php
// for XSS attacks and SQL-injection attacks. trying to find the right one.
function _e($string) {
   return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
   //return htmlentities($string, ENT_QUOTES, 'UTF-8');
   //return filter_var($string, FILTER_SANITIZE_STRING);
 }

?>