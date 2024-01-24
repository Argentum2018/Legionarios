<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
  $query = "update donation_set set name='" . str_replace ( "'", "''", $_GET [ "set_name" ] ) . "' where id=" . str_replace ( "'", "''", $_GET [ "s" ] );
  $res = mssql_query ( $query, $link_panel );
  if ( $res !== FALSE ) {
    $_SESSION [ "info" ] = $_text [ 355 ];
  } else {
    $_SESSION [ "info" ] = $_text [ 356 ] . "<strong>" . mssql_get_last_message () . "</strong>";
  }
} elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
  $query = "insert into donation_set_item ( set_id, item_type, amount, divider, condition, status ) values ( " .
    str_replace ( "'", "''", $_GET [ "s" ] ) . ", " .
    str_replace ( "'", "''", $_GET [ "item_type" ] ) . ", " .
    str_replace ( "'", "''", $_GET [ "amount" ] ) . ", " .
    str_replace ( "'", "''", $_GET [ "divider" ] ) . ", " .
    "'" . str_replace ( "'", "''", $_GET [ "condition" ] ) . "', " .
    " 0 )";
  $res = mssql_query ( $query, $link_panel );
  if ( $res !== FALSE ) {
    $_SESSION [ "info" ] = $_text [ 343 ];
  } else {
    $_SESSION [ "info" ] = $_text [ 344 ] . "<strong>" . mssql_get_last_message () . "</strong>";
  }
} elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 3 ) {
  $query = "delete from donation_set_item where id=" . str_replace ( "'", "''", $_GET [ "i" ] );
  $res = mssql_query ( $query, $link_panel );
  if ( $res !== FALSE ) {
    $_SESSION [ "info" ] = $_text [ 351 ];
  } else {
    $_SESSION [ "info" ] = $_text [ 352 ] . "<strong>" . mssql_get_last_message () . "</strong>";
  }
} elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 4 ) {
  $_SESSION [ "referer" ] = $_SERVER [ "HTTP_REFERER" ];
} elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 5 ) {
  $query = "update donation_set_item set " .
    "item_type=" . str_replace ( "'", "''", $_GET [ "item_type" ] ) . ", " .
    "amount=" . str_replace ( "'", "''", $_GET [ "amount" ] ) . ", " .
    "divider=" . str_replace ( "'", "''", $_GET [ "divider" ] ) . ", " .
    "condition='" . str_replace ( "'", "''", $_GET [ "condition" ] ) . "' " .
    "where id=" . str_replace ( "'", "''", $_GET [ "i" ] );
  $res = mssql_query ( $query, $link_panel );
  if ( $res !== FALSE ) {
    $_SESSION [ "info" ] = $_text [ 358 ];
  } else {
    $_SESSION [ "info" ] = $_text [ 359 ] . "<strong>" . mssql_get_last_message () . "</strong>";
  }
}
if ( isset ( $_SESSION [ "info" ] ) && ! empty ( $_SESSION [ "info" ] ) ) {
  if ( ! isset ( $_GET [ "o" ] ) ) {
?>
<div class="center">
  <?php print ( $_SESSION [ "info" ] ); ?>
</div>
<br /><br />
<?php
    unset ( $_SESSION [ "info" ] );
  }
}
$query = "select * from donation_set (nolock) where id=" . str_replace ( "'", "''", $_GET [ "s" ] );
$res = mssql_query ( $query, $link_panel );
$array_donation = mssql_fetch_array ( $res );
mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="s" type="hidden" value="<?php print ( $_GET [ "s" ] ); ?>">
<input name="o" type="hidden" value="1">
<input name="ref" type="hidden" value="1">
<table class="center" width="40%">
  <tr class="naglowek">
    <th class="center"><label for="item_type"><?php print ( $_text [ 337 ] ); ?></label></th>
  </tr>
  <tr>
    <td class="center"><input id="item_type" name="set_name" type="text" class="center set-name" value="<?php print ( $array_donation [ "name" ] ); ?>"/></td>
  </tr>
  <tr><td height="4"></td></tr>
  <tr>
    <td class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 354 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="s" type="hidden" value="<?php print ( $_GET [ "s" ] ); ?>">
