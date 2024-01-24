<?php
  $query = "select ag.*, ab.*, p.name pledge_name, p.alliance_id, ud.*, a.name alliance_name from agit ag (nolock) inner join agit_bid ab (nolock) on ag.auction_id=ab.auction_id left outer join pledge p (nolock) on ab.attend_pledge_id=p.pledge_id left outer join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where ag.id=" . str_replace ( "'", "''", $_GET [ "a" ] ) . " order by ab.attend_date";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 326 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="21%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="left" width="21%"><?php print ( $_text [ 131 ] ); ?></th>
    <th class="center" width="13%"><?php print ( $_text [ 327 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 328 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 329 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_auction = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_auction [ "attend_id" ] ); ?></td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_auction [ "pledge_id" ] ); ?>">
        <?php print ( $array_auction [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td class="left">
<?php
    if ( ! empty ( $array_auction [ "alliance_id" ] ) ) {
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=4&amp;a=<?php print ( $array_auction [ "alliance_id" ] ); ?>">
        <?php print ( $array_auction [ "alliance_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
    <td class="right"><?php print ( number_format ( $array_auction [ "attend_price" ], 0, ".", " " ) ); ?></td>
    <td class="center"><?php print ( date ( "Y-m-d H:i:s", $array_auction [ "attend_time" ] ) ); ?></td>
    <td class="center"><?php print ( $array_auction [ "attend_date" ] ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
