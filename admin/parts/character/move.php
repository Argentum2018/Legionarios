<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $query = "select * from user_account (nolock) where account='" . str_replace ( "'", "''", $_GET [ "new_account" ] ) . "'";
    $res = mssql_query ( $query, $link_db );
    $array_account = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    $ret_string = l2_movecharacter ( $_GET [ "u" ], $array_account [ "uid" ], $array_account [ "account" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 386 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 387 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select * from user_data (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
  $res = mssql_query ( $query, $link_world );
  $array_char = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center" width="50%">
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 385 ] ); ?></td>
    <td class="center" width="50%"><input name="new_account" type="text" class="center" value="<?php print ( $array_char [ "account_name" ] ); ?>" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="zatwierdz-zmiany" type="submit" value="<?php print ( $_text [ 384 ] ); ?>" /></td>
  </tr>
</table>
</form>
