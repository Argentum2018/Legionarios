<?php
  $ret_string = l2_kickcharacter ( $_GET [ "u" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 28 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 29 ] ); ?> <strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
