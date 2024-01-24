<?php
ini_set ( "session.use_trans_sid", false );
ini_set ( "session.use_cookies", true );
ini_set ( "session.use_only_cookies", true );
ini_set ( "session.cookie_httponly", true );
ini_set ( "session.cookie_path", dirname ( $_SERVER [ "PHP_SELF" ] ) );
session_start ();
?>
