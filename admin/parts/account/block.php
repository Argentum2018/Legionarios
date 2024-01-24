<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
    $query = "update user_account set " .
      "block_flag=" . ( isset ( $_GET [ "block_flag" ] ) ? "1" : "0" ) . ", " .
      "block_flag2=" . ( isset ( $_GET [ "block_flag2" ] ) ? "1" : "0" ) . ", " .
      "pay_stat=" . ( isset ( $_GET [ "pay_stat" ] ) ? "1" : "0" ) . ", " .
      "login_flag=" . ( isset ( $_GET [ "login_flag" ] ) ? "16" : "0" ) . ", " .
      "warn_flag=" . ( isset ( $_GET [ "warn_flag" ] ) ? "1" : "0" ) . ", " .
      "subscription_flag=" . ( isset ( $_GET [ "subscription_flag" ] ) ? "1" : "0" ) . " " .
      "where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
    $res = mssql_query ( $query, $link_db );
?>
<div class="center">
<?php
    if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 65 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 66 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
    }
?>
</div>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 2 ) {
    if ( ! empty ( $_GET [ "block_time" ] ) ) {
      $query = "update user_account set " .
        "block_flag=1, block_flag2=1, " .
        "block_end_date=dateadd(day," . str_replace ( "'", "''", $_GET [ "block_time" ] ) . ",current_timestamp) " .
        "where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
    } else {
      $query = "update user_account set block_end_date=NULL where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
    }
    $res = mssql_query ( $query, $link_db );
?>
<div class="center">
<?php
    if ( ! empty ( $_GET [ "block_time" ] ) ) {
      if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 245 ] . date ( "Y-m-d H:i:s", time () + $_GET [ "block_time" ] * 86400 ) ); ?>
<?php
      } else {
?>
  <?php print ( $_text [ 246 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
      }
    } else {
      if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 248 ] ); ?>
<?php
      } else {
?>
  <?php print ( $_text [ 249 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
      }
    }
?>
<br /><br />
<?php
  } elseif ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 3 ) {
    $query = "execute all_DelAccount '" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
    $res = mssql_query ( $query, $link_db );
    $query2 = "execute all_DelAccount '" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
    $res2 = mssql_exec ( $query2, $link_world );
?>
<div class="center">
<?php
    if ( $res !== FALSE && $res2 !== FALSE ) {
?>
  <?php print ( $_text [ 172 ] ); ?>
<?php
    } else {
?>
  <?php print ( $_text [ 173 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
    }
?>
<br /><br />
<?php
    mssql_free_result ( $res );
    mssql_free_result ( $res2 );
  }
  $query = "select * from user_account (nolock) where account='" . str_replace ( "'", "''", $_GET [ "l" ] ) . "'";
  $res = mssql_query ( $query, $link_db );
  $array_account = mssql_fetch_array ( $res );
  mssql_free_result ( $res );
?>
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="1" />
<table class="center" width="70%">
  <tr>
  <tr>
    <td colspan="2" class="center">
      <table class="center" width="25%">
        <tr><td class="left">
            <label><input type="checkbox" name="block_flag"<?php print ( $array_account [ "block_flag" ] == 1 ? " checked" : "" ); ?>> <?php print ( $_text [ 24 ] ); ?></label><br />
            <label><input type="checkbox" name="block_flag2"<?php print ( $array_account [ "block_flag2" ] == 1 ? " checked" : "" ); ?>> <?php print ( $_text [ 25 ] ); ?></label><br />
            <label><input type="checkbox" name="pay_stat"<?php print ( $array_account [ "pay_stat" ] == 1 ? " checked" : "" ); ?>> <?php print ( $_text [ 26 ] ); ?></label><br />
            <label><input type="checkbox" name="login_flag"<?php print ( $array_account [ "login_flag" ] == 16 ? " checked" : "" ); ?>> <?php print ( $_text [ 40 ] ); ?></label><br />
            <label><input type="checkbox" name="warn_flag"<?php print ( $array_account [ "warn_flag" ] == 1 ? " checked" : "" ); ?>> <?php print ( $_text [ 41 ] ); ?></label><br />
            <label><input type="checkbox" name="subscription_flag"<?php print ( $array_account [ "subscription_flag" ] == 1 ? " checked" : "" ); ?>> <?php print ( $_text [ 127 ] ); ?></label>
        </td></tr>
      </table>
    </td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center">
      <input type="submit" class="zmien-flagi" value="<?php print ( $_text [ 67 ] ); ?>">
    </td>
  </tr>
</table>
</form>
<br />
<form method="get" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="p" type="hidden" value="<?php print ( $_GET [ "p" ] ); ?>" />
<input name="l" type="hidden" value="<?php print ( $_GET [ "l" ] ); ?>" />
<input name="f" type="hidden" value="<?php print ( $_GET [ "f" ] ); ?>" />
<input name="o" type="hidden" value="2" />
<table class="center" width="50%">
  <tr>
    <td class="center" width="50%">
      <input class="center" name="block_time" type="text">
    </td>
    <td class="center" width="50%">
      <input type="submit" class="button" value="<?php print ( $_text [ 68 ] ); ?>">
    </td>
  </tr>
</table>
</form>
