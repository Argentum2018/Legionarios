<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_modpledgename ( $_GET [ "c" ], $_GET [ "new_pledge_name" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
      sleep ( $cached_wait ); // You must wait for cached to make changes in SQL DB
      $query = "update pledge set name='" . str_replace ( "'", "''", $_GET [ "new_pledge_name" ] ) . "' where pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] );
      $res = mssql_query ( $query, $link_world );
?>
  <?php print ( $_text [ 166 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 167 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
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
    <td class="center" width="50%"><?php print ( $_text [ 129 ] ); ?></td>
    <td class="center" width="50%"><input name="new_pledge_name" type="text" class="center" value="<?php print ( $array_pledge [ "name" ] ); ?>" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 165 ] ); ?>" /></td>
  </tr>
</table>
</form>
