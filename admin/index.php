<?php
// Start output buffering
ob_start("ob_gzhandler");

// Set error storing
ini_set ( "track_errors", true );

// Start session
include_once ( "includes/session.php" );

// Load configuration
include_once ( "includes/config.php" );
include_once ( "includes/functions.php" );
include_once ( "includes/l2atl.php" );
include_once ( "includes/stats.php" );

// Open databases
$link_panel = mssql_connect ( $sql_ip, $sql_user, $sql_password, true );
mssql_select_db ( $sql_db_panel, $link_panel );
$link_db = mssql_connect ( $sql_ip, $sql_user, $sql_password, true );
mssql_select_db ( $sql_db_db, $link_db );
$link_world = mssql_connect ( $sql_ip, $sql_user, $sql_password, true );
mssql_select_db ( $sql_db_world, $link_world );

// Check logout
if ( isset ( $_GET [ "logout" ] ) && $_GET [ "logout" ] == 1 && isset ( $_SESSION [ "account" ] ) ) {
  $_SESSION [ "logged" ] = "OUT";
  header ( "Location: " . $_SERVER [ "PHP_SELF" ] );
  exit ();
}

// Destroy logout session
if ( isset ( $_SESSION [ "logged" ] ) && $_SESSION [ "logged" ] == "OUT" && isset ( $_COOKIE [ session_name () ] ) ) {
  setcookie ( session_name (), '', time () - 42000, '/' );
}

// Check login
if ( isset ( $_POST [ "login" ] ) && $_POST [ "login" ] == 1 && isset ( $_POST [ "account" ] ) && ! empty ( $_POST [ "account" ] ) && isset ( $_POST [ "password" ] ) && ! empty ( $_POST [ "password" ] ) ) {
  $_SESSION [ "account" ] = preg_replace ( "/[^a-z]+/", "", strtolower ( $_POST [ "account" ] ) );
  $query = "select top 2 * from account (nolock) where account='" . $_SESSION [ "account" ] . "' and password=0x" . md5 ( $_POST [ "password" ] ) . " order by uid";
  $res = mssql_query ( $query, $link_panel );
  $array_account = mssql_fetch_array ( $res );
  if ( mssql_num_rows ( $res ) == 1 ) {
    $_SESSION [ "logged" ] = "OK";
    $_SESSION [ "uid" ] = $array_account [ "uid" ];
    $_SESSION [ "lang" ] = $array_account [ "language" ];
    log_msg ( date ( "Y-m-d H:i:s" ) . " " . $_SERVER [ "REMOTE_ADDR" ] . " " . $_SESSION [ "account" ] . " \"logged-in\"\r\n" );
  } else {
    $_SESSION [ "logged" ] = "ERR";
  }
  mssql_free_result ( $res );
  header ( "Location: " . $_SERVER [ "HTTP_REFERER" ] );
  exit ();
}

// Check privileges for page
if ( isset ( $_SESSION [ "logged" ] ) && $_SESSION [ "logged" ] == "OK" ) {
  $query = "select top 2 * from account_privileges (nolock) where uid=" . $_SESSION [ "uid" ] . " and page='" . str_replace ( "'", "''", $_SERVER [ "QUERY_STRING" ] ) . "' order by uid";
  $res = mssql_query ( $query, $link_panel );
  $array_privileges = mssql_fetch_array ( $res );
  if ( mssql_num_rows ( $res ) != 1 ) {
    $_SESSION [ "privileged" ] = true;
  }
  mssql_free_result ( $res );
}

