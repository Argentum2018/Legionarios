<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $ret_string = l2_addquest ( $_GET [ "u" ], $_GET [ "quest_id" ], $_GET [ "progress" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 179 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 180 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    $ret_string = l2_delquest ( $_GET [ "u" ], $_GET [ "quest_id" ] );
?>
<div class="center">
<?php
    if ( $ret_string === "1" ) {
?>
  <?php print ( $_text [ 181 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 182 ] ); ?><strong><?php print ( $ret_string ); ?></strong>
<?php
    }
?>
</div>
<br />
<?php
  }
  $query = "select * from quest (nolock) where char_id=" . str_replace ( "'", "''", $_GET [ "u" ] );
  $res = mssql_query ( $query, $link_world );
  $array_quest = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>">
<input name="u" type="hidden" value="<?php print ( $_GET [ "u" ] ); ?>">
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>">
<input name="o" type="hidden" value="1">
<table class="center" width="50%">
  <tr class="naglowek">
    <th class="center" width="50%"><?php print ( $_text [ 274 ] ); ?></th>
    <th class="center" width="50%"><?php print ( $_text [ 275 ] ); ?></th>
  </tr>
  <tr>
    <td class="center"><input name="quest_id" type="text" class="center"></td>
    <td class="center"><input name="progress" type="text" class="center"></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 286 ] ); ?>"></td>
  </tr>
</table>
</form>
<br />
<table class="center list" width="80%">
  <caption><?php print ( $_text [ 48 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 274 ] ); ?></th>
    <th class="left" width="75%"><?php print ( $_text [ 287 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 275 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  for ( $i = 1; $i <= 16; $i++ ) {
    if ( ! empty ( $array_quest [ "q" . $i ] ) ) {
      $query = "select * from questdata (nolock) where id=" . $array_quest [ "q" . $i ];
      $res = mssql_query ( $query, $link_world );
      $array_questdata = mssql_fetch_array ( $res );
      mssql_free_result ( $res );
?>
  <tr class="<?php print ( $i % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="center"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=8&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;u=<?php print ( $_GET [ "u" ] ); ?>&amp;f=101&amp;quest_id=<?php print ( $array_quest [ "q" . $i ] ); ?>&amp;quest_num=<?php print ( $i ); ?>"><?php print ( $array_quest [ "q" . $i ] ); ?></a></td>
    <td class="center"><?php print ( $array_questdata [ "name" ] ); ?></td>
    <td class="center"><?php print ( $array_quest [ "s" . $i ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $_GET [ "l" ] ); ?>&amp;u=<?php print ( $_GET [ "u" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=2&amp;quest_id=<?php print ( $array_quest [ "q" . $i ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
    }
  }
?>
</table>
