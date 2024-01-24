<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_modcharpledge ( $_GET [ "u" ], $_GET [ "new_title" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 115 ] ); ?><?php print ( $_GET [ "new_title" ] ); ?>.
<?php
    } else {
?>
  <?php print ( $_text [ 116 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select *, nickname collate polish_ci_as as nickname from user_data (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
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
    <td class="center" width="50%"><?php print ( $_text [ 19 ] ); ?></td>
    <td class="center" width="50%"><input name="new_title" type="text" class="center" value="<?php print ( $array_char [ "nickname" ] ); ?>" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="zatwierdz-zmiany" type="submit" value="<?php print ( $_text [ 114 ] ); ?>" /></td>
  </tr>
</table>
</form>
