<?php
global $envs;
_( '###[group] 🛠️  Setting Required ENV Variables' );

$envs                                 = option( 'STATIC_ENV', array() );
$envs['VS_BEFORE_HOOK_FILE_LOCATION'] = WORKSPACE . "/.github/workspaces/{$envs['VS_BEFORE_HOOK_FILE']}";
$envs['VS_AFTER_HOOK_FILE_LOCATION']  = WORKSPACE . "/.github/workspaces/{$envs['VS_AFTER_HOOK_FILE']}";
$envs['GITBOOK_GITHUB_REPO']          = $envs['VS_CHANGE_LOG_ACCOUNT_NAME'] . '/' . REPO_SLUG;

require_once 'repo-title.php';
require_once 'repo-type.php';

_( '' );
foreach ( $envs as $id => $val ) {
	set_action_env_not_exists( $id, $val, true );
}

_( '###[endgroup]' );
