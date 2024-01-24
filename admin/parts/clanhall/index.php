<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} elseif ( isset ( $_GET [ "a" ] ) && ! empty ( $_GET [ "a" ] ) ) {
  $query = "select ag.*, aa.*, p.name pledge_name, p.alliance_id, ud.*, a.name alliance_name from agit ag (nolock) left outer join agit_auction aa (nolock) on ag.auction_id=aa.auction_id left outer join pledge p (nolock) on ag.pledge_id=p.pledge_id left outer join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where ag.id=" . str_replace ( "'", "''", $_GET [ "a" ] );
  $res = mssql_query ( $query, $link_world );
  $array_agit = mssql_fetch_array ( $res );
?>
<table class="center list">
  <tr class="naglowek">
    <th width="25%"><?php print ( $_text [ 241 ] ); ?></th>
    <th width="25%"><?php print ( $_text_agit [ $array_agit [ "id" ] ] ); ?></th>
    <th width="25%"><?php print ( $_text [ 130 ] ); ?></th>
    <th width="25%"><?php print ( $array_agit [ "id" ] ); ?></th>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 18 ] ); ?></td>
    <td>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_agit [ "pledge_id" ] ); ?>">
        <?php print ( $array_agit [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td><?php print ( $_text [ 132 ] ); ?></td>
    <td>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_agit [ "account_name" ] ); ?>&amp;u=<?php print ( $array_agit [ "char_id" ] ); ?>">
        <?php print ( $array_agit [ "char_name" ] ); ?>
      </a>
    </td>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 316 ] ); ?></td>
    <td><?php print ( ! empty ( $array_agit [ "auction_tax" ] ) ? $array_agit [ "auction_tax" ] . "%" : "" ); ?></td>
    <td><?php print ( $_text [ 317 ] ); ?></td>
    <td><?php print ( date ( "Y-m-d H:i:s", $array_agit [ "next_war_time" ] ) ); ?></td>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 322 ] ); ?></td>
    <td><?php print ( number_format ( $array_agit [ "last_price" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 323 ] ); ?></td>
    <td><?php print ( date ( "Y-m-d H:i:s", $array_agit [ "next_cost" ] ) ); ?></td>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 334 ] ); ?></td>
    <td><?php print ( number_format ( $array_agit [ "min_price" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 330 ] ); ?></td>
    <td><?php print ( date ( "Y-m-d H:i:s", $array_agit [ "auction_time" ] ) ); ?></td>
  </tr>
</table>
<?php
  mssql_free_result ( $res );
?>
<br />
<table class="center button">
  <tr>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;a=<?php print ( $array_agit [ "id" ] ); ?>&amp;f=1"><?php print ( $_text [ 324 ] ); ?></a>
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
} else {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/search.php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
}
?>
