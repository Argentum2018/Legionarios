<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 1 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 1 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  // logins part
  $query = "select * from user_account ua (nolock) inner join user_info ui (nolock) on ua.account=ui.account where ua.account like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' or ua.last_ip like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by ua.account";
  $res = mssql_query ( $query, $link_db );
?>
<table class="center list">
  <caption><?php print ( $_text [ 2 ] ); ?></caption>
  <tr class="naglowek">
    <th class="right" width="5%"><?php print ( $_text [ 23 ] ); ?></th>
    <th class="left" width="21%"><?php print ( $_text [ 22 ] ); ?></th>
    <th class="center" width="7%"><?php print ( $_text [ 24 ] ); ?></th>
    <th class="center" width="7%"><?php print ( $_text [ 25 ] ); ?></th>
    <th class="center" width="7%"><?php print ( $_text [ 26 ] ); ?></th>
    <th class="center" width="19%"><?php print ( $_text [ 11 ] ); ?></th>
    <th class="center" width="19%"><?php print ( $_text [ 13 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 27 ] ); ?></th>
  </tr>
<?php
  $i = 0;
  while ( $array_account = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><?php print ( $array_account [ "uid" ] ); ?></td>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=1&amp;l=<?php print ( $array_account [ "account" ] ); ?>">
        <?php print ( $array_account [ "account" ] ); ?>
      </a>
    </td>
    <td class="center"><?php print ( $array_account [ "block_flag" ] ); ?></td>
    <td class="center"><?php print ( $array_account [ "block_flag2" ] ); ?></td>
    <td class="center"><?php print ( $array_account [ "pay_stat" ] ); ?></td>
    <td class="center"><?php print ( substr ( $array_account [ "create_date" ], 0, 19 ) ); ?></td>
    <td class="center"><?php print ( substr ( $array_account [ "last_logout" ], 0, 19 ) ); ?></td>
    <td class="center"><?php print ( $array_account [ "last_ip" ] ); ?></td>
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
  // characters part
  $query = "select ud.*, p.*, unc.color_rgb from user_data ud (nolock) left outer join pledge p on ud.pledge_id=p.pledge_id left outer join user_name_color unc on ud.char_id=unc.char_id where ud.char_name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by char_name";
  $res = mssql_query ( $query, $link_world );
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
    <td class="right<?php print ( ( $array_char [ "account_id" ] > 0 && l2_checkcharacter ( $array_char [ "char_id" ] ) === "1" ) ? " online" : "" ); ?>"><?php print ( $array_char [ "char_id" ] ); ?></td>
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
}
?>
