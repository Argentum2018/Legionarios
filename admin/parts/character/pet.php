<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_createpet ( $_GET [ "u" ], $_GET [ "item_type" ], $_GET [ "level" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 187 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 188 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    $ret_string = l2_delitem2 ( $_GET [ "pet_id" ], 1 );
    $query = "delete from pet_data where pet_id=" . str_replace ( "'", "''", $_GET [ "pet_id" ] );
    $res = mssql_query ( $query, $link_world );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 189 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 190 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  }
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>">
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="1">
<table class="center" width="50%">
  <tr class="naglowek">
    <th class="center" width="50%"><?php print ( $_text [ 209 ] ); ?></th>
    <th class="center" width="50%"><?php print ( $_text [ 210 ] ); ?></th>
  </tr>
  <tr>
    <td class="center">
      <select name="item_type" class="pet">
<?php
  foreach ( $_text_pet as $item_type => $pet_name ) {
?>
        <option value="<?php print ( $item_type ); ?>"><?php print ( $pet_name ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <th class="center"><input name="level" type="text" class="center"></td>
  </tr>
  <tr><td colspan="3" height="4"></td></tr>
  <tr>
    <td colspan="3" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 211 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<?php
  $query = "select * from user_item (nolock) inner join pet_data (nolock) on item_id=pet_id left outer join npcname (nolock) on npc_class_id=npc_id where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " order by nick_name, pet_id";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="80%">
  <caption><?php print ( $_text [ 212 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 213 ] ); ?></th>
    <th class="left" width="18%"><?php print ( $_text [ 209 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 214 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 218 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 215 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 216 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 217 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_pet = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="center"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=7&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;u=<?php print ( $_GET [ "u" ] ); ?>&amp;f=101&amp;pt=<?php print ( $array_pet [ "pet_id" ] ); ?>"><?php print ( $array_pet [ "pet_id" ] ); ?></a></td>
    <td class="left"><?php print ( $array_pet [ "npc_name" ] ); ?></td>
    <th class="left"><?php print ( $array_pet [ "nick_name" ] ); ?></th>
    <td class="center"><?php print ( $array_pet [ "expoint" ] ); ?></td>
    <td class="center"><?php print ( $array_pet [ "hp" ] ); ?></td>
    <td class="center"><?php print ( $array_pet [ "mp" ] ); ?></td>
    <td class="center"><?php print ( $array_pet [ "meal" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;u=<?php print ( $_GET [ "u" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=2&amp;pet_id=<?php print ( $array_pet [ "pet_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
