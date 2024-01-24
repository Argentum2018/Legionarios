<?php
  if ( isset ( $_GET [ "o" ] ) && $_GET [ "o" ] == 1 ) {
?>
<div class="center">
<?php
    $query = "select count(account) as count from user_account where account='" . str_replace ( "'", "''", $_POST [ "account" ] ) . "'";
    $res = mssql_query ( $query, $link_db );
    $array_account = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    if ( ! empty ( $array_account [ "count" ] ) ) {
?>
  <?php print ( $_text [ 375 ] ); ?>
<?php
    } elseif ( $_POST [ "password" ] != $_POST [ "password_confirm" ] ) {
?>
  <?php print ( $_text [ 291 ] ); ?>
<?php
    } else {
      for ( $i = 0; $i < 10; $i++ ) {
        $ssn = substr ( $i = gmp_strval ( gmp_random ( 2 ) ), 0, 13 );
        $query = "select count( ssn ) as count from ssn where ssn='" . $ssn . "'";
        $res = mssql_query ( $query, $link_db );
        $array_ssn = mssql_fetch_array ( $res );
        mssql_free_result ( $res );
        if ( ! empty ( $array_ssn [ "count" ] ) )
          break;
      }
      if ( $i == 10 ) {
?>
  <?php print ( $_text [ 368 ] ); ?>
<?php
      } else {
        $query = "insert into ssn ( ssn, name, email, job, phone, zip, addr_main, addr_etc, account_num ) values ( " .
          "'" . $ssn . "', " .
          "'" . str_replace ( "'", "''", $_POST [ "name" ] ) . "', " .
          "'" . str_replace ( "'", "''", $_POST [ "email" ] ) . "', " .
          "0, " .
          "'" . str_replace ( "'", "''", $_POST [ "phone" ] ) . "', " .
          "'" . str_replace ( "'", "''", $_POST [ "zip" ] ) . "', " .
          "'" . str_replace ( "'", "''", $_POST [ "addr_main" ] ) . "', " .
          "'" . str_replace ( "'", "''", $_POST [ "addr_etc" ] ) . "', " .
          "1 )";
        $res = mssql_query ( $query, $link_db );
        $query = "insert into user_account ( account, pay_stat ) values ( " .
          "'" . str_replace ( "'", "''", $_POST [ "account" ] ) . "', " .
          "1 )";
        $res = mssql_query ( $query, $link_db );
        $query = "insert into user_info ( account, ssn, kind ) values ( " .
          "'" . str_replace ( "'", "''", $_POST [ "account" ] ) . "', " .
          "'" . $ssn . "', " .
          "99 )";
        $res = mssql_query ( $query, $link_db );
        $query = "insert into user_auth ( account, password, quiz1, quiz2, answer1, answer2 ) values ( " .
          "'" . str_replace ( "'", "''", $_POST [ "account" ] ) . "', " .
          password_encrypt ( $_POST [ "password" ] ) . ", " .
          "'" . str_replace ( "'", "''", $_POST [ "question1" ] ) . "', " .
          "'" . str_replace ( "'", "''", $_POST [ "question2" ] ) . "', " .
          password_encrypt ( $_POST [ "answer1" ] ) . ", " .
          password_encrypt ( $_POST [ "answer2" ] ) . " )";
        $res = mssql_query ( $query, $link_db );
        if ( $res !== FALSE ) {
?>
  <?php print ( $_text [ 369 ] ); ?>
<?php
        } else {
?>
  <?php print ( $_text [ 370 ] ); ?><strong><?php print ( mssql_get_last_message () ); ?></strong>
<?php
        }
      }
    }
?>
</div>
<br /><br />
<?php
  }
?>
<form method="post" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $_GET [ "p" ] ); ?>&amp;f=<?php print ( $_GET [ "f" ] ); ?>&amp;o=1">
<table class="center" width="60%">
  <caption><?php print ( $_text [ 268 ] ); ?></caption>
  <tr>
    <td width="30%" class="center"><?php print ( $_text [ 22 ] ); ?></td>
    <td width="70%">
      <input class="account" name="account" value="<?php print ( isset ( $_POST [ "account" ] ) ? $_POST [ "account" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 253 ] ); ?></td>
    <td>
      <input class="account" type="password" name="password" value="" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 254 ] ); ?></td>
    <td>
      <input class="account" type="password" name="password_confirm" value="" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 258 ] ); ?></td>
    <td>
      <input class="account" name="name" value="<?php print ( isset ( $_POST [ "name" ] ) ? $_POST [ "name" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 259 ] ); ?></td>
    <td>
      <input class="account" name="email" value="<?php print ( isset ( $_POST [ "email" ] ) ? $_POST [ "email" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 260 ] ); ?></td>
    <td>
      <input class="account" name="phone" value="<?php print ( isset ( $_POST [ "phone" ] ) ? $_POST [ "phone" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 261 ] ); ?></td>
    <td>
      <input class="account" name="addr_main" value="<?php print ( isset ( $_POST [ "addr_main" ] ) ? $_POST [ "addr_main" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 373 ] ); ?></td>
    <td>
      <input class="account" name="addr_etc" value="<?php print ( isset ( $_POST [ "addr_etc" ] ) ? $_POST [ "addr_etc" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 374 ] ); ?></td>
    <td>
      <input class="account" name="zip" value="<?php print ( isset ( $_POST [ "zip" ] ) ? $_POST [ "zip" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 255 ] ); ?></td>
    <td>
      <input class="account" name="question1" value="<?php print ( isset ( $_POST [ "question1" ] ) ? $_POST [ "question1" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 371 ] ); ?></td>
    <td>
      <input class="account" name="answer1" value="<?php print ( isset ( $_POST [ "answer1" ] ) ? $_POST [ "answer1" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 256 ] ); ?></td>
    <td>
      <input class="account" name="question2" value="<?php print ( isset ( $_POST [ "question2" ] ) ? $_POST [ "question2" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td class="center"><?php print ( $_text [ 372 ] ); ?></td>
    <td>
      <input class="account" name="answer2" value="<?php print ( isset ( $_POST [ "answer2" ] ) ? $_POST [ "answer2" ] : "" ); ?>" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="center">
      <input type="submit" class="zatwierdz-zmiany" value="<?php print ( $_text [ 367 ] ); ?>">
    </td>
  </tr>
</table>
</form>
