<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $_GET [ "name_color" ] = preg_replace ( "/[#\s]/", "", $_GET [ "name_color" ] );
    if ( $_GET [ "name_color" ] >= 0 ) {
      $query = "update user_name_color set " .
        "color_rgb=" . ( hexdec ( substr ( $_GET [ "name_color" ], 0, 2 ) ) + ( hexdec ( substr ( $_GET [ "name_color" ], 2, 2 ) ) << 8 ) + ( hexdec ( substr ( $_GET [ "name_color" ], 4, 2 ) ) << 16 ) ) . " " .
        "where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
    } else {
      $query = "delete from user_name_color " .
        "where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
    }
    $res = mssql_query ( $query, $link_world );
    $num_rows = mssql_num_rows ( $res );
    mssql_free_result ( $res );
    if ( $num_rows <= 0 ) {
      $query = "insert into user_name_color ( char_id, color_rgb ) values ( " .
        str_replace ( "'", "''", $_GET [ "u" ] ) . ", " .
        ( hexdec ( substr ( $_GET [ "name_color" ], 0, 2 ) ) + ( hexdec ( substr ( $_GET [ "name_color" ], 2, 2 ) ) << 8 ) + ( hexdec ( substr ( $_GET [ "name_color" ], 4, 2 ) ) << 16 ) ) . " ) ";
      $res = mssql_query ( $query, $link_world );
    }
?>
<div class="center">
<?php
    if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 123 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 124 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
    }
    if ( $num_rows <= 0 ) {
      mssql_free_result ( $res );
    }
?>
<br /><br />
<?php
  }
  $query = "select ud.*, p.*, unc.color_rgb from user_data ud (nolock) left outer join pledge p on ud.pledge_id=p.pledge_id left outer join user_name_color unc on ud.char_id=unc.char_id where ud.char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
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
    <td class="center" width="50%"><?php print ( $_text [ 83 ] ); ?></td>
    <td class="center" width="50%"><input name="name_color" type="text" class="center" value="#<?php printf ( "%02X%02X%02X", $array_char [ "color_rgb" ] & 0xff, ( $array_char [ "color_rgb" ] & 0xff00 ) >> 8, ( $array_char [ "color_rgb" ] & 0xff0000 ) >> 16 ); ?>" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="zatwierdz-zmiany" type="submit" value="<?php print ( $_text [ 128 ] ); ?>" /></td>
  </tr>
</table>
</form>
