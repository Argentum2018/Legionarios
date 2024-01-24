<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_moditem ( $_GET [ "u" ], $_GET [ "warehouse" ], $_GET [ "item_id" ], $_GET [ "item_type" ], $_GET [ "amount" ], $_GET [ "enchant" ], $_GET [ "eroded" ], $_GET [ "bless" ], $_GET [ "ident" ], $_GET [ "wished" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 111 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 112 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
  }
  $query = "select * from user_item (nolock) left outer join itemdata on item_type=id where item_id=" . str_replace ( "'", "''", $_GET [ "item_id" ] );
  $res = mssql_query ( $query, $link_world );
  $array_item = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="item_id" type="hidden" value="<?php print ( $_GET [ "item_id" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<input name="warehouse" type="hidden" value="<?php print ( $array_item [ "warehouse" ] ); ?>" />
<table class="center list">
  <caption><?php print ( $_text [ 113 ] ); ?></caption>
  <tr class="naglowek">
    <th width="12%"><?php print ( $_text [ 100 ] ); ?></th>
    <th width="13%"><?php print ( $_text [ 102 ] ); ?></th>
    <th width="12%"><?php print ( $_text [ 103 ] ); ?></th>
    <th width="13%"><?php print ( $_text [ 106 ] ); ?></th>
    <th width="12%"><?php print ( $_text [ 107 ] ); ?></th>
    <th width="13%"><?php print ( $_text [ 108 ] ); ?></th>
    <th width="12%"><?php print ( $_text [ 109 ] ); ?></th>
    <th width="13%"><?php print ( $_text [ 104 ] ); ?></th>
  </tr>
  <tr class="char">
    <td>
      <input class="item" name="item_type" value="<?php print ( $array_item [ "item_type" ] ); ?>" />
    </td>
    <td>
      <input class="item" name="amount" value="<?php print ( $array_item [ "amount" ] ); ?>" />
    </td>
    <td>
      <input class="item" name="enchant" value="<?php print ( $array_item [ "enchant" ] ); ?>" />
    </td>
    <td>
      <input class="item" name="eroded" value="<?php print ( $array_item [ "eroded" ] ); ?>" />
    </td>
    <td>
      <select class="item" name="bless">
<?php
  foreach ( $_text_bless as $i => $val ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_item [ "bless" ] ? " selected" : "" ); ?>><?php print ( $_text_bless [ $i ] ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td>
      <input class="item" name="ident" value="<?php print ( $array_item [ "ident" ] ); ?>" />
    </td>
    <td>
      <select class="item" name="wished">
<?php
  foreach ( $_text_yesno as $i => $val ) {
?>
        <option value="<?php print ( $i ); ?>"<?php print ( $i == $array_item [ "wished" ] ? " selected" : "" ); ?>><?php print ( $_text_yesno [ $i ] ); ?></option>
<?php
  }
?>
      </select>
    </td>
    <td><?php print ( $_text_warehouse [ $array_item [ "warehouse" ] ] ); ?></td>
  </tr>
  <tr>
    <td colspan="10" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 110 ] ); ?>">
    </td>
  </tr>
</table>
</form>
