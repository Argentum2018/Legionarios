<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 331 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 331 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  $query = "";
  for ( $i = 1; $i <= 16; $i++ ) {
    $query .= "select q.q" . $i . " as quest_id, q.s" . $i . " as quest_status, ud.*, qd.*, unc.color_rgb, " . $i . " as quest_num from quest q (nolock) inner join user_data ud (nolock) on q.char_id=ud.char_id left outer join questdata qd (nolock) on q.q" . $i . "=qd.id left outer join user_name_color unc on ud.char_id=unc.char_id where q.q" . $i . " like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' ";
    if ( $i < 16 )
      $query .= "union ";
  }
  $query .= "order by 1, ud.char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 332 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 274 ] ); ?></th>
    <th class="left" width="40%"><?php print ( $_text [ 287 ] ); ?></th>
    <th class="left" width="35%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 275 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_quest = mssql_fetch_array ( $res ) ) {
    if ( $array_quest [ "account_id" ] < 0 ) {
?>
  <tr class="<?php print ( $array_char_status_style [ $array_quest [ "account_id" ] ] ); ?>">
<?php
    } else {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
    }
?>
    <td class="center"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>&amp;f=101&amp;quest_id=<?php print ( $array_quest [ "quest_id" ] ); ?>&amp;quest_num=<?php print ( $array_quest [ "quest_num" ] ); ?>"><?php print ( $array_quest [ "quest_id" ] ); ?></a></td>
    <td class="left"><?php print ( $array_quest [ "name" ] ); ?></td>
    <td class="left">
<?php
    if ( $array_quest [ "color_rgb" ] <> "" ) {
?>
      <a style="color: #<?php printf ( "%02X%02X%02X", $array_quest [ "color_rgb" ] & 0xff, ( $array_quest [ "color_rgb" ] & 0xff00 ) >> 8, ( $array_quest [ "color_rgb" ] & 0xff0000 ) >> 16 ); ?>;" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>">
        <?php print ( $array_quest [ "char_name" ] ); ?>
      </a>
<?php
    } else {
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>">
        <?php print ( $array_quest [ "char_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
    <td class="center"><?php print ( $array_quest [ "quest_status" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>&amp;f=12&amp;o=2&amp;quest_id=<?php print ( $array_quest [ "quest_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
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
  $query = "";
  for ( $i = 1; $i <= 16; $i++ ) {
    $query .= "select q.q" . $i . " as quest_id, q.s" . $i . " as quest_status, ud.*, qd.*, unc.color_rgb, " . $i . " as quest_num from quest q (nolock) inner join user_data ud (nolock) on q.char_id=ud.char_id left outer join questdata qd (nolock) on q.q" . $i . "=qd.id left outer join user_name_color unc on ud.char_id=unc.char_id where qd.name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' ";
    if ( $i < 16 )
      $query .= "union ";
  }
  $query .= "order by qd.name, ud.char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 333 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 274 ] ); ?></th>
    <th class="left" width="40%"><?php print ( $_text [ 287 ] ); ?></th>
    <th class="left" width="35%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 275 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_quest = mssql_fetch_array ( $res ) ) {
    if ( $array_quest [ "account_id" ] < 0 ) {
?>
  <tr class="<?php print ( $array_char_status_style [ $array_quest [ "account_id" ] ] ); ?>">
<?php
    } else {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
<?php
    }
?>
    <td class="center"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>&amp;f=101&amp;quest_id=<?php print ( $array_quest [ "quest_id" ] ); ?>&amp;quest_num=<?php print ( $array_quest [ "quest_num" ] ); ?>"><?php print ( $array_quest [ "quest_id" ] ); ?></a></td>
    <td class="left"><?php print ( $array_quest [ "name" ] ); ?></td>
    <td class="left">
<?php
    if ( $array_quest [ "color_rgb" ] <> "" ) {
?>
      <a style="color: #<?php printf ( "%02X%02X%02X", $array_quest [ "color_rgb" ] & 0xff, ( $array_quest [ "color_rgb" ] & 0xff00 ) >> 8, ( $array_quest [ "color_rgb" ] & 0xff0000 ) >> 16 ); ?>;" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>">
        <?php print ( $array_quest [ "char_name" ] ); ?>
      </a>
<?php
    } else {
?>
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>">
        <?php print ( $array_quest [ "char_name" ] ); ?>
      </a>
<?php
    }
?>
    </td>
    <td class="center"><?php print ( $array_quest [ "quest_status" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_quest [ "account_name" ] ); ?>&amp;u=<?php print ( $array_quest [ "char_id" ] ); ?>&amp;f=12&amp;o=2&amp;quest_id=<?php print ( $array_quest [ "quest_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
}
?>
