<?php
function ansi2unicode ( $ansi_str ) {
  return ( iconv ( $GLOBALS [ "system_charset" ], $GLOBALS [ "sql_charset" ], $ansi_str ) . chr ( 0 ) . chr ( 0 ) );
}

function log_msg ( $msg ) {
  $log_ptr = fopen ( $GLOBALS [ "log_file" ], "a+" );
  fwrite ( $log_ptr, $msg );
  fclose ( $log_ptr );
}

function password_encrypt ( $plain ) {
  $array_mul = array ( 0 => 213119, 1 => 213247, 2 => 213203, 3 => 213821 );
  $array_add = array ( 0 => 2529077, 1 => 2529089, 2 => 2529589, 3 => 2529997 );
  $dst = $key = array ( 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0 );

  for ( $i = 0; $i < strlen ( $plain ); $i++ ) {
    $dst [ $i ] = $key [ $i ] = ord ( substr ( $plain, $i, 1 ) );
  }

  for ( $i = 0; $i <= 3; $i++ ) {
    $val [ $i ] = fmod ( ( $key [ $i * 4 + 0 ] + $key [ $i * 4 + 1 ] * 0x100 + $key [ $i * 4 + 2 ] * 0x10000 + $key [ $i * 4 + 3 ] * 0x1000000 ) * $array_mul [ $i ] + $array_add [ $i ], 4294967296 );
  }

  for ( $i = 0; $i <= 3; $i++ ) {
    $key [ $i * 4 + 0 ] = $val [ $i ] & 0xff;
    $key [ $i * 4 + 1 ] = $val [ $i ] / 0x100 & 0xff;
    $key [ $i * 4 + 2 ] = $val [ $i ] / 0x10000 & 0xff;
    $key [ $i * 4 + 3 ] = $val [ $i ] / 0x1000000 & 0xff;
  }

  $dst [ 0 ] = $dst [ 0 ] ^ $key [ 0 ];
  for ( $i = 1; $i <= 15; $i++ ) {
    $dst [ $i ] = $dst [ $i ] ^ $dst [ $i - 1 ] ^ $key [ $i ];
  }

  for ( $i = 0; $i <= 15; $i++ ) {
    if ( $dst [ $i ] == 0 ) {
      $dst [ $i ] = 0x66;
    }
  }

  $encrypted = "0x";
  for ( $i = 0; $i <= 15; $i++ ) {
    if ( $dst [ $i ] < 16 ) {
      $encrypted .= "0";
    }
    $encrypted .= strtoupper ( dechex ( $dst [ $i ] ) );
  }
  return ( $encrypted );
}

function password_decrypt ( $encrypted ) {
// not finished, could be mathematically impossible or very hard
  $array_mul = array ( 0 => 213119, 1 => 213247, 2 => 213203, 3 => 213821 );
  $array_add = array ( 0 => 2529077, 1 => 2529089, 2 => 2529589, 3 => 2529997 );
  $dst = $key = array ();

  for ( $i = 0; $i <= 15; $i++ ) {
    $key [ $i ] = hexdec ( substr ( $encrypted, $i * 2 + 2, 2 ) );
    if ( $key [ $i ] == 0x66 ) {
      $key [ $i ] = 0;
    }
  }

  $plain = "";
  for ( $i = 0; $i <= 15; $i++ ) {
    $plain .= chr ( $key [ $i ] );
  }
  return ( $plain );
}

function dds_to_image ( $dds_crest ) {
// base work, algorithm done by HD, changes by FidoW, reworked to image by mine

  // Validate type
  if ( substr ( $dds_crest, 0, 4 ) !== "DDS " ) {
    return ( false );
  }
  
  // DDS header
  list ( , $hdr_size ) = unpack ( "V", substr ( $dds_crest, 4, 4 ) );
  list ( , $hdr_flags ) = unpack ( "V", substr ( $dds_crest, 8, 4 ) );
  list ( , $img_height ) = unpack ( "V", substr ( $dds_crest, 12, 4 ) );
  $img_height -= 4;
  list ( , $img_width ) = unpack ( "V", substr ( $dds_crest, 16, 4 ) );
  list ( , $img_pitch ) = unpack ( "v", substr ( $dds_crest, 20, 2 ) );

  // Validate DXT1
  if ( substr ( $dds_crest, 84, 4 ) !== "DXT1" ) {
    return ( false );
  }
  
  // main code
  $dds_ptr = 128;
  $img = imagecreatetruecolor ( $img_width, $img_height );

  for ( $y = -1; $y < $img_height / 4; $y++ ) {
    for ( $x = 0; $x < $img_width / 4; $x++ ) {
      list ( , $color0_16 ) = unpack ( "v", substr ( $dds_crest, $dds_ptr, 2 ) );
      list ( , $color1_16 ) = unpack ( "v", substr ( $dds_crest, $dds_ptr + 2, 2 ) );
      $r0 = ( $color0_16 >> 11 ) << 3;
      $g0 = ( ( $color0_16 >> 5 ) & 0x3f ) << 2;
      $b0 = ( $color0_16 & 31 ) << 3;
      $r1 = ( $color1_16 >> 11 ) << 3;
      $g1 = ( ( $color1_16 >> 5 ) & 0x3f ) << 2;
      $b1 = ( $color1_16 & 31 ) << 3;
      $color0_32 = imagecolorallocate ( $img, $r0, $g0, $b0 );
      $color1_32 = imagecolorallocate ( $img, $r1, $g1, $b1 );
      $color01_32 = imagecolorallocate ( $img, $r0 / 2 + $r1 / 2, $g0 / 2 + $g1 / 2, $b0 / 2 + $b1 / 2 );
      $black = imagecolorallocate ( $img, 0, 0, 0 );
      list ( , $data ) = @unpack ( "V", substr ( $dds_crest, $dds_ptr + 4, 4 ) );
      for ( $yy = 0; $yy < 4; $yy++ ) {
        for ( $xx = 0; $xx < 4; $xx++ ) {
          $bb = $data & 3;
          $data = $data >> 2;
          switch ( $bb ) {
            case 0: $c = $color0_32; break;
            case 1: $c = $color1_32; break;
            case 2: $c = $color01_32; break;
            default: $c = $black; break;
          }
          imagesetpixel ( $img, $x *4 + $xx, $y * 4 + $yy, $c );
        }
      }
      $dds_ptr += 8;
    }
  }
  return ( $img );
}
?>
