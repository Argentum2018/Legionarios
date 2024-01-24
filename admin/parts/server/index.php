<?php
$array_pages_ptr = "array_pages_" . $array_pages [ $_GET [ "p" ] ];
if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
  $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/" . ${$array_pages_ptr} [ $_GET [ "f" ] ] . ".php";
  if ( file_exists ( $part ) ) {
    include ( $part );
  }
} else {
  $query = "select top 1 * from user_count (nolock) where server_id=1 and datediff( [n], record_time, current_timestamp )<=5 order by record_time desc";
  $res = mssql_query ( $query, $link_db );
  if ( mssql_num_rows ( $res ) > 0 ) {
    $array_count = mssql_fetch_array ( $res );
  }
  mssql_free_result ( $res );
?>
<div class="center">
<?php
  if ( isset ( $array_count ) && ! empty ( $array_count ) ) {
?>
  <?php print ( $_text [ 263 ] ); ?><?php print ( $array_count [ "world_user" ] . "/" . $array_count [ "limit_user" ] ); ?>
<?php
  } else {
?>
  <?php print ( $_text [ 264 ] ); ?>
<?php
  }
?>
</div>
<br /><br />
<table class="center button">
  <tr>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=1"><?php print ( $_text [ 229 ] ); ?></a>
    </td>
    <td width="25%">
      <a class="button" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=2"><?php print ( $_text [ 231 ] ); ?></a>
    </td>
    <td width="25%">
      &nbsp;
    </td>
    <td width="25%">
      &nbsp;
    </td>
  </tr>
</table>
<?php
}
?>
