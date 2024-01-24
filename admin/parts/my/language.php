<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
?>
<div class="center">
<?php
    $query = "update account set " .
      "language='" . str_replace ( "'", "''", $_GET [ "lang" ] ) . "' " .
      "where account='" . str_replace ( "'", "''", $_SESSION [ "account" ] ) . "'";
    $res = mssql_query ( $query, $link_panel );
    $_SESSION [ "lang" ] = $_GET [ "lang" ];
?>
<?php
    if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 310 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 311 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
    }
    mssql_free_result ( $res );
?>
</div>
<br /><br />
<?php
  }
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center" width="50%">
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 308 ] ); ?></td>
    <td class="center" width="50%">
      <select name="lang" class="language">
<?php
  foreach ( $array_pages_language as $language_key => $language ) {
?>
        <option value="<?php print ( $language_key ); ?>"><?php print ( ucfirst ( $language ) ); ?></option>
<?php
  }
?>
      </select>
    </td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 309 ] ); ?>" /></td>
  </tr>
</table>
</form>
