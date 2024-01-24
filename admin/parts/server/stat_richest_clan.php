<?php
  $query = "select top 20 p.pledge_id, p.ruler_id, p.name, p.skill_level, p.alliance_id, ud.char_id, ud.char_name, ud.account_id, ud.account_name, ud.gender, ud.race, ud.class, a.name alliance_name, sum(ui.amount) amount from pledge p (nolock) inner join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join user_item ui (nolock) on p.pledge_id=ui.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where ui.item_type=57 and ud.builder=0 and ud.account_id>0 and warehouse=2 group by p.pledge_id, p.ruler_id, p.name, p.skill_level, p.alliance_id, ud.char_id, ud.char_name, ud.account_id, ud.account_name, ud.gender, ud.race, ud.class, a.name order by amount desc";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 231 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="center" width="25%"><?php print ( $_text [ 131 ] ); ?></th>
    <th class="center" width="26%"><?php print ( $_text [ 132 ] ); ?></th>
    <th class="center" width="5%"><?php print ( $_text [ 14 ] ); ?></th>
    <th class="center" width="14%"><?php print ( $_text [ 230 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_clan = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_clan [ "pledge_id" ] ); ?></td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_clan [ "pledge_id" ] ); ?>">
        <?php print ( $array_clan [ "name" ] ); ?>
      </a>
    </td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=4&amp;a=<?php print ( $array_clan [ "alliance_id" ] ); ?>">
        <?php print ( $array_clan [ "alliance_name" ] ); ?>
      </a>
    </td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_clan [ "account_name" ] ); ?>&amp;u=<?php print ( $array_clan [ "char_id" ] ); ?>">
        <?php print ( $array_clan [ "char_name" ] ); ?>
      </a>
    </td>
    <td class="center"><?php print ( $array_clan [ "skill_level" ] ); ?></td>
    <td class="center"><?php print ( $array_clan [ "amount" ] ); ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
