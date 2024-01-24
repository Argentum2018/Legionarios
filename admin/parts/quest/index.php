<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} else {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/search.php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
}
?>
