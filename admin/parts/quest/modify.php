<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_setquest ( $_GET [ "u" ], $_GET [ "quest_id" ], $_GET [ "progress" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 276 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 277 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select q.q" . str_replace ( "'", "''", $_GET [ "quest_num" ] ) . " as quest_id, q.s" . str_replace ( "'", "''", $_GET [ "quest_num" ] ) . " as quest_status, ud.*, qd.* from quest q (nolock) inner join user_data ud (nolock) on q.char_id=ud.char_id left outer join questdata qd (nolock) on q.q" . str_replace ( "'", "''", $_GET [ "quest_num" ] ) . "=qd.id where q.char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
  $res = mssql_query ( $query, $link_world );
  $array_quest = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<input name="quest_id" type="hidden" value="<?php print ( $_GET [ "quest_id" ] ); ?>" />
<input name="quest_num" type="hidden" value="<?php print ( $_GET [ "quest_num" ] ); ?>" />
<table class="center list">
  <caption><?php print ( $_text [ 265 ] ); ?></caption>
  <tr class="naglowek">
    <th width="50%"><?php print ( $_text [ 274 ] ); ?></th>
    <th width="50%"><?php print ( $_text [ 275 ] ); ?></th>
  </tr>
  <tr class="char">
    <td><?php print ( $array_quest [ "quest_id" ] ); ?></td>
    <td>
      <input class="item" name="progress" value="<?php print ( $array_quest [ "quest_status" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td colspan="2" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 266 ] ); ?>">
    </td>
  </tr>
</table>
</form>
