<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} elseif ( isset ( $_GET [ "a" ] ) && ! empty ( $_GET [ "a" ] ) ) {
  $query = "select a.*, p.name pledge_name, p.crest_id pledge_crest_id from alliance a (nolock) inner join pledge p (nolock) on a.master_pledge_id=p.pledge_id where a.id=" . str_replace ( "'", "''", $_GET [ "a" ] );
  $res = mssql_query ( $query, $link_world );
  $array_alliance = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<table class="center list">
  <tr class="naglowek">
    <th width="25%"><?php print ( $_text [ 131 ] ); ?></th>
    <th width="25%">
<?php
      if ( ! empty ( $array_alliance [ "crest_id" ] ) ) {
?>
      <img class="crest" src="<?php print ( $directory_main . $array_pages [ -2 ] ) ?>.php?a=<?php print ( $array_alliance [ "id" ] ); ?>&amp;t=1" alt="" />
<?php
      }
?>
      <?php print ( $array_alliance [ "name" ] ); ?>
    </th>
    <th width="25%"><?php print ( $_text [ 130 ] ); ?></th>
    <th width="25%"><?php print ( $array_alliance [ "id" ] ); ?></th>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 223 ] ); ?></td>
    <td>
<?php
  if ( ! empty ( $array_alliance [ "pledge_crest_id" ] ) ) {
?>
      <img class="crest" src="<?php print ( $directory_main . $array_pages [ -2 ] ) ?>.php?c=<?php print ( $array_alliance [ "master_pledge_id" ] ); ?>&amp;t=1" alt="" />
<?php
  }
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_alliance [ "master_pledge_id" ] ); ?>">
        <?php print ( $array_alliance [ "pledge_name" ] ); ?>
      </a>
    </td>
    <td></td>
    <td></td>
  </tr>
</table>
<br />
<?php
  // pledge list
  $query = "select p.*, ud.*, a.name alliance_name from pledge p (nolock) inner join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where p.alliance_id=" . str_replace ( "'", "''", $_GET [ "a" ] ) . " order by name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 133 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 130 ] ); ?></th>
    <th class="left" width="35%"><?php print ( $_text [ 18 ] ); ?></th>
    <th class="center" width="45%"><?php print ( $_text [ 132 ] ); ?></th>
    <th class="center" width="5%"><?php print ( $_text [ 14 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 134 ] ); ?></th>
  </tr>
<?php
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
    if ( ! empty ( $array_alliance [ "pledge_crest_id" ] ) ) {
?>
      <img class="crest" src="<?php print ( $directory_main . $array_pages [ -2 ] ) ?>.php?c=<?php print ( $array_clan [ "pledge_id" ] ); ?>&amp;t=1" alt="" />
<?php
    }
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_clan [ "pledge_id" ] ); ?>">
        <?php print ( $array_clan [ "name" ] ); ?>
      </a>
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
<br /><br />
<table class="center button">
  <tr>
    <td width="25%">
    </td>
    <td width="25%">
    </td>
    <td width="25%">
    </td>
    <td width="25%">
      &nbsp;
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
