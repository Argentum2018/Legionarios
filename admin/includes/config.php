<?php
$array_pages = array (
  -2 => "image",
  -1 => "my",
  1 => "account",
  2 => "character",
  3 => "clan",
  4 => "alliance",
  5 => "item",
  6 => "skill",
  7 => "pet",
  8 => "quest",
  9 => "castle",
  10 => "clanhall",
  11 => "donation",
  12 => "server",
);

$array_pages_my = array (
  1 => "logout",
  2 => "password",
  3 => "language",
);

$array_pages_account = array (
  1 => "block",
  2 => "password",
  3 => "modify",
  101 => "create",
);

$array_pages_character = array (
  1 => "kick",
  2 => "block",
  3 => "modify",
  4 => "move",
  5 => "location",
  6 => "change_name",
  7 => "change_title",
  8 => "change_name_color",
  9 => "change_sociality",
  10 => "item",
  11 => "skill",
  12 => "pet",
  13 => "quest",
  14 => "history",
  15 => "friend",
  16 => "blocklist",
);

$array_pages_clan = array (
 -2 => "image",
  1 => "item",
  2 => "change_name",
  3 => "change_leader",
  4 => "delete",
  5 => "war",
);

$array_pages_alliance = array (
 -2 => "image",
);

$array_pages_item = array (
  101 => "modify",
);

$array_pages_skill = array (
  101 => "modify",
);

$array_pages_pet = array (
  101 => "modify",
);

$array_pages_quest = array (
  101 => "modify",
);

$array_pages_castle = array (
  1 => "siege",
);

$array_pages_clanhall = array (
  1 => "auction",
);

$array_pages_donation = array (
  1 => "set",
  2 => "list",
  101 => "set_item",
  102 => "list_item",
);

$array_pages_server = array (
  1 => "stat_richest_char",
  2 => "stat_richest_clan",
);

$array_pages_language = array (
  "en" => "english",
  "pl" => "polish",
);

$array_char_status_style = array (
  -1 => "deleted",
  -2 => "stopped"
);

$array_page_privilege = array (
  "read" => 1,
  "write" => 1 << 1,
  "no_menu" => 1 << 15,
);

$directory_main = dirname ( $_SERVER [ "PHP_SELF" ] ) . "/";
$directory_parts = "parts/";

$sql_ip = "LIGHTZONE23";
$sql_user = "sa";
$sql_password = "Jhossy2325";
$sql_db_panel = "lin2panel";
$sql_db_db = "lin2db";
$sql_db_world = "lin2world";

$system_charset = "CP1250";
$sql_charset = "UCS-2LE";

$cached_ip = "127.0.0.1";
$cached_port = 2012;
$cached_wait = 2;
$cached_timeout = 1;

$log_file = "logs/access_" . date ( "Ymd" ) . ".log";
?>
