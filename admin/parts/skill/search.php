<div class="center">
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
  <input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>">
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
?>
  <label><?php print ( $_text [ 242 ] ); ?><input name="s" type="text" value="<?php print ( $_GET [ "s" ] ); ?>"></label>
<?php
} else {
?>
  <label><?php print ( $_text [ 242 ] ); ?><input name="s" type="text"></label>
<?php
}
?>
  <input type="submit" class="szukaj" value="<?php print ( $_text [ 4 ] ); ?>">
</form>
</div>
<br />
<?php
if ( isset ( $_GET [ "s" ] ) && ! empty ( $_GET [ "s" ] ) ) {
  $query = "select us.*, ud.*, s.* from user_skill us (nolock) inner join user_data ud (nolock) on us.char_id=ud.char_id left outer join skilldata s (nolock) on us.skill_id=s.id and us.skill_lev=s.lev where us.skill_id like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by s.name, ud.char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 243 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 204 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 205 ] ); ?></th>
    <th class="left" width="45%"><?php print ( $_text [ 206 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 207 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_skill = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_skill [ "account_name" ] ); ?>&amp;u=<?php print ( $array_skill [ "char_id" ] ); ?>&amp;f=101&amp;subjob_id=<?php print ( $array_skill [ "subjob_id" ] ); ?>&amp;skill_id=<?php print ( $array_skill [ "skill_id" ] ); ?>"><?php print ( $array_skill [ "skill_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_skill [ "skill_lev" ] ); ?></td>
    <th class="left"><?php print ( $array_skill [ "name" ] ); ?></th>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=2&amp;l=<?php print ( $array_skill [ "account_name" ] ); ?>&amp;u=<?php print ( $array_skill [ "char_id" ] ); ?>">
        <?php print ( $array_skill [ "char_name" ] ); ?>
      </a>
    </td>
    <td class="center"><?php print ( $array_skill [ "to_end_time" ] ); ?></td>
    <td class="center"><a class="delete" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_skill [ "account_name" ] ); ?>&amp;u=<?php print ( $array_skill [ "char_id" ] ); ?>&amp;o=2&amp;subjob_id=<?php print ( $array_skill [ "subjob_id" ] ); ?>&amp;skill_id=<?php print ( $array_skill [ "skill_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
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
  $query = "select us.*, ud.*, s.* from user_skill us (nolock) inner join user_data ud (nolock) on us.char_id=ud.char_id left outer join skilldata s (nolock) on us.skill_id=s.id and us.skill_lev=s.lev where s.name like '%" . str_replace ( "'", "''", $_GET [ "s" ] ) . "%' order by s.name, ud.char_name";
  $res = mssql_query ( $query, $link_world );
?>
<table class="center list">
  <caption><?php print ( $_text [ 244 ] ); ?></caption>
  <tr class="naglowek">
    <th class="center" width="10%"><?php print ( $_text [ 204 ] ); ?></th>
    <th class="center" width="8%"><?php print ( $_text [ 205 ] ); ?></th>
    <th class="left" width="45%"><?php print ( $_text [ 206 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 21 ] ); ?></th>
    <th class="center" width="15%"><?php print ( $_text [ 207 ] ); ?></th>
    <th class="center" width="7%">&nbsp;</th>
  </tr>
<?php
  $i = 0;
  while ( $array_skill = mssql_fetch_array ( $res ) ) {
?>
  <tr class="<?php print ( $i++ % 2 == 0 ? "even" : "odd" ); ?>">
    <td class="right"><a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_skill [ "account_name" ] ); ?>&amp;u=<?php print ( $array_skill [ "char_id" ] ); ?>&amp;f=101&amp;subjob_id=<?php print ( $array_skill [ "subjob_id" ] ); ?>&amp;skill_id=<?php print ( $array_skill [ "skill_id" ] ); ?>"><?php print ( $array_skill [ "skill_id" ] ); ?></a></td>
    <td class="center"><?php print ( $array_skill [ "skill_lev" ] ); ?></td>
    <th class="left"><?php print ( $array_skill [ "name" ] ); ?></th>
    <td class="left">
      <a href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=3&amp;c=<?php print ( $array_skill [ "char_id" ] ); ?>">
        <?php print ( $array_skill [ "char_name" ] ); ?>
      </a>
    </td>
    <td class="center"><?php print ( $array_skill [ "to_end_time" ] ); ?></td>
    <td class="center"><a class="delete-item" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;l=<?php print ( $array_skill [ "account_name" ] ); ?>&amp;u=<?php print ( $array_skill [ "char_id" ] ); ?>&amp;o=2&amp;subjob_id=<?php print ( $array_skill [ "subjob_id" ] ); ?>&amp;skill_id=<?php print ( $array_skill [ "skill_id" ] ); ?>"><?php print ( $_text [ 105 ] ); ?></a></td>
  </tr>
<?php
  }
?>
</table>
<?php
  mssql_free_result ( $res );
}
?>
