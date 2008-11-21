<?php

//
// Copyright (C) 2006-2008 Next Generation CMS (http://ngcms.ru/)
// Name: configuration.php
// Description: Configuration managment
// Author: Vitaly Ponomarev, Alexey Zinchenko
//

// Protect against hack attempts
if (!defined('NGCMS')) die ('HAL');

$lang = LoadLang('configuration', 'admin');

$save_con = $_REQUEST['save_con'];

if ($subaction == "save" && !is_null($save_con)) {
	$handler			=	fopen(confroot.'config.php', "w");
	$save_config		=	"<?php\n";
	$save_config		.=	'$config = ';
	$save_config		.=	var_export($save_con, true);
	$save_config		.=	";\n";
	$save_config		.=	"?>";
	fwrite($handler, $save_config);
	fclose($handler);

	msg(array("text" => $lang['msgo_saved']));
}

@include(confroot.'config.php');

$tpl -> template('configuration', tpl_actions);


global $AUTH_CAPABILITIES;
$auth_modules = array();
$auth_dbs = array();

foreach ($AUTH_CAPABILITIES as $k => $v) {
	if ($v['login']) { $auth_modules[$k] = $k; }
	if ($v['db']) { $auth_dbs[$k] = $k; }
}

$tvars['vars'] = array(
	'php_self'						=>	$PHP_SELF,
	'timestamp_now'					=>	LangDate($config['timestamp_active'], time()),
	'lock'							=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[lock]", $config['lock']),
	'language_selection'			=>	MakeDropDown(ListFiles("lang", ".."), "save_con[default_lang]", $config['default_lang']),
	'wm_image'						=>	MakeDropDown(ListFiles("trash", "gif"), "save_con[wm_image]", $config['wm_image']),
	'captcha_font'					=>	MakeDropDown(ListFiles("trash", "ttf"), "save_con[captcha_font]", $config['captcha_font']),
	'list_themes'					=>	MakeDropDown(ListFiles("../templates",".."), "save_con[theme]", $config['theme']),
	'users_selfregister'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[users_selfregister]", $config['users_selfregister']),
	'register_type'					=>	MakeDropDown(array("0"=>"$lang[register_extremly]", "1"=>"$lang[register_simple]", "2"=>"$lang[register_activation]", "3"=>"$lang[register_manual]"), "save_con[register_type]", $config['register_type']),
	'blocks_for_reg'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[blocks_for_reg]", $config['blocks_for_reg']),
	'meta'						=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[meta]", $config['meta']),
	'auto_backup'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[auto_backup]", $config['auto_backup']),
	'use_gzip'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_gzip]", $config['use_gzip']),
	'use_captcha'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_captcha]", $config['use_captcha']),
	'use_cookies'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_cookies]", $config['use_cookies']),
	'use_sessions'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_sessions]", $config['use_sessions']),
	'mod_rewrite'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[mod_rewrite]", $config['mod_rewrite']),
	'category_link'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[category_link]", $config['category_link']),
	'category_counters'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[category_counters]", $config['category_counters']),
	'add_onsite'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[add_onsite]", $config['add_onsite']),
	'add_onsite_guests'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[add_onsite_guests]", $config['add_onsite_guests']),
	'use_smilies'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_smilies]", $config['use_smilies']),
	'use_bbcodes'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_bbcodes]", $config['use_bbcodes']),
	'use_htmlformatter'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_htmlformatter]", $config['use_htmlformatter']),
	'htmlsecure_4'					=>	MakeDropDown(array(0 => $lang['noa'], 1 => $lang['yesa']), "save_con[htmlsecure_4]", $config['htmlsecure_4']),
	'htmlsecure_3'					=>	MakeDropDown(array(0 => $lang['noa'], 1 => $lang['yesa']), "save_con[htmlsecure_3]", $config['htmlsecure_3']),
	'htmlsecure_2'					=>	MakeDropDown(array(0 => $lang['noa'], 1 => $lang['yesa']), "save_con[htmlsecure_2]", $config['htmlsecure_2']),
	'forbid_comments'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[forbid_comments]", $config['forbid_comments']),
	'reverse_comments'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[reverse_comments]", $config['reverse_comments']),
	'block_many_com'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[block_many_com]", $config['block_many_com']),
	'com_for_reg'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[com_for_reg]", $config['com_for_reg']),
	'use_avatars'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_avatars]", $config['use_avatars']),
	'avatars_gravatar'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[avatars_gravatar]", $config['avatars_gravatar']),
	'use_photos'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[use_photos]", $config['use_photos']),
	'send_notice'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[send_notice]", $config['send_notice']),
	'remember'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[remember]", $config['remember']),
	'auth_module'					=>	MakeDropDown($auth_modules, "save_con[auth_module]", $config['auth_module']),
	'auth_db'					=>	MakeDropDown($auth_dbs, "save_con[auth_db]", $config['auth_db']),
	'mydomains'					=>	$config['mydomains'],
	'comments_per_npage'				=>	$config['comments_per_npage'],
	'comments_per_1npage'				=>	$config['comments_per_1npage'],
	'debug'						=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[debug]", $config['debug']),
	'debug_queries'					=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[debug_queries]", $config['debug_queries']),
	'debug_profiler'				=>	MakeDropDown(array("1"=>"$lang[yesa]","0"=>"$lang[noa]"), "save_con[debug_profiler]", $config['debug_profiler']),
	'default_newsorder'				=>	MakeDropDown(array('id desc' => $lang['order_id_desc'], 'id asc' => $lang['order_id_asc'], 'postdate desc' => $lang['order_postdate_desc'], 'postdate asc' => $lang['order_postdate_asc'], 'title desc' => $lang['order_title_desc'], 'title asc' => $lang['order_title_asc']), "save_con[default_newsorder]", $config['default_newsorder']),
	'thumb_mode'					=>	MakeDropDown(array("0"=>$lang['mode_demand'],"1"=>$lang['mode_forbid'], "2" => $lang['mode_always']), "save_con[thumb_mode]", $config['thumb_mode']),
	'shadow_mode'					=>	MakeDropDown(array("0"=>$lang['mode_demand'],"1"=>$lang['mode_forbid'], "2" => $lang['mode_always']), "save_con[shadow_mode]", $config['shadow_mode']),
	'shadow_place'					=>	MakeDropDown(array("0"=>$lang['mode_orig'],"1"=>$lang['mode_copy'], "2" => $lang['mode_origcopy']), "save_con[shadow_place]", $config['shadow_place']),
	'stamp_mode'					=>	MakeDropDown(array("0"=>$lang['mode_demand'],"1"=>$lang['mode_forbid'], "2" => $lang['mode_always']), "save_con[stamp_mode]", $config['stamp_mode']),
	'stamp_place'					=>	MakeDropDown(array("0"=>$lang['mode_orig'],"1"=>$lang['mode_copy'], "2" => $lang['mode_origcopy']), "save_con[stamp_place]", $config['stamp_place']),
);


//
// Fill parameters for multiconfig
//
$tmpline = '';
if (is_array($multiconfig)) {
	foreach ($multiconfig as $mid => $mline) {
		$tmpdom = implode("\n",$mline['domains']);
		$tmpline .= "<tr class='contentEntry1'><td>".($mline['active']?'On':'Off')."</td><td>$mid</td><td>".($tmpdom?$tmpdom:'-�� �������-')."</td><td>&nbsp;</td></tr>\n";
	}
}
$tvars['vars']['multilist'] = $tmpline;
$tvars['vars']['defaultSection'] = 'news';

$tpl -> vars('configuration', $tvars);
echo $tpl -> show('configuration');
?>