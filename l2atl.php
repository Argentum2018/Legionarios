<?php
###############################################
# id | Function Name(Function parms) #
###############################################

#d = int (4 bytes, little endian)
#S = unicode String ending with \0
#f = float

#1 CheckCharacterPacket("dS")
#2 SetCharacterLocationPacket("dddddS")
#3 SetBuilderCharacterPacket("ddS")
#4 ChangeCharacterNamePacket("dSS")
#5 KickCharacterPacket("dS")
#6 AddSkillPacket("dddS")
#7 DelSkillPacket("ddS")
#8 ModSkillPacket("dddS")
#9 SetOnetimeQuestPacket("dddS")
#10 SetQuestPacket("ddd")
#11 DelQuestPacket("ddS")
#12 AddItemPacket()
#13 DelItemPacket("ddddS")
#14 ModItemPacket("ddddddddddS")
#15 ModCharPacket("dddddddS")
#16 ModChar2Packet("dddddddS")
#17 ModCharPledgePacket("dSS")
#18 PunishCharPacket("ddd")
#19 SetBuilderAccountPacket("SdS")
#20 DisableCharacterPacket("ddS")
#21 EnableCharacterPacket("ddS")
#22 GetCharactersPacket()
#23 SetBookMarkPacket("dSddddS")
#24 DelBookMarkPacket("dSS")
#25 DelPledgeCrestPacket("dS")
#26 ModPledgeNamePacket("dSS")
#27 SetProhibitedPacket("dSS")
#28 SeizeItemPacket("ddddS")
#29 ModChar3Packet("dddddddS")
#30 MoveItemPacket("ddddd")
#31 MoveCharacterPacket("ddSS")
#32 CommentWritePacket("dSSS")
#33 CommentDeletePacket("ddS")
#34 DeleteCharPacket("dS")
#35 RestoreCharPacket("ddSS")
#36 PledgeOustPacket("dS")
#37 PledgeChangeOwnerPacket("ddS")
#38 PledgeDeletePacket()
#39 BanCharPacket("ddS")
#40 MoveItem2Packet("ddddS")
#41 PrintAllAccountData()
#42 PrintAllItemData()
#43 CopyCharPacket("dSdSS")
#44 CreatePetPacket("dddS")
#45 SendHomePacket("dS")
#46 ChangePledgeLevelPacket("ddS")
#47 CreatePledgePacket("SdS")
#48 SetSkillAllPacket("dS")
#49 RestoreChar2Packet("dSdSS")
#50 ManAnnouncePacket("ddSS")
#51 ManIntAnnouncePacket("dddSS")
#52 ModWeekPlayPacket("dddS")
#53 SeizeItem2Packet("ddS")
#54 DelItem2Packet("ddS")
#55 AddItem2Packet("dddddddddS")
#56 GetCharacters2Packet("dS")
#57 DelMacroPacket("ddS")
#58 DelMonRaceTicketPacket("dddS")
#59 DelRecipePacket("ddS")
#60 DelLottoPacket()
#61 ModifyPledgePowerPacket("ddSS")
#62 EventPointPacket("df")
#63 GetPledgePacket("dS")
#64 EventPointPacket("df")
#65 CreateCharacterPacket("SSddddddddffddddddddddS")
#66 AddItemsPacket("dSd")
#67 AddSkillsPacket("dSd")
#68 GetCharacters3Packet("dS")
#69 SetSociality("ddS")
#70 SetInstantAnnouncePacket("SS" or "cdS") (??)
#71 DelHennaPacket("ddS")
#72 AddHennaPacket("ddS")
#73 AddHennaPacket("dSddS")
#74 AddHennasPacket("dSd")
#75 GetCastleListPacket("ddSdSdSddd")
#76 ModifyCharPropertyPacket("ddddddddS")
#77 ModifyCharAbilityDeltaPacket("ddddddddS")
#78 ModifyCharAbilityDeltaPacket("ddddddddS")
#79 DelHenna2Packet("dddS")
#80 AddHenna2Packet("dddS")
#81 AddSkill2Packet("ddddS")
#82 DelSkill2Packet("dddS")
#83 ModifySkill2Packet("ddddS")
#84 AddMacroPacket("dSSSdS")
#85 GetSSQStatusPacket("cdddddddddddd")
#86 GetSSQMainEventRecordPacket("dddddddSd")
#87 ModifyDepositedSSQItemPacket("ddddS")
#88 ChangePetNamePacket("ddSS")
#89 ChangeSubJobPacket("ddS")
#90 StopCharPacket("dd")
#91 CancelPersonalShopPacket("dd")
#92 AddMacroInfoPacket("ddddddSS")
#93 CreateCharacter2Packet("SSddddddddffddddddddddddfS")
#94 AddSkills2Packet("dSd")
#95 AddHennas2Packet("dSd")
#96 AddSubjobsPacket("dSd")
#97 GetPledge2Packet("dS")
#98 DelPledgeEmblemPacket("dS")
#99 RegisterAccountPacket("SS")
#100 DelPledgeAnnouncePacket("dS")
#101 SendPrivateAnnouncePacket("dSS")
#102 GetAgitListPacket("dSdSdSdd")
#103 GetPledgeMemberPacket("dS")
#104 EternalBanPacket("dS")
#105 GetCharacters4Packet("dS")
#106 SetNoblessPacket("ddS")
#107 SetHeroPacket("ddS")
#108 SetPartyLocationPacket("ddddS")
#109 ModOlympiadPointPacket("ddddS")
#110 DummyPacket()

