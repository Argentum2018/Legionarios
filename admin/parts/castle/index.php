<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} elseif ( isset ( $_GET [ "c" ] ) && ! empty ( $_GET [ "c" ] ) ) {
  $query = "select c.*, p.name pledge_name, p.alliance_id, ud.*, a.name alliance_name from castle c (nolock) left outer join pledge p (nolock) on c.pledge_id=p.pledge_id left outer join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where c.id=" . str_replace ( "'", "''", $_GET [ "c" ] );
  $res = mssql_query ( $query, $link_world );
  $array_castle = mssql_fetch_array ( $res );
?>
<table class="center list">
  <tr class="naglowek">
    <th width="25%"><?php print ( $_text [ 240 ] ); ?></th>
    <th width="25%"><?php print ( $_text_castle [ $array_castle [ "id" ] ] ); ?></th>
    <th width="25%"><?php print ( $_text [ 130 ] ); ?></th>
    <th width="25%"><?php print ( $array_castle [ "id" ] ); ?></th>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 18 ] ); ?></td>
    <td>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_castle [ "pledge_id" ] ); ?>">
        <?php print ( $array_castle [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td><?php print ( $_text [ 132 ] ); ?></td>
    <td>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_castle [ "account_name" ] ); ?>&amp;u=<?php print ( $array_castle [ "char_id" ] ); ?>">
        <?php print ( $array_castle [ "char_name" ] ); ?>
      </a>
    </td>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 316 ] ); ?></td>
    <td><?php print ( $array_castle [ "tax_rate" ] ); ?>%</td>
    <td><?php print ( $_text [ 317 ] ); ?></td>
    <td><?php print ( date ( "Y-m-d H:i:s", $array_castle [ "next_war_time" ] ) ); ?></td>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 318 ] ); ?></td>
    <td><?php print ( $array_castle [ "tax_rate_to_change" ] ); ?>%</td>
    <td><?php print ( $_text [ 321 ] ); ?></td>
    <td><?php print ( $array_castle [ "status" ] ); ?></td>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 319 ] ); ?></td>
    <td><?php print ( number_format ( $array_castle [ "shop_income" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 320 ] ); ?></td>
    <td><?php print ( number_format ( $array_castle [ "shop_income_temp" ], 0, ".", " " ) ); ?></td>
  </tr>
</table>
<?php
  mssql_free_result ( $res );
?>
<br />
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
} else {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/search.php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
}
?>
