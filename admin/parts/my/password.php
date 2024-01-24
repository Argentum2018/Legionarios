<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
?>
<div class="center">
<?php
    if ( $_POST [ "password" ] != $_POST [ "password_confirm" ] ) {
      print ( $_text [ 291 ] );
    } else {
      $query = "update account set " .
        "password=0x" . md5 ( $_POST [ "password" ] ) . " " .
        "where account='" . str_replace ( "'", "''", $_SESSION [ "account" ] ) . "'";
      $res = mssql_query ( $query, $link_panel );
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
  $query = "select * from account (nolock) where account='" . str_replace ( "'", "''", $_SESSION [ "account" ] ) . "'";
  $res = mssql_query ( $query, $link_panel );
  $array_account = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="post" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&o=1">
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
