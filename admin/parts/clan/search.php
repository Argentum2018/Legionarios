<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 129 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 129 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  $query = "select p.*, ud.*, a.name alliance_name, a.crest_id alliance_crest_id from pledge p (nolock) inner join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where p.name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by p.name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 133 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="center" width="25%"><?php print ( $_text [ 131 ] ); ?></th>
    <th class="center" width="30%"><?php print ( $_text [ 132 ] ); ?></th>
    <th class="center" width="5%"><?php print ( $_text [ 14 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 134 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_clan = mssql_fetch_array ( $res ) ) {
    $query_c = "select count( udc.char_id ) pledge_count from user_data udc where udc.account_id>0 and udc.pledge_id=" . $array_clan [ "pledge_id" ];
    $res_c = mssql_query ( $query_c, $link_world );
    $array_clan_count_act = mssql_fetch_array ( $res_c );
    mssql_free_result ( $res_c );
    $query_c = "select count( udc.char_id ) pledge_count from user_data udc where udc.pledge_id=" . $array_clan [ "pledge_id" ];
    $res_c = mssql_query ( $query_c, $link_world );
    $array_clan_count = mssql_fetch_array ( $res_c );
    mssql_free_result ( $res_c );
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_clan [ "pledge_id" ] ); ?></td>
    <td class="left">
<?php
    if ( ! empty ( $array_clan [ "crest_id" ] ) ) {
?>
      <img class="crest" src="<?php print ( $directory_main . $array_pages [ -2 ] ) ?>.php?c=<?php print ( $array_clan [ "pledge_id" ] ); ?>&amp;t=1" alt="" />
<?php
    }
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;c=<?php print ( $array_clan [ "pledge_id" ] ); ?>">
        <?php print ( $array_clan [ "name" ] ); ?>
      </a>
    </td>
    <td class="left">
<?php
    if ( ! empty ( $array_clan [ "alliance_id" ] ) ) {
      if ( ! empty ( $array_clan [ "alliance_crest_id" ] ) ) {
?>
      <img class="crest" src="<?php print ( $directory_main . $array_pages [ -2 ] ) ?>.php?a=<?php print ( $array_clan [ "alliance_id" ] ); ?>&amp;t=1" alt="" />
<?php
      }
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=4&amp;a=<?php print ( $array_clan [ "alliance_id" ] ); ?>">
        <?php print ( $array_clan [ "alliance_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_clan [ "account_name" ] ); ?>&amp;u=<?php print ( $array_clan [ "char_id" ] ); ?>">
        <?php print ( $array_clan [ "char_name" ] ); ?>
      </a>
    </td>
    <td class="center"><?php print ( $array_clan [ "skill_level" ] ); ?></td>
    <td class="center"><?php print ( $array_clan_count_act [ "pledge_count" ] ); ?>/<?php print ( $array_clan_count [ "pledge_count" ] ); ?></td>
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
}
?>
