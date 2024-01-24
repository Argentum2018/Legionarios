<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 && isset ( $_GET [ "char_name" ] ) && ! empty ( $_GET [ "char_name" ] ) && isset ( $_GET [ "amount" ] ) && ! empty ( $_GET [ "amount" ] ) ) {
  $query = "select * from user_data (nolock) where char_name='" . str_replace ( "'", "''", $_GET [ "char_name" ] ) . "'";
  $res = mssql_query ( $query, $link_world );
  $array_char = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
  if ( $array_char ) {
    l2_kickcharacter ( $array_char [ "char_id" ] );
    $query = "insert into donation_log ( set_id, account_id, account_name, char_id, char_name, amount, status ) values ( " .
      str_replace ( "'", "''", $_GET [ "set_id" ] ) . ", " .
      $array_char [ "account_id" ] . ", " .
      "'" . $array_char [ "account_name" ] . "', " .
      $array_char [ "char_id" ] . ", " .
      "'" . $array_char [ "char_name" ] . "', " .
      str_replace ( "'", "''", $_GET [ "amount" ] ) . ", " .
      " 0 )";
    $res = mssql_query ( $query, $link_panel );
    $query = "select scope_identity() as id";
    $res = mssql_query ( $query, $link_panel );
    $array_donation_log_id = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    $query = "select * from donation_set_item (nolock) where set_id=" . str_replace ( "'", "''", $_GET [ "set_id" ] );
    $res = mssql_query ( $query, $link_panel );
    $i = $j = 0;
    $_SESSION [ "info" ] = "";
    while ( $array_donation = mssql_fetch_array ( $res ) ) {
      if ( $_GET [ "amount" ] >= $array_donation [ "condition" ] ) {
        $query = "insert into donation_log_item ( log_id, set_id, set_item_id, account_id, char_id, item_type, amount, status ) values ( " .
          $array_donation_log_id [ "id" ] . ", " .
          str_replace ( "'", "''", $_GET [ "set_id" ] ) . ", " .
          $array_donation [ "id" ] . ", " .
          $array_char [ "account_id" ] . ", " .
          $array_char [ "char_id" ] . ", " .
          $array_donation [ "item_type" ] . ", " .
          floor ( str_replace ( "'", "''", $_GET [ "amount" ] ) * $array_donation [ "amount" ] / $array_donation [ "divider" ] ) . ", ";
        $ret_string = l2_additem2 ( $array_char [ "char_id" ], 1, $array_donation [ "item_type" ], floor ( $_GET [ "amount" ] * $array_donation [ "amount" ] / $array_donation [ "divider" ] ), 0, 0, 0, 0, 0 );
        if ( $ret_string === "1" ) {
          $_SESSION [ "info" ] .= sprintf ( $_text [ 361 ], $array_donation [ "item_type" ] ) . "<br />";
          $query .= " 1 )";
          $j++;
        } else {
          $_SESSION [ "info" ] .= sprintf ( $_text [ 362 ], $array_donation [ "item_type" ] ) . "<strong>" . mssql_get_last_message () . "</strong><br />";
          $query .= " 0 )";
        }
        mssql_query ( $query, $link_panel );
        $i++;
      }
    }
    if ( $i == $j ) {
      $query = "update donation_log set status=1 where id=" . $array_donation_log_id [ "id" ];
      mssql_query ( $query, $link_panel );
    }
  } else {
    $_SESSION [ "info" ] = $_text [ 307 ];
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
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="1">
<input name="ref" type="hidden" value="1">
<table class="center" width="70%">
  <tr class="naglowek">
    <th width="33%" class="center"><label for="char_name"><?php print ( $_text [ 21 ] ); ?></label></th>
    <th width="33%" class="center"><label for="amount"><?php print ( $_text [ 363 ] ); ?></label></th>
    <th width="33%" class="center"><?php print ( $_text [ 298 ] ); ?></th>
  </tr>
  <tr>
    <td class="center"><input id="char_name" name="char_name" type="text" class="center" /></td>
    <td class="center"><input id="amount" name="amount" type="text" class="center" /></td>
    <td class="center">
      <select name="set_id" class="set">
<?php
$query = "select * from donation_set order by name";
$res = mssql_query ( $query, $link_panel );
while ( $array_donation = mssql_fetch_array ( $res ) ) {
?>
        <option value="<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $array_donation [ "name" ] ); ?></option>
<?php
}
mssql_free_result ( $res );
?>
      </select>
    </td>
  </tr>
  <tr><td colspan="3" height="4"></td></tr>
  <tr>
    <td colspan="3" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 360 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 297 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="center" width="25%"><?php print ( $_text [ 337 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 22 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="12%"><?php print ( $_text [ 363 ] ); ?></th>
    <th class="center" width="18%"><?php print ( $_text [ 300 ] ); ?></th>
  </tr>
<?php
$query = "select dl.*, ds.name from donation_log dl (nolock) inner join donation_set ds (nolock) on dl.set_id=ds.id order by log_date desc, dl.id";
$res = mssql_query ( $query, $link_panel );
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
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=102&amp;d=<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $array_donation [ "id" ] ); ?></a></td>
    <td class="left"><?php print ( $array_donation [ "name" ] ); ?></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=1&amp;l=<?php print ( $array_donation [ "account_name" ] ); ?>"><?php print ( $array_donation [ "account_name" ] ); ?></a></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_donation [ "account_name" ] ); ?>&amp;u=<?php print ( $array_donation [ "char_id" ] ); ?>"><?php print ( $array_donation [ "char_name" ] ); ?></a></td>
    <td class="right"><?php print ( number_format ( $array_donation [ "amount" ], 0, ".", " " ) ); ?></td>
    <td class="center"><?php print ( $array_donation [ "log_date" ] ); ?></td>
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
