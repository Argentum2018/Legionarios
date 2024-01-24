<?php
if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 && isset ( $_GET [ "name" ] ) && ! empty ( $_GET [ "name" ] ) ) {
  $query = "insert into donation_set ( name, status ) values ( '" . str_replace ( "'", "''", $_GET [ "name" ] ) . "', 0 )";
  $res = mssql_query ( $query, $link_panel );
  if ( $res !== FALSE ) {
    $_SESSION [ "info" ] = $_text [ 341 ];
  } else {
    $_SESSION [ "info" ] = $_text [ 342 ] . "<strong>" . mssql_get_last_message () . "</strong>";
  }
} elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
  $query = "delete from donation_set where id=" . str_replace ( "'", "''", $_GET [ "s" ] );
  $res = mssql_query ( $query, $link_panel );
  if ( $res !== FALSE ) {
    $_SESSION [ "info" ] = $_text [ 345 ];
  } else {
    $_SESSION [ "info" ] = $_text [ 346 ] . "<strong>" . mssql_get_last_message () . "</strong>";
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
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="1">
<input name="ref" type="hidden" value="1">
<table class="center" width="40%">
  <tr class="naglowek">
    <th class="center"><label for="name"><?php print ( $_text [ 337 ] ); ?></label></th>
  </tr>
  <tr>
    <td class="center"><input id="name" name="name" type="text" class="center set-name" /></td>
  </tr>
  <tr><td height="4"></td></tr>
  <tr>
    <td class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 339 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 338 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="center" width="40%"><?php print ( $_text [ 337 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 11 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 300 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 321 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
$query = "select * from donation_set (nolock) order by name";
$res = mssql_query ( $query, $link_panel );
$i = 0;
while ( $array_donation = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_donation [ "id" ] ); ?></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=101&amp;s=<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $array_donation [ "name" ] ); ?></a></td>
    <td class="center"><?php print ( $array_donation [ "create_date" ] ); ?></td>
    <td class="center"><?php print ( $array_donation [ "modify_date" ] ); ?></td>
    <td class="center"><?php print ( $array_donation [ "status" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=2&amp;ref=1&amp;s=<?php print ( $array_donation [ "id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
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
