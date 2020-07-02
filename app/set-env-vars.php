<?php

_echo( '###[group] 🛠️  Setting Required ENV Variables' );

$github_repo = get_env( 'GITHUB_REPOSITORY', false );
$github_repo = explode( '/', $github_repo );
$owner       = '';
$repo_slug   = '';

if ( ! empty( $github_repo ) && is_array( $github_repo ) ) {
	$owner     = isset( $github_repo[0] ) ? $github_repo[0] : '';
	$repo_slug = isset( $github_repo[1] ) ? $github_repo[1] : '';
}

$env_vars                                 = array();
$workspace                                = get_env( 'GITHUB_WORKSPACE', false );
$sha_short                                = substr( get_env( 'GITHUB_SHA', false ), 0, 8 );
$env_vars['GITHUB_REPOSITORY_OWNER']      = trim( $owner );
$env_vars['GITHUB_REPOSITORY_SLUG']       = trim( $repo_slug );
$env_vars['GITHUB_SHA_SHORT']             = $sha_short;
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


_echo( 'GITHUB.event' );
_echo( file_get_contents( 'https://api.github.com/repos/' . implode( '/', $github_repo ) ) );
_echo( '' );


_echo( '###[endgroup]' );
