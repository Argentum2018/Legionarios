<?php
  $query = "select ud.*, p.*, unc.color_rgb from user_friend uf (nolock) inner join user_data ud (nolock) on uf.friend_char_id=ud.char_id left outer join pledge p (nolock) on ud.pledge_id=p.pledge_id left outer join user_name_color unc (nolock) on ud.char_id=unc.char_id where uf.char_id=" . str_replace ( "'", "''", $_GET [ "u" ] ) . " order by friend_char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list" width="90%">
  <caption><?php print ( $_text [ 50 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
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
