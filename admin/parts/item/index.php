<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} elseif ( isset ( $_GET [ "c" ] ) && ! empty ( $_GET [ "c" ] ) ) {
  $query = "select p.*, ud.*, a.name alliance_name from pledge p (nolock) inner join user_data ud (nolock) on p.ruler_id=ud.char_id left outer join alliance a (nolock) on p.alliance_id=a.id where p.pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] );
  $res = mssql_query ( $query, $link_world );
  $array_clan = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<table class="center list">
  <tr class="naglowek">
    <th width="25%"><?php print ( $_text [ 18 ] ); ?></th>
    <th width="25%"><?php print ( $array_clan [ "name" ] ); ?></th>
    <th width="25%"><?php print ( $_text [ 130 ] ); ?></th>
    <th width="25%"><?php print ( $array_clan [ "pledge_id" ] ); ?></th>
  </tr>
  <tr class="clan">
    <td><?php print ( $_text [ 132 ] ); ?></td>
    <td>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_clan [ "account_name" ] ); ?>&amp;u=<?php print ( $array_clan [ "char_id" ] ); ?>">
        <?php print ( $array_clan [ "char_name" ] ); ?>
      </a>
    </td>
    <td><?php print ( $_text [ 131 ] ); ?></td>
    <td><?php print ( $array_clan [ "alliance_name" ] ); ?></td>
  </tr>
</table>
<br />
<?php
  // characters list
  $query = "select ud.*, p.*, unc.color_rgb from user_data ud (nolock) left outer join pledge p on ud.pledge_id=p.pledge_id left outer join user_name_color unc on ud.char_id=unc.char_id where p.pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] ) . " order by char_name";
  $res = mssql_query ( $query, $link_world );
  $query_c = "select count( udc.char_id ) pledge_count from user_data udc where udc.account_id>0 and udc.pledge_id=" . $array_clan [ "pledge_id" ];
  $res_c = mssql_query ( $query_c, $link_world );
  $array_clan_count_act = mssql_fetch_array ( $res_c );
  mssql_free_result ( $res_c );
  $query_c = "select count( udc.char_id ) pledge_count from user_data udc where udc.pledge_id=" . $array_clan [ "pledge_id" ];
  $res_c = mssql_query ( $query_c, $link_world );
  $array_clan_count = mssql_fetch_array ( $res_c );
  mssql_free_result ( $res_c );
?>
<table class="center list">
  <caption><?php print ( $_text [ 3 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="7%"><?php print ( $_text [ 20 ] ); ?></th>
    <th class="left" width="25%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="left" width="17%"><?php print ( $_text [ 22 ] ); ?></th>
    <th class="center" width="10%"><?php print ( $_text [ 17 ] ); ?></th>
    <th class="center" width="12%"><?php print ( $_text [ 15 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 16 ] ); ?></th>
    <th class="center" width="7%"><?php print ( $_text [ 14 ] ); ?></th>
    <th class="center" width="7%"><?php print ( $_text [ 10 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_char = mssql_fetch_array ( $res ) ) {
    if ( $array_char [ "account_id" ] < 0 ) {
?>
  <tr class="<?php print ( $array_char_status_style [ $array_char [ "account_id" ] ] ); ?>">
<?php
    } else {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
    }
?>
    <td class="right"><?php print ( $array_char [ "char_id" ] ); ?></td>
    <td class="left">
<?php
    if ( $array_char [ "color_rgb" ] <> "" ) {
?>
      <a style="color: #<?php printf ( "%02X%02X%02X", $array_char [ "color_rgb" ] & 0xff, ( $array_char [ "color_rgb" ] & 0xff00 ) >> 8, ( $array_char [ "color_rgb" ] & 0xff0000 ) >> 16 ); ?>;" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>">
        <?php print ( $array_char [ "char_name" ] ); ?>
      </a>
<?php
    } else {
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>">
        <?php print ( $array_char [ "char_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=1&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>"><?php print ( $array_char [ "account_name" ] ); ?></a></td>
    <td class="center"><?php print ( $_text_gender [ $array_char [ "gender" ] ] ); ?></td>
    <td class="center"><?php print ( $_text_race [ $array_char [ "race" ] ] ); ?></td>
    <td class="center"><?php print ( $_text_class [ $array_char [ "class" ] ] ); ?></td>
    <td class="center"><?php print ( $array_char [ "Lev" ] ); ?></td>
    <td class="center"><?php print ( $array_char [ "builder" ] ); ?></td>
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
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;c=<?php print ( $array_clan [ "pledge_id" ] ); ?>&amp;f=1"><?php print ( $_text [ 135 ] ); ?></a>
    </td>
    <td width="25%">
      &nbsp;
    </td>
    <td width="25%">
      &nbsp;
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