// Write logs
if ( isset ( $_SESSION [ "logged" ] ) && ! empty ( $_SESSION [ "logged" ] ) ) {
  switch ( $_SESSION [ "logged" ] ) {
    case "OK":
      log_msg ( date ( "Y-m-d H:i:s" ) . " " . $_SERVER [ "REMOTE_ADDR" ] . " " . $_SESSION [ "account" ] . " \"" . preg_replace ( "/[\n\r]/", "", $_SERVER [ "REQUEST_URI" ] ) . "\"\r\n" );
      break;
    case "ERR":
      log_msg ( date ( "Y-m-d H:i:s" ) . " " . $_SERVER [ "REMOTE_ADDR" ] . " " . $_SESSION [ "account" ] . " \"error-login\"\r\n" );
      break;
    case "OUT":
      log_msg ( date ( "Y-m-d H:i:s" ) . " " . $_SERVER [ "REMOTE_ADDR" ] . " " . $_SESSION [ "account" ] . " \"logged-out\"\r\n" );
      break;
    default:
  }
} else {
  log_msg ( date ( "Y-m-d H:i:s" ) . " " . $_SERVER [ "REMOTE_ADDR" ] . " unknown \"" . preg_replace ( "/[\n\r]/", "", $_SERVER [ "REQUEST_URI" ] ) . "\"\r\n" );
}

// Set and load language
if ( isset ( $_SESSION [ "lang" ] ) ) {
  $lang = $_SESSION [ "lang" ];
}
if ( ! isset ( $lang ) ) {
  if ( isset ( $_SERVER [ "HTTP_ACCEPT_LANGUAGE" ] ) ) {
    $array_language = preg_split ( "/[,;\s]+/", $_SERVER [ "HTTP_ACCEPT_LANGUAGE" ] );
    foreach ( $array_language as $language ) {
      if ( array_key_exists ( $language, $array_pages_language ) ) {
        $lang = $language;
        break;
      }
    }
  }
  if ( ! isset ( $lang ) ) {
    $lang = "en";
  }
  $_SESSION [ "lang" ] = $lang;
}
include_once ( "lang/" . $array_pages_language [ $lang ] . ".php" );

