<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 221 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 221 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  $query = "select a.*, p.name pledge_name from alliance a (nolock) inner join pledge p (nolock) on a.master_pledge_id=p.pledge_id where a.name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by a.name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 222 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="45%"><?php print ( $_text [ 131 ] ); ?></th>
    <th class="center" width="40%"><?php print ( $_text [ 223 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 134 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_alliance = mssql_fetch_array ( $res ) ) {
    $query_c = "select count( pc.pledge_id ) alliance_count from pledge pc where pc.alliance_id=" . $array_alliance [ "id" ];
    $res_c = mssql_query ( $query_c, $link_world );
    $array_alliance_count = mssql_fetch_array ( $res_c );
    mssql_free_result ( $res_c );
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_alliance [ "id" ] ); ?></td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;a=<?php print ( $array_alliance [ "id" ] ); ?>">
        <?php print ( $array_alliance [ "name" ] ); ?>
      </a>
    </td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_alliance [ "master_pledge_id" ] ); ?>">
        <?php print ( $array_alliance [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td class="center"><?php print ( $array_alliance_count [ "alliance_count" ] ); ?></td>
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
