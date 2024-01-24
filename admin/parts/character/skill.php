<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_addskill2 ( $_GET [ "u" ], $_GET [ "skill_id" ], $_GET [ "skill_level" ], $_GET [ "subjob_id" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 179 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 180 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    $ret_string = l2_delskill2 ( $_GET [ "u" ], $_GET [ "skill_id" ], $_GET [ "subjob_id" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 181 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 182 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 3 ) {
    $ret_string = l2_setskillall ( $_GET [ "u" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 185 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 186 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  }
  $query = "select * from user_data (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
  $res = mssql_query ( $query, $link_world );
  $array_char = mssql_fetch_array ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>">
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="1">
<table class="center" width="80%">
  <tr class="naglowek">
    <th class="center" width="33%"><?php print ( $_text [ 203 ] ); ?></th>
    <th class="center" width="33%"><?php print ( $_text [ 198 ] ); ?></th>
    <th class="center" width="33%"><?php print ( $_text [ 199 ] ); ?></th>
  </tr>
  <tr>
    <td class="center">
      <select name="subjob_id" class="subclass">
<?php
  for ( $subjob_id = 0; $subjob_id < 4; $subjob_id++ ) {
    if ( $array_char [ "subjob" . $subjob_id . "_class" ] < 0 ) {
?>
        <option value="<?php print ( $subjob_id ); ?>"><?php print ( $subjob_id . " - " . $_text [ 220 ] ); ?></option>
<?php
    } else {
?>
        <option value="<?php print ( $subjob_id ); ?>"><?php print ( $subjob_id . " - " . $_text_class [ $array_char [ "subjob" . $subjob_id . "_class" ] ] ); ?></option>
<?php
    }
  } 
?>
      </select>
    </td>
    <td class="center"><input name="skill_id" type="text" class="center"></td>
    <th class="center"><input name="skill_level" type="text" class="center"></td>
  </tr>
  <tr><td colspan="3" height="4"></td></tr>
  <tr>
    <td colspan="3" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 200 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>">
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="3">
<table class="center" width="80%">
  <tr>
    <td colspan="3" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 219 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<?php
  for ( $subjob_id = 0; $subjob_id < 4; $subjob_id++ ) {
    $query = "select * from user_skill (nolock) left outer join skilldata (nolock) on skill_id=id and skill_lev=lev where subjob_id=" . $subjob_id . " and char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " order by name, skill_id";
    $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="80%">
  <caption><?php print ( $_text [ 201 ] . $subjob_id ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 204 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 205 ] ); ?></th>
    <th class="left" width="60%"><?php print ( $_text [ 206 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 207 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
    $i = 0;
    while ( $array_skill = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="center"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=6&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;u=<?php print ( $_GET [ "u" ] ); ?>&amp;f=101&amp;subjob_id=<?php print ( $subjob_id ); ?>&amp;skill_id=<?php print ( $array_skill [ "skill_id" ] ); ?>"><?php print ( $array_skill [ "skill_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_skill [ "skill_lev" ] ); ?></td>
    <th class="left"><?php print ( $array_skill [ "name" ] ); ?></th>
    <td class="center"><?php print ( $array_skill [ "to_end_time" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;u=<?php print ( $_GET [ "u" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=2&amp;subjob_id=<?php print ( $subjob_id ); ?>&amp;skill_id=<?php print ( $array_skill [ "skill_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
    }
?>
</table>
<?php
    mssql_free_result ( $res );
?>
<br />
<?php
  }
?>