// Check for page return
if ( isset ( $_GET [ "ref" ] ) && $_GET [ "ref" ] == 1 ) {
  ignore_user_abort ( true );
  if ( isset ( $_SESSION [ "referer" ] ) && ! empty ( $_SESSION [ "referer" ] ) ) {
    header ( "Location: " . $_SESSION [ "referer" ] );
    unset ( $_SESSION [ "referer" ] );
  } else {
    header ( "Location: " . $_SERVER [ "HTTP_REFERER" ] );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php print ( $_text [ 0 ] ); ?></title>
<meta http-equiv="content-type" content="text/html; charset=windows-1250" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<?php
if ( isset ( $_SESSION [ "logged" ] ) && $_SESSION [ "logged" ] == "OK" ) {
?>
<div class="menu">
<?php
  foreach ( $array_pages as $i => $val ) {
    $query = "select top 2 * from account_privileges (nolock) where uid=" . $_SESSION [ "uid" ] . " and page='p=" . $i . "' order by uid";
    $res = mssql_query ( $query, $link_panel );
    $array_privileges = mssql_fetch_array ( $res );
    if ( $i == -1 ||
         ( ( $array_privileges [ "privilege" ] & $array_page_privilege [ "read" ] ||
             $array_privileges [ "privilege" ] & $array_page_privilege [ "write" ] ) &&
           ( $array_privileges [ "privilege" ] & $array_page_privilege [ "no_menu" ] ) == 0 ) ) {
?>
  <div class="menu-<?php print ( $i == ( isset ( $_GET [ "p" ] ) ? $_GET [ "p" ] : -1 ) ? "selected" : "unselected" ); ?>">
    <a class="menu" href="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>?p=<?php print ( $i ); ?>"><?php print ( $_text_menu [ $i ] ); ?></a>
  </div>
<?php
    }
    mssql_free_result ( $res );
  }
?>
</div>
<div class="strona">
  <br />
<?php
  if ( isset ( $_GET [ "p" ] ) && array_key_exists ( $_GET [ "p" ], $array_pages ) ) {
    $query = "select top 2 * from account_privileges (nolock) where uid=" . $_SESSION [ "uid" ] . " and page='p=" . str_replace ( "'", "''", $_GET [ "p" ] ) . "' order by uid";
    $res = mssql_query ( $query, $link_panel );
    $array_privileges = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    if ( $_GET [ "p" ] == -1 ||
         ( $array_privileges [ "privilege" ] & $array_page_privilege [ "read" ] ||
           $array_privileges [ "privilege" ] & $array_page_privilege [ "write" ] ) ) {
      if ( $array_privileges [ "privilege" ] & $array_page_privilege [ "no_menu" ] ) {
        if ( isset ( $_GET [ "f" ] ) && ! empty ( $_GET [ "f" ] ) ) {
          $query = "select top 2 * from account_privileges (nolock) where uid=" . $_SESSION [ "uid" ] . " and page='p=" . str_replace ( "'", "''", $_GET [ "p" ] ) . "&f=" . str_replace ( "'", "''", $_GET [ "f" ] ) . "' order by uid";
          $res = mssql_query ( $query, $link_panel );
          $array_privileges = mssql_fetch_array ( $res );
          mssql_free_result ( $res );
          if ( $array_privileges &&
               ( $array_privileges [ "privilege" ] & $array_page_privilege [ "read" ] ||
                 $array_privileges [ "privilege" ] & $array_page_privilege [ "write" ] ) ) {
            $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/index.php";
            include ( $part );
          } else {
?>
<table class="center" width="50%">
  <tr>
    <td colspan="2" class="center"><span class="error"><?php print ( $_text [ 336 ] ); ?></span></td>
  </tr>
</table>
<?php
          }
        } else {
?>
<table class="center" width="50%">
  <tr>
    <td colspan="2" class="center"><span class="error"><?php print ( $_text [ 336 ] ); ?></span></td>
  </tr>
</table>
<?php
        }
      } else {
        $part = $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/index.php";
        include ( $part );
      }
    } else {
?>
<table class="center" width="50%">
  <tr>
    <td colspan="2" class="center"><span class="error"><?php print ( $_text [ 336 ] ); ?></span></td>
  </tr>
</table>
<?php
    }
  } else {
    $_GET [ "p" ] = -1;
    include ( $directory_parts . $array_pages [ $_GET [ "p" ] ] . "/index.php" );
  }
?>
  <br /><br />
</div>
<?php
} else {
?>
<div class="login">
<form method="post" action="<?php print ( $_SERVER [ "PHP_SELF" ] ); ?>">
<input name="login" type="hidden" value="1" />
<table class="center" width="50%">
<?php
  if ( isset ( $_SESSION [ "logged" ] ) && $_SESSION [ "logged" ] == "ERR" ) {
    unset ( $_SESSION [ "logged" ] );
    unset ( $_SESSION [ "account" ] );
    session_destroy ();
?>
  <tr>
    <td colspan="2" class="center"><span class="error"><?php print ( $_text [ 294 ] ); ?></span></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
<?php
  } elseif ( isset ( $_SESSION [ "logged" ] ) && $_SESSION [ "logged" ] == "OUT" ) {
    unset ( $_SESSION [ "logged" ] );
    unset ( $_SESSION [ "account" ] );
    unset ( $_SESSION [ "uid" ] );
    unset ( $_SESSION [ "lang" ] );
    session_destroy ();
?>
  <tr>
    <td colspan="2" class="center"><span class="logout"><?php print ( $_text [ 313 ] ); ?></span></td>
  </tr>
  <tr><td colspan="2" height="12"></td></tr>
<?php
  }
?>
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 292 ] ); ?></td>
    <td class="center" width="50%"><input name="account" type="text" class="center" /></td>
  </tr>
  <tr>
    <td class="center" width="50%"><?php print ( $_text [ 253 ] ); ?></td>
    <td class="center" width="50%"><input name="password" type="password" class="center" /></td>
  </tr>
  <tr><td colspan="2" height="4"></td></tr>
  <tr>
    <td colspan="2" class="center"><input class="accept" type="submit" value="<?php print ( $_text [ 293 ] ); ?>" /></td>
  </tr>
</table>
</form>
</div>  
<script type="text/javascript">
// <![CDATA[
document.onload = function () {
  document.forms [ 0 ].account.focus ();
};
// ]]>
</script>
<?php
}
?>
</body>
</html>
<?php
// Close cached link
l2_cached_close ();

// Close databases
mssql_close ( $link_panel );
mssql_close ( $link_db );
mssql_close ( $link_world );

// Flush data
ob_end_flush ();
?>
