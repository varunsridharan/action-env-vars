<?php

_echo( '###[group] 🛠️  Setting Required ENV Variables' );

$env_vars                                 = array();
$workspace                                = get_env( 'GITHUB_WORKSPACE', false );
$env_vars['VS_BEFORE_HOOK_FILE']          = 'before.sh';
$env_vars['VS_AFTER_HOOK_FILE']           = 'after.sh';
$env_vars['VS_BEFORE_HOOK_FILE_LOCATION'] = "${workspace}/.github/workspace/{$env_vars['VS_BEFORE_HOOK_FILE']}";
$env_vars['VS_AFTER_HOOK_FILE_LOCATION']  = "${workspace}/.github/workspace/{$env_vars['VS_AFTER_HOOK_FILE']}";
$env_vars['CHLOG_REPO_ORG_NAME']          = 'vs-docs';
$env_vars['LOCAL_CHANGE_LOG_FILE']        = 'CHANGELOG.md';
$env_vars['REMOTE_CHANGE_LOG_FILE']       = 'change-log.md';

foreach ( $env_vars as $id => $val ) {
	set_action_env_not_exists( $id, $val, true );
}

_echo( '###[endgroup]' );
