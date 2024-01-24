<?php
  $query = "select * from war_declare (nolock) inner join pledge (nolock) on challengee=pledge_id where challenger=" . str_replace ( "'", "''", $_GET [ "c" ] ) . " order by name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="80%">
  <caption><?php print ( $_text [ 377 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="right" width="80%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 379 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_war = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_war [ "pledge_id" ] ); ?>"><?php print ( $array_war [ "name" ] ); ?></a></td>
    <td class="center"><?php print ( date ( "Y-m-d H:i:s", $array_war [ "declare_time" ] ) ); ?></td>
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
  $query = "select * from war_declare (nolock) inner join pledge (nolock) on challenger=pledge_id where challengee=" . str_replace ( "'", "''", $_GET [ "c" ] ) . " order by name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="80%">
  <caption><?php print ( $_text [ 378 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="right" width="80%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 379 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_war = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_war [ "pledge_id" ] ); ?>"><?php print ( $array_war [ "name" ] ); ?></a></td>
    <td class="center"><?php print ( date ( "Y-m-d H:i:s", $array_war [ "declare_time" ] ) ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
