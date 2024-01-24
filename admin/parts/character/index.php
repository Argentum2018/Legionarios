<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} elseif ( isset ( $_GET [ "u" ] ) && ! empty ( $_GET [ "u" ] ) ) {
  // character info
  $query = "select ud.*, ud.nickname collate polish_ci_as as nickname, p.*, unc.color_rgb from user_data ud (nolock) left outer join pledge p on ud.pledge_id=p.pledge_id left outer join user_name_color unc on ud.char_id=unc.char_id where ud.char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
  $res = mssql_query ( $query, $link_world );
  $array_char = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
  $query = "select ub.* from user_ban ub (nolock) where ub.char_id=" . $array_char [ "char_id" ];
  $res = mssql_query ( $query, $link_world );
  $array_char_ban = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
  $query = "select up.* from user_punish up (nolock) where up.char_id=" . $array_char [ "char_id" ];
  $res = mssql_query ( $query, $link_world );
  $array_char_punish = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<table class="center list">
  <tr class="naglowek">
<?php
  if ( l2_checkcharacter ( $_GET [ "u" ] ) === "1" ) {
?>
    <th class="online" width="25%"><?php print ( $_text [ 5 ] ); ?></th>
<?php
  } else {
?>
    <th class="offline" width="25%"><?php print ( $_text [ 6 ] ); ?></th>
<?php
  }
?>
    <th width="25%">&nbsp;</th>
    <th width="25%">&nbsp;</th>
    <th width="25%"<?php print ( $array_char [ "account_id" ] < 0 ? " class=\"" . ( $array_char [ "account_id" ] == -1 ? "deleted" : "stopped" ) . "\"" : "" ); ?>><?php print ( $_text_char_status [ $array_char [ "account_id" ] < 0 ? $array_char [ "account_id" ] : 0 ] ); ?></th>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 8 ] ); ?></td>
    <td><?php print ( $array_char [ "char_name" ] ); ?></td>
    <td><?php print ( $_text [ 7 ] ); ?></th>
    <td><?php print ( $array_char [ "char_id" ] ); ?></th>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 9 ] ); ?></td>
    <td><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=1&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>"><?php print ( $array_char [ "account_name" ] ); ?></a></td>
    <td><?php print ( $_text [ 14 ] ); ?></td>
    <td><?php print ( $array_char [ "Lev" ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 10 ] ); ?></td>
    <td><?php print ( $array_char [ "builder" ] ); ?></td>
    <td><?php print ( $_text [ 15 ] ); ?></td>
    <td><?php print ( $_text_race [ $array_char [ "race" ] ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 83 ] ); ?></td>
<?php
  if ( isset ( $array_char [ "color_rgb" ] ) ) {
?>
    <td>
      <span style="color: #<?php printf ( "%02X%02X%02X", $array_char [ "color_rgb" ] & 0xff, ( $array_char [ "color_rgb" ] & 0xff00 ) >> 8, ( $array_char [ "color_rgb" ] & 0xff0000 ) >> 16 ); ?>;">#<?php printf ( "%02X%02X%02X", $array_char [ "color_rgb" ] & 0xff, ( $array_char [ "color_rgb" ] & 0xff00 ) >> 8, ( $array_char [ "color_rgb" ] & 0xff0000 ) >> 16 ); ?></span>
    </td>
<?php
  } else {
?>
    <td><?php print ( $_text [ 85 ] ); ?></td>
<?php
  }
?>
    <td><?php print ( $_text [ 16 ] ); ?></td>
    <td><?php print ( $_text_class [ $array_char [ "class" ] ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 11 ] ); ?></td>
    <td><?php print ( $array_char [ "create_date" ] ); ?></td>
    <td><?php print ( $_text [ 17 ] ); ?></td>
    <td><?php print ( $_text_gender [ $array_char [ "gender" ] ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 12 ] ); ?></td>
    <td><?php print ( $array_char [ "login" ] ); ?></td>
    <td><?php print ( $_text [ 18 ] ); ?></td>
    <td>
