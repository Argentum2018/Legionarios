<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 137 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 137 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  $query = "select ui.*, ud.*, i.* from user_item ui (nolock) left outer join ( select char_id, char_name, account_id, 0 as is_pledge from user_data (nolock) union all select pledge_id, name, 0, 1 from pledge (nolock) ) ud on ui.char_id=ud.char_id and round(ui.warehouse/2,0,1)=ud.is_pledge left outer join itemdata i (nolock) on ui.item_type=i.id where ui.item_id like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by i.name, ud.char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 139 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="10%"><?php print ( $_text [ 99 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 100 ] ); ?></th>
    <th class="left" width="20%"><?php print ( $_text [ 8 ] ); ?></th>
    <th class="left" width="36%"><?php print ( $_text [ 101 ] ); ?></th>
    <th class="right" width="12%"><?php print ( $_text [ 102 ] ); ?></th>
    <th class="right" width="7%"><?php print ( $_text [ 103 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_item = mssql_fetch_array ( $res ) ) {
    if ( $array_item [ "account_id" ] < 0 ) {
?>
  <tr class="<?php print ( $array_char_status_style [ $array_item [ "account_id" ] ] ); ?>">
<?php
    } else {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
    }
?>
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=101&amp;item_id=<?php print ( $array_item [ "item_id" ] ); ?>"><?php print ( $array_item [ "item_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_item [ "item_type" ] ); ?></td>
<?php
    if ( $array_item [ "is_pledge" ] ) {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_item [ "char_id" ] ); ?>">
        <?php print ( $array_item [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    } else {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;u=<?php print ( $array_item [ "char_id" ] ); ?>">
        <?php print ( $array_item [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    }
?>
    <td class="left"><?php print ( $array_item [ "name" ] ); ?></th>
    <td class="right"><?php print ( number_format ( $array_item [ "amount" ], 0, ".", " " ) ); ?></td>
    <td class="right"><?php print ( $array_item [ "enchant" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;o=2&amp;item_id=<?php print ( $array_item [ "item_id" ] ); ?>&amp;amount=<?php print ( $array_item [ "amount" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
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
  $query = "select ui.*, ud.*, i.* from user_item ui (nolock) left outer join ( select char_id, char_name, account_id, 0 as is_pledge from user_data (nolock) union all select pledge_id, name, 0, 1 from pledge (nolock) ) ud on ui.char_id=ud.char_id and round(ui.warehouse/2,0,1)=ud.is_pledge left outer join itemdata i (nolock) on ui.item_type=i.id where ui.item_type like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' or i.name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by i.name, ud.char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 138 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="10%"><?php print ( $_text [ 99 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 100 ] ); ?></th>
    <th class="left" width="20%"><?php print ( $_text [ 8 ] ); ?></th>
    <th class="left" width="36%"><?php print ( $_text [ 101 ] ); ?></th>
    <th class="right" width="12%"><?php print ( $_text [ 102 ] ); ?></th>
    <th class="right" width="7%"><?php print ( $_text [ 103 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_item = mssql_fetch_array ( $res ) ) {
    if ( $array_item [ "account_id" ] < 0 ) {
?>
  <tr class="<?php print ( $array_char_status_style [ $array_item [ "account_id" ] ] ); ?>">
<?php
    } else {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
    }
?>
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=101&amp;item_id=<?php print ( $array_item [ "item_id" ] ); ?>"><?php print ( $array_item [ "item_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_item [ "item_type" ] ); ?></td>
<?php
    if ( $array_item [ "is_pledge" ] ) {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_item [ "char_id" ] ); ?>">
        <?php print ( $array_item [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    } else {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;u=<?php print ( $array_item [ "char_id" ] ); ?>">
        <?php print ( $array_item [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    }
?>
    <td class="left"><?php print ( $array_item [ "name" ] ); ?></td>
    <td class="right"><?php print ( number_format ( $array_item [ "amount" ], 0, ".", " " ) ); ?></td>
    <td class="right"><?php print ( $array_item [ "enchant" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;o=2&amp;item_id=<?php print ( $array_item [ "item_id" ] ); ?>&amp;amount=<?php print ( $array_item [ "amount" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
}
?>
