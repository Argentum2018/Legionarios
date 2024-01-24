<?php
  $query = "select ag.*, aa.*, p.name pledge_name, p.alliance_id, ud.*, a.name alliance_name from agit ag (nolock) left outer join agit_auction aa (nolock) on ag.auction_id=aa.auction_id left outer join pledge p (nolock) on ag.pledge_id=p.pledge_id left outer join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id  order by ag.name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 315 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="20%"><?php print ( $_text [ 240 ] ); ?></th>
    <th class="left" width="29%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="left" width="26%"><?php print ( $_text [ 131 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 335 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_agit = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_agit [ "id" ] ); ?></td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;a=<?php print ( $array_agit [ "id" ] ); ?>">
        <?php print ( $_text_agit [ $array_agit [ "id" ] ] ); ?>
      </a>
    </td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_agit [ "pledge_id" ] ); ?>">
        <?php print ( $array_agit [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td class="left">
<?php
    if ( ! empty ( $array_agit [ "alliance_id" ] ) ) {
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=4&amp;a=<?php print ( $array_agit [ "alliance_id" ] ); ?>">
        <?php print ( $array_agit [ "alliance_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
<?php
    if ( ! empty ( $array_agit [ "next_war_time" ] ) ) {
?>
    <td class="war center"><?php print ( date ( "Y-m-d H:i:s", $array_agit [ "next_war_time" ] ) ); ?></td>
<?php
    } elseif ( ! empty ( $array_agit [ "auction_time" ] ) ) {
?>
    <td class="auction center"><?php print ( date ( "Y-m-d H:i:s", $array_agit [ "auction_time" ] ) ); ?></td>
<?php
    } else {
?>
    <td class="center"></td>
<?php
    }
?>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
