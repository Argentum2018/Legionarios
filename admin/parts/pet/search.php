<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 224 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 224 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  $query = "select pd.*, ui.*, ud.* from pet_data pd (nolock) inner join user_item ui (nolock) on pd.pet_id=ui.item_id left outer join ( select char_id, char_name, 0 as is_pledge from user_data (nolock) union all select pledge_id, name, 1 from pledge (nolock) ) ud on ui.char_id=ud.char_id and round(ui.warehouse/2,0,1)=ud.is_pledge where ui.item_id like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by pd.nick_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 227 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="10%"><?php print ( $_text [ 225 ] ); ?></th>
    <th class="left" width="18%"><?php print ( $_text [ 100 ] ); ?></th>
    <th class="left" width="33%"><?php print ( $_text [ 226 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="right" width="7%"><?php print ( $_text [ 14 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_pet = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=101&amp;pt=<?php print ( $array_pet [ "item_id" ] ); ?>"><?php print ( $array_pet [ "pet_id" ] ); ?></a></td>
    <td class="left"><?php print ( $_text_pet [ $array_pet [ "item_type" ] ] ); ?></td>
    <td class="left"><?php print ( $array_pet [ "nick_name" ] ); ?></td>
<?php
    if ( $array_pet [ "is_pledge" ] ) {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_pet [ "char_id" ] ); ?>">
        <?php print ( $array_pet [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    } else {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;u=<?php print ( $array_pet [ "char_id" ] ); ?>">
        <?php print ( $array_pet [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    }
?>
    <td class="right"><?php print ( $array_pet [ "enchant" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;o=2&amp;pt=<?php print ( $array_pet [ "pet_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
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
  $query = "select pd.*, ui.*, ud.* from pet_data pd (nolock) inner join user_item ui (nolock) on pd.pet_id=ui.item_id left outer join ( select char_id, char_name, 0 as is_pledge from user_data (nolock) union all select pledge_id, name, 1 from pledge (nolock) ) ud on ui.char_id=ud.char_id and round(ui.warehouse/2,0,1)=ud.is_pledge where ui.item_type like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' or pd.nick_name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by pd.nick_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 228 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="10%"><?php print ( $_text [ 225 ] ); ?></th>
    <th class="left" width="18%"><?php print ( $_text [ 100 ] ); ?></th>
    <th class="left" width="33%"><?php print ( $_text [ 226 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="right" width="7%"><?php print ( $_text [ 14 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_pet = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=101&amp;pt=<?php print ( $array_pet [ "item_id" ] ); ?>"><?php print ( $array_pet [ "pet_id" ] ); ?></a></td>
    <td class="left"><?php print ( $_text_pet [ $array_pet [ "item_type" ] ] ); ?></td>
    <td class="left"><?php print ( $array_pet [ "nick_name" ] ); ?></td>
<?php
    if ( $array_pet [ "is_pledge" ] ) {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_pet [ "char_id" ] ); ?>">
        <?php print ( $array_pet [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    } else {
?>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;u=<?php print ( $array_pet [ "char_id" ] ); ?>">
        <?php print ( $array_pet [ "char_name" ] ); ?>
      </a>
    </td>
<?php
    }
?>
    <td class="right"><?php print ( $array_pet [ "enchant" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;o=2&amp;pt=<?php print ( $array_pet [ "pet_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
}
?>
