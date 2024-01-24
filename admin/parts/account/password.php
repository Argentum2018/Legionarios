<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
?>
<div class="center">
<?php
    if ( $_POST [ "password" ] != $_POST [ "password_confirm" ] ) {
      print ( $_text [ 291 ] );
    } else {
      $query = "update user_auth set " .
        "password=" . password_encrypt ( $_POST [ "password" ] ) . " " .
        "where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
      $res = mssql_query ( $query, $link_db );
?>
<?php
      if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 251 ] ); ?>
<?php
      } else {
?>
  <?php print ( $_text [ 252 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
      }
    }
?>
</div>
<br /><br />
<?php
  }
  $query = "select * from user_auth (nolock) where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
  $res = mssql_query ( $query, $link_db );
  $array_account = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="post" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=1">
<table class="center" width="50%">
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 253 ] ); ?></td>
    <td class="center" width="50%"><input name="password" type="password" class="center" /></td>
  </tr>
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 254 ] ); ?></td>
    <td class="center" width="50%"><input name="password_confirm" type="password" class="center" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 250 ] ); ?>" /></td>
  </tr>
</table>
</form>