<?php
  if ( ! empty ( $array_char [ "crest_id" ] ) ) {
?>
      <img class="crest" src="<?php print ( $directory_main . $array_pages [ -2 ] ) ?>.php?c=<?php print ( $array_char [ "pledge_id" ] ); ?>&amp;t=1" alt="" />
<?php
  }
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_char [ "pledge_id" ] ); ?>"><?php print ( $array_char [ "name" ] ); ?></a>
    </td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 13 ] ); ?></td>
    <td><?php print ( $array_char [ "logout" ] ); ?></td>
    <td><?php print ( $_text [ 19 ] ); ?></td>
    <td><?php print ( $array_char [ "nickname" ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 71 ] ); ?></td>
    <td><?php print ( $array_char [ "temp_delete_date" ] ); ?></td>
    <td><?php print ( $_text [ 70 ] ); ?></td>
    <td><?php print ( $array_char [ "xloc" ] ); ?>, <?php print ( $array_char [ "yloc" ] ); ?>, <?php print ( $array_char [ "zloc" ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 74 ] ); ?></td>
    <td><?php print ( floor ( $array_char [ "cp" ] ) ); ?> / <?php print ( floor ( $array_char [ "max_cp" ] ) ); ?></td>
    <td><?php print ( $_text [ 75 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "use_time" ], 0, ".", " " ) ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 72 ] ); ?></td>
    <td><?php print ( floor ( $array_char [ "HP" ] ) ); ?> / <?php print ( floor ( $array_char [ "max_hp" ] ) ); ?></td>
    <td><?php print ( $_text [ 76 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "Exp" ], 0, ".", " " ) ); ?> [
<?php
  if ( isset ( $_stat [ "exp" ] [ $array_char [ "Lev" ] ] ) ) {
    if ( isset ( $_stat [ "exp" ] [ $array_char [ "Lev" ] + 1 ] ) ) {
      print ( round ( ( $array_char [ "Exp" ] - $_stat [ "exp" ] [ $array_char [ "Lev" ] ] ) / ( $_stat [ "exp" ] [ $array_char [ "Lev" ] + 1 ] - $_stat [ "exp" ] [ $array_char [ "Lev" ] ] ) * 100, 2 ) );
    } else {
      print ( 0 );
    }
  } else {
    print ( "---" );
  }
?>% ]
    </td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 73 ] ); ?></td>
    <td><?php print ( floor ( $array_char [ "MP" ] ) ); ?> / <?php print ( floor ( $array_char [ "max_mp" ] ) ); ?></td>
    <td><?php print ( $_text [ 77 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "SP" ], 0, ".", " " ) ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 81 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "align" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 201 ] . "0" ); ?></td>
    <td><?php print ( $array_char [ "subjob0_class" ] != -1 ? $_text_class [ $array_char [ "subjob0_class" ] ] : $_text [ 220 ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 80 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "Duel" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 201 ] . "1" ); ?></td>
    <td><?php print ( $array_char [ "subjob1_class" ] != -1 ? $_text_class [ $array_char [ "subjob1_class" ] ] : $_text [ 220 ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 78 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "PK" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 201 ] . "2" ); ?></td>
    <td><?php print ( $array_char [ "subjob2_class" ] != -1 ? $_text_class [ $array_char [ "subjob2_class" ] ] : $_text [ 220 ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 79 ] ); ?></td>
    <td><?php print ( number_format ( $array_char [ "PKpardon" ], 0, ".", " " ) ); ?></td>
    <td><?php print ( $_text [ 201 ] . "3" ); ?></td>
    <td><?php print ( $array_char [ "subjob3_class" ] != -1 ? $_text_class [ $array_char [ "subjob3_class" ] ] : $_text [ 220 ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 158 ] ); ?></td>
<?php
  if ( isset ( $array_char_ban [ "ban_hour" ] ) && ! empty ( $array_char_ban [ "ban_hour" ] ) ) {
?>
    <td class="banned"><?php print ( $array_char_ban [ "ban_hour" ] ); ?> / <?php print ( date ( "Y-m-d H:i:s", $array_char_ban [ "ban_end" ] ) ); ?></td>
<?php
  } else {
?>
    <td></td>
<?php
  }
?>
    <td><?php print ( $_text [ 86 ] ); ?></td>
    <td><?php print ( $array_char [ "face_index" ] ); ?></td>
  </tr>
  <tr class="char">
    <td><?php print ( $_text [ 159 ] ); ?></td>
    <td class="banned"><?php print ( $array_char_punish [ "remain_game" ] ? $array_char_punish [ "remain_game" ] / 1000 : "" ); ?></td>
    <td><?php print ( $_text [ 87 ] ); ?></td>
    <td><?php print ( $array_char [ "hair_shape_index" ] ); ?> / <?php print ( $array_char [ "hair_color_index" ] ); ?></td>
  </tr>
</table>
<br /><br />
<table class="center button">
  <tr>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=1"><?php print ( $_text [ 42 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=2"><?php print ( $_text [ 43 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=3"><?php print ( $_text [ 82 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=4"><?php print ( $_text [ 384 ] ); ?></a>
    </td>
  </tr>
  <tr>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=5"><?php print ( $_text [ 174 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=6"><?php print ( $_text [ 44 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=7"><?php print ( $_text [ 45 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=8"><?php print ( $_text [ 84 ] ); ?></a>
    </td>
  </tr>
  <tr>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=9"><?php print ( $_text [ 235 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=10"><?php print ( $_text [ 46 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=11"><?php print ( $_text [ 47 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=12"><?php print ( $_text [ 49 ] ); ?></a>
    </td>
  </tr>
  <tr>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=13"><?php print ( $_text [ 48 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=14"><?php print ( $_text [ 54 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=15"><?php print ( $_text [ 50 ] ); ?></a>
    </td>
    <td>
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=16"><?php print ( $_text [ 51 ] ); ?></a>
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
