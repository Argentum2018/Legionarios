<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} else {
  $query = "select top 10 dli.*, dl.char_name, dl.account_name, id.name from donation_log_item dli (nolock) inner join donation_log dl (nolock) on dli.log_id=dl.id inner join " . $sql_db_world . ".dbo.itemdata id (nolock) on dli.item_type=id.id order by dli.log_date desc, id.name";
  $res = mssql_query ( $query, $link_panel );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 301 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="16%"><?php print ( $_text [ 22 ] ); ?></th>
    <th class="left" width="18%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="33%"><?php print ( $_text [ 101 ] ); ?></th>
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
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=102&amp;d=<?php print ( $array_donation [ "log_id" ] ); ?>"><?php print ( $array_donation [ "log_id" ] ); ?></a></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=1&amp;l=<?php print ( $array_donation [ "account_name" ] ); ?>"><?php print ( $array_donation [ "account_name" ] ); ?></a></td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_donation [ "account_name" ] ); ?>&amp;u=<?php print ( $array_donation [ "char_id" ] ); ?>"><?php print ( $array_donation [ "char_name" ] ); ?></a></td>
    <td class="left"><?php print ( $array_donation [ "name" ] ); ?></td>
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
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=1"><?php print ( $_text [ 296 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=2"><?php print ( $_text [ 297 ] ); ?></a>
    </td>
    <td width="25%">
    </td>
    <td width="25%">
    </td>
  </tr>
</table>
<?php
}
?>