<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 4 ) {
?>
<input name="o" type="hidden" value="5">
<input name="i" type="hidden" value="<?php print ( $_GET [ "i" ] ); ?>">
<?php
} else {
?>
<input name="o" type="hidden" value="2">
<?php
}
?>
<input name="ref" type="hidden" value="1">
<table class="center" width="80%">
  <tr class="naglowek">
    <th width="25%" class="center"><label for="item_type"><?php print ( $_text [ 349 ] ); ?></label></th>
    <th width="25%" class="center"><label for="amount"><?php print ( $_text [ 102 ] ); ?></label></th>
    <th width="25%" class="center"><label for="divider"><?php print ( $_text [ 353 ] ); ?></label></th>
    <th width="25%" class="center"><label for="condition"><?php print ( $_text [ 350 ] ); ?></label></th>
  </tr>
<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 4 ) {
$query = "select * from donation_set_item (nolock) where id=" . str_replace ( "'", "''", $_GET [ "i" ] );
$res = mssql_query ( $query, $link_panel );
$array_donation = mssql_fetch_array ( $res );
mssql_free_result ( $res );
?>
  <tr>
    <td class="center"><input id="item_type" name="item_type" type="text" class="center" value="<?php print ( $array_donation [ "item_type" ] ); ?>" /></td>
    <td class="center"><input id="amount" name="amount" type="text" class="center" value="<?php print ( $array_donation [ "amount" ] ); ?>" /></td>
    <td class="center"><input id="divider" name="divider" type="text" class="center" value="<?php print ( $array_donation [ "divider" ] ); ?>" /></td>
    <td class="center"><input id="condition" name="condition" type="text" class="center" value="<?php print ( $array_donation [ "condition" ] ); ?>" /></td>
  </tr>
<?php
} else {
?>
  <tr>
    <td class="center"><input id="item_type" name="item_type" type="text" class="center" /></td>
    <td class="center"><input id="amount" name="amount" type="text" class="center" /></td>
    <td class="center"><input id="divider" name="divider" type="text" class="center" /></td>
    <td class="center"><input id="condition" name="condition" type="text" class="center" /></td>
  </tr>
<?php
}
?>
  <tr><td colspan="4" height="4"></td></tr>
  <tr>
<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 4 ) {
?>
    <td colspan="4" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 357 ] ); ?>"></td>
<?php
} else {
?>
    <td colspan="4" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 340 ] ); ?>"></td>
<?php
}
?>
  </tr>
</table>
</form>
<br />
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 338 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="center" width="43%"><?php print ( $_text [ 349 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 102 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 353 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 350 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
$query = "select dsi.*, id.name from donation_set_item dsi (nolock) inner join " . $sql_db_world . ".dbo.itemdata id (nolock) on dsi.item_type=id.id where dsi.set_id=" . str_replace ( "'", "''", $_GET [ "s" ] ) . " order by id.name";
$res = mssql_query ( $query, $link_panel );
$i = 0;
while ( $array_donation = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_donation [ "id" ] ); ?></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;s=<?php print ( $array_donation [ "set_id" ] ); ?>&amp;o=4&amp;i=<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $array_donation [ "name" ] ); ?></a></td>
    <td class="right"><?php print ( number_format ( $array_donation [ "amount" ], 0, ".", " " ) ); ?></td>
    <td class="right"><?php print ( number_format ( $array_donation [ "divider" ], 0, ".", " " ) ); ?></td>
    <td class="right"><?php print ( number_format ( $array_donation [ "condition" ], 0, ".", " " ) ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;s=<?php print ( $array_donation [ "set_id" ] ); ?>&amp;o=3&amp;ref=1&amp;i=<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
}
?>
</table>
<br /><br />
<table class="center button">
  <tr>
    <td width="25%">
    </td>
    <td width="25%">
    </td>
    <td width="25%">
    </td>
    <td width="25%">
    </td>
  </tr>
</table>
<?php
mssql_free_result ( $res );
?>
