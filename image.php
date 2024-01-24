<?php
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

// Generate image
if ( isset ( $_SESSION [ "logged" ] ) && $_SESSION [ "logged" ] == "OK" && isset ( $_GET [ "t" ] ) && ! empty ( $_GET [ "t" ] ) ) {
  switch ( $_GET [ "t" ] ) {
    case "1":
      $image_func = "imagepng";
      $image_type = "image/png";
      break;
    case "2":
      $image_func = "imagejpeg";
      $image_type = "image/jpeg";
      break;
    default:
      $image_func = "imagepng";
      $image_type = "image/png";
      break;
  }
  header ( "Content-Type: " . $image_type );
  if ( isset ( $_GET [ "c" ] ) && ! empty ( $_GET [ "c" ] ) ) {
    $query = "select pc.bitmap from pledge p inner join pledge_crest pc on p.crest_id=pc.crest_id where p.pledge_id=" . str_replace ( "'", "''", $_GET [ "c" ] );
    $res = mssql_query ( $query, $link_world );
    $array_clan_crest = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    $image_func ( dds_to_image ( $array_clan_crest [ "bitmap" ] ) );
  } elseif ( isset ( $_GET [ "a" ] ) && ! empty ( $_GET [ "a" ] ) ) {
    $query = "select pc.bitmap from alliance a inner join pledge_crest pc on a.crest_id=pc.crest_id where a.id=" . str_replace ( "'", "''", $_GET [ "a" ] );
    $res = mssql_query ( $query, $link_world );
    $array_clan_crest = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    $image_func ( dds_to_image ( $array_clan_crest [ "bitmap" ] ) );
  } elseif ( isset ( $_GET [ "i" ] ) && ! empty ( $_GET [ "i" ] ) ) {
    $query = "select pc.bitmap from pledge p inner join pledge_crest pc on p.crest_id=pc.crest_id where p.name='" . str_replace ( "'", "''", $_GET [ "c" ] ) . "'";
    $res = mssql_query ( $query, $link_world );
    $array_clan_crest = mssql_fetch_array ( $res );
    mssql_free_result ( $res );
    $image_func ( dds_to_image ( $array_clan_crest [ "bitmap" ] ) );
  }
}
// Close databases
mssql_close ( $link_panel );
mssql_close ( $link_db );
mssql_close ( $link_world );
?>