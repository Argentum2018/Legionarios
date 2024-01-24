<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_modifyskill2 ( $_GET [ "u" ], $_GET [ "skill_id" ], $_GET [ "skill_level" ], $_GET [ "subjob_id" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 183 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 184 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select us.*, ud.*, s.* from user_skill us (nolock) inner join user_data ud (nolock) on us.char_id=ud.char_id left outer join skilldata s (nolock) on us.skill_id=s.id and us.skill_lev=s.lev where us.char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " and us.skill_id=" . str_replace ( "'", "''", $_GET [ "skill_id" ] ) . " and us.subjob_id=" . str_replace ( "'", "''", $_GET [ "subjob_id" ] );
  $res = mssql_query ( $query, $link_world );
  $array_skill = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<input name="skill_id" type="hidden" value="<?php print ( $_GET [ "skill_id" ] ); ?>" />
<input name="subjob_id" type="hidden" value="<?php print ( $_GET [ "subjob_id" ] ); ?>" />
<table class="center list">
  <caption><?php print ( $_text [ 265 ] ); ?></caption>
  <tr class="naglowek">
    <th width="50%"><?php print ( $_text [ 198 ] ); ?></th>
    <th width="50%"><?php print ( $_text [ 199 ] ); ?></th>
  </tr>
  <tr class="char">
    <td><?php print ( $array_skill [ "skill_id" ] ); ?></td>
    <td>
      <input class="item" name="skill_level" value="<?php print ( $array_skill [ "skill_lev" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td colspan="2" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 266 ] ); ?>">
    </td>
  </tr>
</table>
</form>
