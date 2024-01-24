<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} elseif ( isset ( $_GET [ "l" ] ) && ! empty ( $_GET [ "l" ] ) ) {
  $query = "select * from user_account ua (nolock) inner join user_info ui (nolock) on ua.account=ui.account inner join user_auth uau (nolock) on ua.account=uau.account inner join ssn (nolock) on ui.ssn=ssn.ssn where ua.account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
  $res = mssql_query ( $query, $link_db );
  $array_account = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<table class="center list">
  <tr class="naglowek">
    <th width="25%"><?php print ( $_text [ 22 ] ); ?></th>
    <th width="25%"><?php print ( $array_account [ "account" ] ); ?></th>
    <th width="25%"><?php print ( $_text [ 23 ] ); ?></th>
    <th width="25%"><?php print ( $array_account [ "uid" ] ); ?></th>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 12 ] ); ?></td>
    <td><?php print ( $array_account [ "last_login" ] ); ?></td>
    <td><?php print ( $_text [ 13 ] ); ?></td>
    <td><?php print ( $array_account [ "last_logout" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 11 ] ); ?></td>
    <td><?php print ( $array_account [ "create_date" ] ); ?></td>
    <td><?php print ( $_text [ 247 ] ); ?></td>
    <td class="banned"><?php print ( $array_account [ "block_end_date" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 257 ] ); ?></td>
    <td><?php print ( $array_account [ "ssn" ] ); ?></td>
    <td><?php print ( $_text [ 262 ] ); ?></td>
    <td><?php print ( $array_account [ "status_flag" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 258 ] ); ?></td>
    <td><?php print ( $array_account [ "name" ] ); ?></td>
    <td><?php print ( $_text [ 259 ] ); ?></td>
    <td><?php print ( $array_account [ "email" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 261 ] ); ?></td>
    <td><?php print ( $array_account [ "addr_main" ] ); ?></td>
    <td><?php print ( $_text [ 260 ] ); ?></td>
    <td><?php print ( $array_account [ "phone" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 255 ] ); ?></td>
    <td><?php print ( $array_account [ "quiz1" ] ); ?></td>
    <td><?php print ( $_text [ 256 ] ); ?></td>
    <td><?php print ( $array_account [ "quiz2" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 26 ] ); ?></td>
    <td><?php print ( $array_account [ "pay_stat" ] ); ?></td>
    <td><?php print ( $_text [ 40 ] ); ?></td>
    <td><?php print ( $array_account [ "login_flag" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 24 ] ); ?></td>
    <td><?php print ( $array_account [ "block_flag" ] ); ?></td>
    <td><?php print ( $_text [ 41 ] ); ?></td>
    <td><?php print ( $array_account [ "warn_flag" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 25 ] ); ?></td>
    <td><?php print ( $array_account [ "block_flag2" ] ); ?></td>
    <td><?php print ( $_text [ 127 ] ); ?></td>
    <td><?php print ( $array_account [ "subscription_flag" ] ); ?></td>
  </tr>
  <tr class="account">
    <td><?php print ( $_text [ 27 ] ); ?></td>
    <td><?php print ( $array_account [ "last_ip" ] ); ?></td>
    <td></td>
    <td></td>
  </tr>
</table>
<br />
<?php
  // characters list
  $query = "select ud.*, p.*, unc.color_rgb from user_data ud (nolock) left outer join pledge p on ud.pledge_id=p.pledge_id left outer join user_name_color unc on ud.char_id=unc.char_id where ud.account_name='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "' order by char_name";
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
    <td class="left"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>"><?php print ( $array_char [ "account_name" ] ); ?></a></td>
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
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_account [ "account" ] ); ?>&amp;f=1"><?php print ( $_text [ 69 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_account [ "account" ] ); ?>&amp;f=2"><?php print ( $_text [ 250 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_account [ "account" ] ); ?>&amp;f=3"><?php print ( $_text [ 267 ] ); ?></a>
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
