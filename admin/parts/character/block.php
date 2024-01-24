<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_enablecharacter ( $_GET [ "u" ], $_GET [ "account_id" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 30 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 31 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    $ret_string = l2_disablecharacter ( $_GET [ "u" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 32 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 33 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 3 ) {
    $ret_string = l2_restorecharacter ( $_GET [ "u" ], $_GET [ "account_id" ], $_GET [ "char_name" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 142 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 143 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 4 ) {
    $ret_string = l2_deletecharacter ( $_GET [ "u" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 144 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 145 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 5 ) {
    $ret_string = l2_bancharacter ( $_GET [ "u" ], $_GET [ "block_time" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_GET [ "block_time" ] ? $_text [ 150 ] : $_text [ 30 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_GET [ "block_time" ] ? $_text [ 151 ] : $_text [ 31 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 6 ) {
    $ret_string = l2_punishchar ( $_GET [ "u" ], $_GET [ "block_time" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_GET [ "block_time" ] ? $_text [ 153 ] : $_text [ 155 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_GET [ "block_time" ] ? $_text [ 154 ] : $_text [ 156 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select * from user_account (nolock) where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
  $res = mssql_query ( $query, $link_db );
  $array_account = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
  $query = "select * from user_data (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
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
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="0" />
<table class="center" width="50%">
<?php
  if ( isset ( $array_char_ban [ "ban_hour" ] ) && ! empty ( $array_char_ban [ "ban_hour" ] ) ) {
?>
  <tr>
    <td class="center"><?php print ( $_text [ 160 ] ); ?></td>
    <td class="center banned"><?php print ( $array_char_ban [ "ban_hour" ] ); ?></td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 161 ] ); ?></td>
    <td class="center banned"><?php print ( $array_char_ban [ "ban_date" ] ); ?></td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 162 ] ); ?></td>
    <td class="center banned"><?php print ( date ( "Y-m-d H:i:s", $array_char_ban [ "ban_end" ] ) ); ?></td>
  </tr>
  <tr><td colspan="2" height="8"></td></tr>
<?php
  }
  if ( isset ( $array_char_punish [ "remain_game" ] ) && ! empty ( $array_char_punish [ "remain_game" ] ) ) {
?>
  <tr>
    <td class="center"><?php print ( $_text [ 163 ] ); ?></td>
    <td class="center banned"><?php print ( $array_char_punish [ "remain_game" ] / 1000 ); ?></td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 164 ] ); ?></td>
    <td class="center banned"><?php print ( $array_char_punish [ "punish_date" ] ); ?></td>
  </tr>
  <tr><td colspan="2" height="8"></td></tr>
<?php
  }
  if ( $array_char [ "account_id" ] == -2 ) {
?>
  <tr>
    <td colspan="2" class="center">
      <input type="button" class="odblokuj" onclick="location.href='<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=1&amp;account_id=<?php print ( $array_account [ "uid" ] ); ?>'" value="<?php print ( $_text [ 34 ] ); ?>">
    </td>
  </tr>
<?php
  } elseif ( $array_char [ "account_id" ] == -1 ) {
?>
  <tr>
    <td colspan="2" class="center">
      <input type="button" class="odblokuj" onclick="location.href='<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=3&amp;account_id=<?php print ( $array_account [ "uid" ] ); ?>&amp;char_name=<?php print ( substr ( $array_char [ "char_name" ], 0, strpos ( $array_char [ "char_name" ], "_" ) ) ); ?>'" value="<?php print ( $_text [ 140 ] ); ?>">
    </td>
  </tr>
<?php
  } elseif ( $array_char [ "account_id" ] > 0 ) {
?>
  <tr>
    <td colspan="2" class="center">
      <input type="button" class="blokuj" onclick="location.href='<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=4&amp;account_id=<?php print ( $array_account [ "uid" ] ); ?>'" value="<?php print ( $_text [ 141 ] ); ?>">
    </td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center">
      <input type="button" class="blokuj" onclick="location.href='<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_char [ "account_name" ] ); ?>&amp;u=<?php print ( $array_char [ "char_id" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=2&amp;account_id=<?php print ( $array_account [ "uid" ] ); ?>'" value="<?php print ( $_text [ 35 ] ); ?>">
    </td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td class="center v-center" width="50%" rowspan="3">
      <input name="block_time" type="text">
    </td>
    <td class="center" width="50%">
      <input type="submit" class="button" onclick="this.form.o.value='5';return true;" value="<?php print ( $_text [ 36 ] ); ?>">
    </td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td class="center" width="50%">
      <input type="submit" class="button" onclick="this.form.o.value='6';return true;" value="<?php print ( $_text [ 152 ] ); ?>">
    </td>
  </tr>
  <tr><td colspan="2" height="8"></td></tr>
  <tr>
    <td class="center" colspan="2">
      <?php print ( $_text [ 157 ] ); ?>
    </td>
  </tr>
<?php
  }
?>
</table>
</form>
