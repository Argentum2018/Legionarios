<?php
  $query = "select * from user_log (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " and log_id=1 order by log_date";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 55 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="center" width="15%"><?php print ( $_text [ 282 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 283 ] ); ?></th>
    <th class="left" width="30%"><?php print ( $_text [ 284 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 203 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 75 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_history = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="center"><?php print ( $array_history [ "log_from" ] ); ?></a></td>
    <td class="center"><?php print ( $array_history [ "log_to" ] ); ?></td>
    <th class="center"><?php print ( $array_history [ "log_date" ] ); ?></th>
    <td class="center"><?php print ( $array_history [ "subjob_id" ] ); ?></td>
    <td class="center"><?php print ( number_format ( $array_history [ "use_time" ], 0, ".", " " ) ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
  $query = "select * from user_log (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " and log_id=2 order by log_date";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 56 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="center" width="25%"><?php print ( $_text [ 288 ] ); ?></th>
    <th class="center" width="25%"><?php print ( $_text [ 289 ] ); ?></th>
    <th class="left" width="22%"><?php print ( $_text [ 284 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 203 ] ); ?></th>
    <th class="center" width="18%"><?php print ( $_text [ 75 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_history = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="center"><?php print ( $_text_class [ $array_history [ "log_from" ] ] ); ?></a></td>
    <td class="center"><?php print ( $_text_class [ $array_history [ "log_to" ] ] ); ?></td>
    <th class="center"><?php print ( $array_history [ "log_date" ] ); ?></th>
    <td class="center"><?php print ( $array_history [ "subjob_id" ] ); ?></td>
    <td class="center"><?php print ( number_format ( $array_history [ "use_time" ], 0, ".", " " ) ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
  $query = "select * from user_log (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " and log_id=3 order by log_date";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 290 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="center" width="15%"><?php print ( $_text [ 282 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 283 ] ); ?></th>
    <th class="left" width="30%"><?php print ( $_text [ 284 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 203 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 75 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_history = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="center"><?php print ( $array_history [ "log_from" ] ); ?></a></td>
    <td class="center"><?php print ( $array_history [ "log_to" ] ); ?></td>
    <th class="center"><?php print ( $array_history [ "log_date" ] ); ?></th>
    <td class="center"><?php print ( $array_history [ "subjob_id" ] ); ?></td>
    <td class="center"><?php print ( number_format ( $array_history [ "use_time" ], 0, ".", " " ) ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
