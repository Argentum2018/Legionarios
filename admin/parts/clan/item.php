<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_additem2 ( $_GET [ "c" ], 2, $_GET [ "item_type" ], $_GET [ "amount" ], 0, 0, 0, 0, 0 );
    if ( $ret_string === "1" ) {
      $_SESSION [ "info" ] = $_text [ 175 ];
    } else {
      $_SESSION [ "info" ] = $_text [ 176 ] . "<strong>" . $ret_string . "</strong>";
    }
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 && isset ( $_GET [ "id" ] ) ) {
    if ( isset ( $_GET [ "o2" ] ) && $_GET [ "o2" ] == 1 ) {
      $query = "select * from user_data (nolock) where char_name='" . str_replace ( "'", "''", $_GET [ "new_char_name" ] ) . "'";
      $res = mssql_query ( $query, $link_world );
      $array_char = mssql_fetch_array ( $res );
      mssql_free_result ( $res );
      $_SESSION [ "info" ] = "";
      if ( $array_char ) {
        $new_char_id = $array_char [ "char_id" ];
        foreach ( $_GET [ "amount" ] as $item_id => $amount ) {
          $ret_string = l2_moveitem2 ( $_GET [ "c" ], $item_id, $new_char_id, str_replace ( " ", "", $amount ), 0 );
          if ( $ret_string === "1" ) {
            $_SESSION [ "info" ] .= sprintf ( $_text [ 305 ], $item_id ) . "<br />";
          } else {
            $_SESSION [ "info" ] .= sprintf ( $_text [ 306 ], $item_id ) . "<strong>" . $ret_string . "</strong><br />";
          }
        }
        $error_new_char = false;
      } else {
        $error_new_char = true;
      }
    } else {
      $_SESSION [ "referer" ] = $_SERVER [ "HTTP_REFERER" ];
    }
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 3 && isset ( $_GET [ "id" ] ) ) {
    if ( isset ( $_GET [ "o2" ] ) && $_GET [ "o2" ] == 1 ) {
      $_SESSION [ "info" ] = "";
      foreach ( $_GET [ "amount" ] as $item_id => $amount ) {
        $ret_string = l2_delitem2 ( $item_id, str_replace ( " ", "", $amount ) );
        if ( $ret_string === "1" ) {
          $_SESSION [ "info" ] .= sprintf ( $_text [ 177 ], $item_id ) . "<br />";
        } else {
          $_SESSION [ "info" ] .= sprintf ( $_text [ 178 ], $item_id ) . "<strong>" . $ret_string . "</strong><br />";
        }
      }
    } else {
      $_SESSION [ "referer" ] = $_SERVER [ "HTTP_REFERER" ];
    }
  }
  if ( isset ( $_SESSION [ "info" ] ) && ! empty ( $_SESSION [ "info" ] ) ) {
    if ( ! isset ( $_GET [ "o" ] ) ) {
  ?>
<div class="center">
  <?php print ( $_SESSION [ "info" ] ); ?>
</div>
<br />
<?php
      unset ( $_SESSION [ "info" ] );
    }
  }
  if ( isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) && ! isset ( $_GET [ "id" ] ) ) {
    unset ( $_GET [ "o" ] );
  }
  if ( ! ( isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) ) ) {
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="c" type="hidden" value="<?php print ( $_GET [ "c" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="1">
<input name="ref" type="hidden" value="1">
<table class="center" width="50%">
  <tr class="naglowek">
    <th class="center" width="50%"><label for="item_type"><?php print ( $_text [ 195 ] ); ?></label></th>
    <th class="center" width="50%"><label for="name"><?php print ( $_text [ 196 ] ); ?></label></th>
  </tr>
  <tr>
    <td class="center"><input id="item_type" name="item_type" type="text" class="center" /></td>
    <th class="center"><input id="amount" name="amount" type="text" class="center" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 197 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<?php
  }
  if ( isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) ) {
    $query = "select * from user_item (nolock) left outer join itemdata (nolock) on item_type=id where warehouse=2 and char_id=" . str_replace ( "'", "''", $_GET [ "c" ] ) . " and item_id in ( " . implode ( ", ", $_GET [ "id" ] ) . " ) order by name";
  } else {
    $query = "select * from user_item (nolock) left outer join itemdata (nolock) on item_type=id where warehouse=2 and char_id=" . str_replace ( "'", "''", $_GET [ "c" ] ) . " order by name";
  }
  $res = mssql_query ( $query, $link_world );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="c" type="hidden" value="<?php print ( $_GET [ "c" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="0">
