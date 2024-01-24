<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_pledgedelete ( $_GET [ "c" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 170 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 171 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select * from pledge (nolock) where pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] );
  $res = mssql_query ( $query, $link_world );
  $array_pledge = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="c" type="hidden" value="<?php print ( $_GET [ "c" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center" width="50%">
  <tr>
    <td colspan="2" class="center"><?php print ( $_text [ 169 ] ); ?></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 168 ] ); ?>" /></td>
  </tr>
</table>
</form>
