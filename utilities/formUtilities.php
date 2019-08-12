<?php
function sanitizeString($str) {
 
      $str = stripslashes($str);
      $str = htmlentities($str);
      $str = strip_tags($str);
      return $str;
}
?>