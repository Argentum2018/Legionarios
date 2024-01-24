<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_pledgechangeowner ( $_GET [ "c" ], $_GET [ "new_leader" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 381 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 382 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select * from pledge (nolock) where pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] );
  $res = mssql_query ( $query, $link_world );
  $array_clan = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
  $query = "select * from user_data (nolock) where pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] ) . " order by char_name";
  $res = mssql_query ( $query, $link_world );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="c" type="hidden" value="<?php print ( $_GET [ "c" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center" width="40%">
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 383 ] ); ?></td>
    <td class="center" width="50%">
      <select class="leader" name="new_leader">
<?php
  while ( $array_char = mssql_fetch_array ( $res ) ) {
    if ( $array_char [ "account_id" ] > 0 ) {
      if ( $array_char [ "char_id" ] == $array_clan [ "ruler_id" ] ) {
?>
        <option class="leader" value="<?php print ( $array_char [ "char_id" ] ); ?>" selected>* <?php print ( $array_char [ "char_name" ] ); ?> *</option>
<?php
      } else {
?>
        <option value="<?php print ( $array_char [ "char_id" ] ); ?>"><?php print ( $array_char [ "char_name" ] ); ?></option>
<?php
      }
    }
  }
?>
    </td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 380 ] ); ?>" /></td>
  </tr>
</table>
</form>
<?php
  mssql_free_result ( $res );
?>
