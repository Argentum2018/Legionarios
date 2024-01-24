<?php
  $query = "select c.*, p.name pledge_name, p.alliance_id, ud.*, a.name alliance_name from castle c (nolock) left outer join pledge p (nolock) on c.pledge_id=p.pledge_id left outer join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id order by c.name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 314 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="17%"><?php print ( $_text [ 240 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 131 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 316 ] ); ?></th>
    <th class="center" width="20%"><?php print ( $_text [ 317 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_castle = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_castle [ "id" ] ); ?></td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;c=<?php print ( $array_castle [ "id" ] ); ?>">
        <?php print ( $_text_castle [ $array_castle [ "id" ] ] ); ?>
      </a>
    </td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_castle [ "pledge_id" ] ); ?>">
        <?php print ( $array_castle [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td class="left">
<?php
    if ( ! empty ( $array_castle [ "alliance_id" ] ) ) {
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=4&amp;a=<?php print ( $array_castle [ "alliance_id" ] ); ?>">
        <?php print ( $array_castle [ "alliance_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
    <td class="center"><?php print ( $array_castle [ "tax_rate" ] ); ?>%</td>
    <td class="center"><?php print ( date ( "Y-m-d H:i:s", $array_castle [ "next_war_time" ] ) ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
