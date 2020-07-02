<?php
_echo( '###[group] 🛠️  Setting Required ENV Variables' );

$env                                 = option( 'STATIC_ENV', array() );
$workspace                           = get_env( 'GITHUB_WORKSPACE', false );
$env['VS_BEFORE_HOOK_FILE_LOCATION'] = "${workspace}/.github/workspace/{$env['VS_BEFORE_HOOK_FILE']}";
$env['VS_AFTER_HOOK_FILE_LOCATION']  = "${workspace}/.github/workspace/{$env['VS_AFTER_HOOK_FILE']}";

foreach ( $env as $id => $val ) {
	set_action_env_not_exists( $id, $val, true );
}

_echo( '###[endgroup]' );