<?php
  if ( ! isset ( $_GET [ "o" ] ) || isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) ) {
    if ( isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) ) {
?>
<input name="o2" type="hidden" value="1">
<input name="ref" type="hidden" value="1">
<?php
    }
    if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
?>
<table class="center" width="50%">
<?php
      if ( isset ( $error_new_char ) && $error_new_char ) {
?>
  <tr>
    <td colspan="2" class="center"><span class="error"><?php print ( $_text [ 307 ] ); ?></span></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
<?php
      }
?>
  <tr>
    <td class="center label" width="50%"><label for="new_char_name"><?php print ( $_text [ 304 ] ); ?></label></td>
    <td class="center" width="50%"><input id="new_char_name" name="new_char_name" type="text" class="center" value="<?php print ( isset ( $_GET [ "new_char_name" ] ) ? $_GET [ "new_char_name" ] : "" ); ?>" /></td>
  </tr>
</table>
<?php
    }
?>
<table class="center" width="50%">
  <tr>
<?php
    if ( ! isset ( $_GET [ "o" ] ) || isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
?>
    <td class="center" width="50%"><input class="accept" type="submit" value="<?php print ( $_text [ 302 ] ); ?>" onclick="this.form.o.value=2" /></td>
<?php
    }
    if ( ! isset ( $_GET [ "o" ] ) || isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 3 ) {
?>
    <td class="center" width="50%"><input class="accept" type="submit" value="<?php print ( $_text [ 303 ] ); ?>" onclick="this.form.o.value=3" /></td>
<?php
    }
?>
  </tr>
</table>
<br />
<?php
  }
?>
<br />
<table class="center list" width="80%">
  <caption><?php print ( $_text [ 136 ] ); ?> [<?php print ( mssql_num_rows ( $res ) ); ?>]</caption>
  <tr class="naglowek">
    <th class="right" width="10%"><?php print ( $_text [ 99 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 100 ] ); ?></th>
    <th class="left" width="56%"><?php print ( $_text [ 101 ] ); ?></th>
    <th class="right" width="15%"><?php print ( $_text [ 102 ] ); ?></th>
    <th class="right" width="7%"><?php print ( $_text [ 103 ] ); ?></th>
    <th class="center" width="4%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_item = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=5&amp;u=<?php print ( $_GET [ "c" ] ); ?>&amp;f=101&amp;item_id=<?php print ( $array_item [ "item_id" ] ); ?>"><?php print ( $array_item [ "item_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_item [ "item_type" ] ); ?></td>
    <th class="left"><?php print ( $array_item [ "name" ] ); ?></th>
<?php
    if ( isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) ) {
?>
    <td class="center"><input name="amount[<?php print ( $array_item [ "item_id" ] ); ?>]" type="text" class="item" value="<?php print ( number_format ( $array_item [ "amount" ], 0, ".", " " ) ); ?>" /></td>
<?php
    } else {
?>
    <td class="right"><?php print ( number_format ( $array_item [ "amount" ], 0, ".", " " ) ); ?></td>
<?php
    }
?>
    <td class="right"><?php print ( $array_item [ "enchant" ] ); ?></td>
    <td class="center"><input class="list-checkbox" name="id[]" type="checkbox" value="<?php print ( $array_item [ "item_id" ] ); ?>"<?php print ( isset ( $_GET [ "o" ] ) && ( $_GET [ "o" ] == 2 || $_GET [ "o" ] == 3 ) ? " checked" : "" ); ?>></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
?>
