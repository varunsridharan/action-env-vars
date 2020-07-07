<?php
global $envs;
_( '###[group] 🛠️  Setting Required ENV Variables' );

$envs                                 = option( 'STATIC_ENV', array() );
$envs['VS_BEFORE_HOOK_FILE_LOCATION'] = WORKSPACE . "/.github/workspace/{$envs['VS_BEFORE_HOOK_FILE']}";
$envs['VS_AFTER_HOOK_FILE_LOCATION']  = WORKSPACE . "/.github/workspace/{$envs['VS_AFTER_HOOK_FILE']}";

require_once 'repo-title.php';

foreach ( $envs as $id => $val ) {
	set_action_env_not_exists( $id, $val, true );
}

_( '###[endgroup]' );
