<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_sendhome ( $_GET [ "u" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 117 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 118 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    $ret_string = l2_setcharacterlocation ( $_GET [ "u" ], $_GET [ "x" ], $_GET [ "y" ], $_GET [ "z" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 121 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 122 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
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
<table class="center" width="70%">
  <tr>
    <td width="50%" class="center"><input class="zatwierdz-zmiany" type="submit" value="<?php print ( $_text [ 119 ] ); ?>" /></td>
  </tr>
</table>
</form>
<br />
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="2" />
<table class="center" width="70%">
  <tr class="naglowek">
    <th width="33%">X</th>
    <th width="33%">Y</th>
    <th width="33%">Z</th>
  </tr>
  <tr>
    <td class="center"><input name="x" type="text" class="center" value="<?php print ( $array_char [ "xloc" ] ); ?>" /></td>
    <td class="center"><input name="y" type="text" class="center" value="<?php print ( $array_char [ "yloc" ] ); ?>" /></td>
    <td class="center"><input name="z" type="text" class="center" value="<?php print ( $array_char [ "zloc" ] ); ?>" /></td>
  </tr>
  <tr><td colspan="3" height="4"></td></tr>
  <tr>
    <td colspan="3" class="center"><input class="zatwierdz-zmiany" type="submit" value="<?php print ( $_text [ 120 ] ); ?>" /></td>
  </tr>
</table>
</form>