function l2_cached_open () {
  if ( ! isset ( $GLOBALS [ "cached_fptr" ] ) || empty ( $GLOBALS [ "cached_fptr" ] ) ) {
    if ( $cached_fptr = @fsockopen ( $GLOBALS [ "cached_ip" ], $GLOBALS [ "cached_port" ], $errno, $errstr, $GLOBALS [ "cached_timeout" ] ) ) {
      $GLOBALS [ "cached_fptr" ] = $cached_fptr;
    } else {
      $GLOBALS [ "cached_fptr" ] = $errstr;
    }
  }
  return ( $GLOBALS [ "cached_fptr" ] );
}

function l2_cached_close () {
  if ( isset ( $GLOBALS [ "cached_fptr" ] ) && ! empty ( $GLOBALS [ "cached_fptr" ] ) ) {
    fclose ( $GLOBALS [ "cached_fptr" ] );
  }
}

function l2_cached_push ( $cached_packet ) {
  // print ( "Unicode: " . wordwrap ( bin2hex ( $cached_packet ), 80, "<br />", 1 ) . "<br />" );
  $cached_fptr = l2_cached_open ();
  if ( ! is_resource ( $cached_fptr ) ) {
    return ( "Error connecting to cached: " . $cached_fptr . " [server down??]" );
  }
  fwrite ( $cached_fptr,  $cached_packet );
  $array_ret_length = unpack ( "v", fread ( $cached_fptr, 2 ) );
  $ret_id = unpack ( "c", fread ( $cached_fptr, 1 ) );
  $ret_string = "";
  for ( $i = 0; $i < ( ( $array_ret_length [ 1 ] - 4 ) / 4 ); $i++ ) {
    $array_read = unpack ( "i", fread ( $cached_fptr, 4 ) );
    $ret_string .= $array_read [ 1 ]; 
  }
  return ( $ret_string );
}

