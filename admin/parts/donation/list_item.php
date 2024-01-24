<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
  $query = "select * from donation_log (nolock) where id=" . str_replace ( "'", "''", $_GET [ "d" ] );
  $res = mssql_query ( $query, $link_panel );
  $array_donation_log = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
  l2_kickcharacter ( $array_donation_log [ "char_id" ] );
  $query = "select * from donation_log_item where log_id=" . str_replace ( "'", "''", $_GET [ "d" ] ) . " and status=0 order by log_date desc";
  $res = mssql_query ( $query, $link_panel );
  $i = $j = 0;
  $_SESSION [ "info" ] = "";
  while ( $array_donation = mssql_fetch_array ( $res ) ) {
    $ret_string = l2_additem2 ( $array_donation_log [ "char_id" ], 1, $array_donation [ "item_type" ], $array_donation [ "amount" ], 0, 0, 0, 0, 0 );
    if ( $ret_string === "1" ) {
      $_SESSION [ "info" ] .= sprintf ( $_text [ 361 ], $array_donation [ "item_type" ] ) . "<br />";
      $query = "update donation_log_item set status=1 where id=" . $array_donation [ "id" ];
      mssql_query ( $query, $link_panel );
      $j++;
    } else {
      $_SESSION [ "info" ] .= sprintf ( $_text [ 362 ], $array_donation [ "item_type" ] ) . "<strong>" . mssql_get_last_message () . "</strong><br />";
    }
    $i++;
  }
  if ( $i == $j ) {
    $query = "update donation_log set status=1 where id=" . $array_donation_log [ "id" ];
    mssql_query ( $query, $link_panel );
  }
}
if ( isset ( $_SESSION [ "info" ] ) && ! empty ( $_SESSION [ "info" ] ) ) {
  if ( ! isset ( $_GET [ "o" ] ) ) {
?>
<div class="center">
  <?php print ( $_SESSION [ "info" ] ); ?>
</div>
<br />
<?php
    unset ( $_SESSION [ "info" ] );
  }
}
$query = "select dl.*, ds.name from donation_log dl (nolock) inner join donation_set ds (nolock) on dl.set_id=ds.id where dl.id=" . str_replace ( "'", "''", $_GET [ "d" ] );
$res = mssql_query ( $query, $link_panel );
$i = 0;
$array_donation = mssql_fetch_array ( $res );
if ( $array_donation [ "status" ] == 0 ) {
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="d" type="hidden" value="<?php print ( $_GET [ "d" ] ); ?>">
<input name="o" type="hidden" value="1">
<input name="ref" type="hidden" value="1">
<table class="center" width="50%">
  <tr>
    <td class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 366 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<?php
}
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 364 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="center" width="25%"><?php print ( $_text [ 337 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 22 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="12%"><?php print ( $_text [ 363 ] ); ?></th>
    <th class="center" width="18%"><?php print ( $_text [ 300 ] ); ?></th>
  </tr>
<?php
  if ( $array_donation [ "status" ] == 1 ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
  } else {
?>
  <tr class="donation-err">
<?php
  }
?>
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=102&amp;d=<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $array_donation [ "id" ] ); ?></a></td>
    <td class="left"><?php print ( $array_donation [ "name" ] ); ?></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=1&amp;l=<?php print ( $array_donation [ "account_name" ] ); ?>"><?php print ( $array_donation [ "account_name" ] ); ?></a></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_donation [ "account_name" ] ); ?>&amp;u=<?php print ( $array_donation [ "char_id" ] ); ?>"><?php print ( $array_donation [ "char_name" ] ); ?></a></td>
    <td class="right"><?php print ( number_format ( $array_donation [ "amount" ], 0, ".", " " ) ); ?></td>
    <td class="center"><?php print ( $array_donation [ "log_date" ] ); ?></td>
  </tr>
<?php
mssql_free_result ( $res );
?>
</table>
<br /><br />
<?php
$query = "select dli.*, ds.name, id.name from donation_log_item dli (nolock) inner join donation_set ds (nolock) on dli.set_id=ds.id inner join " . $sql_db_world . ".dbo.itemdata id (nolock) on dli.item_type=id.id where dli.log_id=" . str_replace ( "'", "''", $_GET [ "d" ] ) . " order by log_date desc, id.name";
$res = mssql_query ( $query, $link_panel );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 365 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="7%"><?php print ( $_text [ 298 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 299 ] ); ?></th>
    <th class="center" width="55%"><?php print ( $_text [ 101 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 102 ] ); ?></th>
    <th class="center" width="18%"><?php print ( $_text [ 300 ] ); ?></th>
  </tr>
<?php
$i = 0;
while ( $array_donation = mssql_fetch_array ( $res ) ) {
  if ( $array_donation [ "status" ] == 1 ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
  } else {
?>
  <tr class="donation-err">
<?php
  }
?>
    <td class="center"><?php print ( $array_donation [ "set_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_donation [ "set_item_id" ] ); ?></td>
    <td class="left"><?php print ( $array_donation [ "name" ] ); ?></td>
    <td class="right"><?php print ( number_format ( $array_donation [ "amount" ], 0, ".", " " ) ); ?></td>
    <td class="center"><?php print ( $array_donation [ "log_date" ] ); ?></td>
  </tr>
<?php
}
?>
</table>
