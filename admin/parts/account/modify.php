<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $query = "update ssn set " .
      "name='" . str_replace ( "'", "''", $_GET [ "name" ] ) . "', " .
      "email='" . str_replace ( "'", "''", $_GET [ "email" ] ) . "', " .
      "addr_main='" . str_replace ( "'", "''", $_GET [ "addr_main" ] ) . "', " .
      "phone='" . str_replace ( "'", "''", $_GET [ "phone" ] ) . "' " .
      "where ssn='" . str_replace ( "'", "''", $_GET [ "ssn" ] ) . "'";
    $res = mssql_query ( $query, $link_db );
?>
<div class="center">
<?php
    if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 272 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 273 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
    }
?>
</div>
<br /><br />
<?php
  }
  $query = "select * from user_account ua (nolock) inner join user_info ui (nolock) on ua.account=ui.account inner join user_auth uau (nolock) on ua.account=uau.account inner join ssn (nolock) on ui.ssn=ssn.ssn where ua.account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
  $res = mssql_query ( $query, $link_db );
  $array_account = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="ssn" type="hidden" value="<?php print ( $array_account [ "ssn" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center" width="60%">
  <caption><?php print ( $_text [ 268 ] ); ?></caption>
  <tr>
    <td class="center" width="30%"><?php print ( $_text [ 258 ] ); ?></td>
    <td width="70%">
      <input class="account" name="name" value="<?php print ( $array_account [ "name" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 259 ] ); ?></td>
    <td>
      <input class="account" name="email" value="<?php print ( $array_account [ "email" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 260 ] ); ?></td>
    <td>
      <input class="account" name="phone" value="<?php print ( $array_account [ "phone" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 261 ] ); ?></td>
    <td>
      <input class="account" name="addr_main" value="<?php print ( $array_account [ "addr_main" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 373 ] ); ?></td>
    <td>
      <input class="account" name="addr_etc" value="<?php print ( $array_account [ "addr_etc" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 374 ] ); ?></td>
    <td>
      <input class="account" name="zip" value="<?php print ( $array_account [ "zip" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 270 ] ); ?>">
    </td>
  </tr>
</table>
</form>
