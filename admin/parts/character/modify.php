<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_modchar2 ( $_GET [ "u" ], $_GET [ "gender" ], $_GET [ "race" ], $_GET [ "class" ], $_GET [ "face_index" ], $_GET [ "hair_shape_index" ], $_GET [ "hair_color_index" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 91 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 92 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    $query = "select * from user_data (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
    $res = mssql_query ( $query, $link_world );
    $array_char = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    list ( $level, $percent ) = sscanf ( $_GET [ "exp" ], "%dlv %f%%" );
    if ( isset ( $_stat [ "exp" ] [ $level ] ) ) {
      if ( isset ( $_stat [ "exp" ] [ $level + 1 ] ) ) {
        if ( $percent >= 100 ) $percent = 0;
        if ( $percent < 0 ) $percent = 0;
        $exp = round ( $_stat [ "exp" ] [ $level ] + $percent * ( $_stat [ "exp" ] [ $level + 1 ] - $_stat [ "exp" ] [ $level ] ) / 100 );
      } else {
        $exp = $_stat [ "exp" ] [ $level ];
      }
    } else {
      if ( is_numeric ( $level ) ) {
        if ( $level > max ( array_keys ( $_stat [ "exp" ] ) ) ) {
          $exp = $_stat [ "exp" ] [ max ( array_keys ( $_stat [ "exp" ] ) ) ];
        } elseif ( $level < min ( array_keys ( $_stat [ "exp" ] ) ) ) {
          $exp = $_stat [ "exp" ] [ min ( array_keys ( $_stat [ "exp" ] ) ) ];
        }
      } else {
        $exp = $array_char [ "Exp" ];
      }
    }
    $ret_string = l2_modchar3 ( $_GET [ "u" ], $_GET [ "sp" ] - $array_char [ "SP" ], $exp - $array_char [ "Exp" ], $_GET [ "karma" ] - $array_char [ "align" ], $_GET [ "pk" ] - $array_char [ "PK" ], $_GET [ "pkpardon" ] - $array_char [ "PKpardon" ], $_GET [ "duel" ] - $array_char [ "Duel" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 95 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 96 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select * from user_data (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
  $res = mssql_query ( $query, $link_world );
  $array_char = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center list">
  <caption><?php print ( $_text [ 93 ] ); ?></caption>
  <tr class="naglowek">
    <th width="16%"><?php print ( $_text [ 17 ] ); ?></th>
    <th width="17%"><?php print ( $_text [ 15 ] ); ?></th>
    <th width="16%"><?php print ( $_text [ 16 ] ); ?></th>
    <th width="17%"><?php print ( $_text [ 86 ] ); ?></th>
    <th width="16%"><?php print ( $_text [ 89 ] ); ?></th>
    <th width="18%"><?php print ( $_text [ 90 ] ); ?></th>
  </tr>
  <tr class="char">
    <td>
      <select class="character" name="gender">
<?php
  foreach ( $_text_gender as $i => $val ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_char [ "gender" ] ? " selected" : "" ); ?>><?php print ( $_text_gender [ $i ] ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td>
      <select class="character" name="race">
<?php
  foreach ( $_text_race as $i => $val ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_char [ "race" ] ? " selected" : "" ); ?>><?php print ( $_text_race [ $i ] ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td>
      <select class="character" name="class">
<?php
  foreach ( $_text_class as $i => $val ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_char [ "class" ] ? " selected" : "" ); ?>><?php print ( $_text_class [ $i ] ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td>
      <select class="character" name="face_index">
<?php
  for ( $i = 0; $i < 6; $i++ ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_char [ "face_index" ] ? " selected" : "" ); ?>><?php print ( $i ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td>
      <select class="character" name="hair_shape_index">
<?php
  for ( $i = 0; $i < 6; $i++ ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_char [ "hair_shape_index" ] ? " selected" : "" ); ?>><?php print ( $i ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td>
      <select class="character" name="hair_color_index">
<?php
  for ( $i = 0; $i < 6; $i++ ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_char [ "hair_color_index" ] ? " selected" : "" ); ?>><?php print ( $i ); ?></option>
<?php
  }
?>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="6" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 88 ] ); ?>">
    </td>
  </tr>
</table>
</form>
<br />
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="2" />
<table class="center list">
  <caption><?php print ( $_text [ 94 ] ); ?></caption>
  <tr class="naglowek">
    <th width="16%"><?php print ( $_text [ 76 ] ); ?></th>
    <th width="17%"><?php print ( $_text [ 77 ] ); ?></th>
    <th width="16%"><?php print ( $_text [ 81 ] ); ?></th>
    <th width="17%"><?php print ( $_text [ 78 ] ); ?></th>
    <th width="16%"><?php print ( $_text [ 79 ] ); ?></th>
    <th width="18%"><?php print ( $_text [ 80 ] ); ?></th>
  </tr>
  <tr class="char">
    <td>
      <input class="character" name="exp" value="<?php print ( $array_char [ "Lev" ] ); ?>lv <?php
  if ( isset ( $_stat [ "exp" ] [ $array_char [ "Lev" ] ] ) ) {
    if ( isset ( $_stat [ "exp" ] [ $array_char [ "Lev" ] + 1 ] ) ) {
      print ( round ( ( $array_char [ "Exp" ] - $_stat [ "exp" ] [ $array_char [ "Lev" ] ] ) / ( $_stat [ "exp" ] [ $array_char [ "Lev" ] + 1 ] - $_stat [ "exp" ] [ $array_char [ "Lev" ] ] ) * 100, 2 ) . "%" );
    } else {
      print ( "0%" );
    }
  } else {
    print ( "---" );
  }
?>" />
    </td>
    <td>
      <input class="character" name="sp" value="<?php print ( $array_char [ "SP" ] ); ?>" />
    </td>
    <td>
      <input class="character" name="karma" value="<?php print ( $array_char [ "align" ] ); ?>" />
    </td>
    <td>
      <input class="character" name="pk" value="<?php print ( $array_char [ "PK" ] ); ?>" />
    </td>
    <td>
      <input class="character" name="pkpardon" value="<?php print ( $array_char [ "PKpardon" ] ); ?>" />
    </td>
    <td>
      <input class="character" name="duel" value="<?php print ( $array_char [ "Duel" ] ); ?>" />
    </td>
  </tr>
  <tr>
    <td colspan="6" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 97 ] ); ?>">
    </td>
  </tr>
</table>
</form>