function l2_checkcharacter ( $char_id ) {
  // 1 - CheckCharacter, char_id
  $cached_op = pack ( "cV", 1, $char_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_setcharacterlocation ( $char_id, $x, $y, $z ) {
  // 2 - SetCharacterLocation, char_id, 1, x, y, z
  $cached_op = pack ( "cVVVVV", 2, $char_id, 1, $x, $y, $z );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_sendhome ( $char_id ) {
  // 45 - SendHome, char_id
  $cached_op = pack ( "cV", 45, $char_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_kickcharacter ( $char_id ) {
  // 5 - KickCharacter, char_id
  $cached_op = pack ( "cV", 5, $char_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_changecharactername ( $char_id, $new_char_name ) {
  // 4 - ChangeCharacterName, char_id, new_char_name
  $cached_op = pack ( "cV", 4, $char_id );
  $cached_op .= ansi2unicode ( $new_char_name );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_modpledgename ( $pledge_id, $name ) {
  // 26 - ModPledgeName, pledge_id, name
  $cached_op = pack ( "cV", 26, $pledge_id );
  $cached_op .= ansi2unicode ( $name );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_setonetimequest ( $char_id, $quest_id, $progress ) {
  // 9 - SetOnetimeQuest, char_id, quest_id, progress ??
  $cached_op = pack ( "cVVV", 9, $char_id, $quest_id, $progress );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_setquest ( $char_id, $quest_id, $progress ) {
  // 10 - SetQuest, char_id, quest_id, progress ??
  $cached_op = pack ( "cVVV", 10, $char_id, $quest_id, $progress );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_delquest ( $char_id, $quest_id ) {
  // 11 - DelQuestPacket, char_id, $quest_id
  $cached_op = pack ( "cVV", 11, $char_id, $quest_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_pledgechangeowner ( $pledge_id, $char_id ) {
  // 37 - PledgeChangeOwner, pledge_id, char_id
  $cached_op = pack ( "cVV", 37, $pledge_id, $char_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_pledgedelete ( $pledge_id ) {
  // 38 - PledgeDelete, pledge_id
  $cached_op = pack ( "cV", 38, $pledge_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_getpledge2 ( $pledge_id ) {
  // 97 - GetPledge2, pledge_id
  $cached_op = pack ( "cV", 97, $pledge_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_modcharpledge ( $char_id, $new_title ) {
  // 17 - ModCharPledge, char_id, new_title
  $cached_op = pack ( "cV", 17, $char_id );
  $cached_op .= ansi2unicode ( $new_title );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_modchar2 ( $char_id, $gender, $race, $class, $face_index, $hair_shape_index, $hair_color_index ) {
  // 16 - ModChar2, char_id, gender, race, class, face_index, hair_shape_index, hair_color_index
  $cached_op = pack ( "cVVVVVVV", 16, $char_id, $gender, $race, $class, $face_index, $hair_shape_index, $hair_color_index );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_modchar3 ( $char_id, $sp, $exp, $karma, $pk, $pkpardon, $duel ) {
  // 29 - ModChar3, char_id, sp, exp, karma, pk, pkpardon, duel
  $cached_op = pack ( "cVVVVVVV", 29, $char_id, $sp, $exp, $karma, $pk, $pkpardon, $duel );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_setsociality ( $char_id, $social ) {
  // 69 - SetSociality, char_id, social
  $cached_op = pack ( "cVV", 69, $char_id, $social );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_punishchar ( $char_id, $time ) {
  // 18 - PunishChar, char_id, punish_id=2, time
  $cached_op = pack ( "cVVV", 18, $char_id, 2, $time );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_disablecharacter ( $char_id ) {
  // 20 - DisableCharacter, char_id
  $cached_op = pack ( "cVV", 20, $char_id, 1 );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_enablecharacter ( $char_id, $account_id ) {
  // 21 - EnableCharacter, char_id, account_id
  $cached_op = pack ( "cVV", 21, $char_id, $account_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}
function l2_deletecharacter ( $char_id ) {
  // 34 - DeleteChar, char_id
  $cached_op = pack ( "cV", 34, $char_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_restorecharacter ( $char_id, $account_id, $char_name ) {
  // 35 - RestoreChar, char_id, account_id, char_name
  $cached_op = pack ( "cVV", 35, $char_id, $account_id );
  $cached_op .= ansi2unicode ( $char_name );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_bancharacter ( $char_id, $time ) {
  // 39 - BanChar, char_id, time
  $cached_op = pack ( "cVV", 39, $char_id, $time );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_movecharacter ( $char_id, $account_id, $account_name ) {
  // 31 - MoveCharacter, char_id, account_id, account_name
  $cached_op = pack ( "cVV", 31, $char_id, $account_id );
  $cached_op .= ansi2unicode ( $account_name );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_moditem ( $char_id, $warehouse, $item_id, $item_type, $amount, $enchant, $eroded, $bless, $ident, $wished ) {
  // 14 - ModItem, char_id, warehouse, item_id, item_type, amount, enchant, eroded, bless, ident, wished
  $cached_op = pack ( "cVVVVVVVVVV", 14, $char_id, $warehouse, $item_id, $item_type, $amount, $enchant, $eroded, $bless, $ident, $wished );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_moveitem2 ( $char_id, $item_id, $new_char_id, $amount ) {
  // 40 - MoveItem2, char_id, item_id, new_char_id, amount
  $cached_op = pack ( "cVVVV", 40, $char_id, $item_id, $new_char_id, $amount );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_delitem2 ( $item_id, $amount ) {
  // 54 - DelItem2, item_id, amount
  $cached_op = pack ( "cVVV", 54, $item_id, $amount, 1 );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_additem2 ( $char_id, $warehouse, $item_type, $amount, $enchant, $eroded, $bless, $ident, $wished ) {
  // 55 - AddItem2, char_id, warehouse, item_type, amount, enchant, eroded, bless, ident, wished
  $cached_op = pack ( "cVVVVVVVVVV", 55, $char_id, $warehouse, $item_type, $amount, $enchant, $eroded, $bless, $ident, $wished, 1 );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_setskillall ( $char_id ) {
  // 48 - SetSkillAll, char_id
  $cached_op = pack ( "cV", 48, $char_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_addskill2 ( $char_id, $skill_id, $skill_level, $subjob_id ) {
  // 81 - AddSkill2, char_id, skill_id, skill_level, subjob_id
  $cached_op = pack ( "cVVVV", 81, $char_id, $skill_id, $skill_level, $subjob_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_delskill2 ( $char_id, $skill_id, $subjob_id ) {
  // 82 - DelSkill2, char_id, skill_id, subjob_id
  $cached_op = pack ( "cVVV", 82, $char_id, $skill_id, $subjob_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_modifyskill2 ( $char_id, $skill_id, $skill_level, $subjob_id ) {
  // 83 - ModifySkill2, char_id, skill_id, skill_level, subjob_id
  $cached_op = pack ( "cVVVV", 83, $char_id, $skill_id, $skill_level, $subjob_id );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_createpet ( $char_id, $item_type, $level ) {
  // 44 - CreatePet, char_id, item_type, level
  $cached_op = pack ( "cVVV", 44, $char_id, $item_type, $level );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}

function l2_registeraccount ( $account_name ) {
  // 99 - RegisterAccount, account_name
  $cached_op = pack ( "c", 99 );
  $cached_op .= ansi2unicode ( $account_name );
  $cached_op .= ansi2unicode ( $_SESSION [ "account" ] );
  $ret_string = l2_cached_push ( pack ( "s", strlen ( $cached_op ) + 2 ) . $cached_op );
  return ( $ret_string );
}
?>
