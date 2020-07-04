<?php
global $workflow_type;
$workspace = get_env( 'GITHUB_WORKSPACE', false );
$json      = json_decode( file_get_contents( $workspace . '/.github/repos.json' ) );
$groups    = array();

if ( ! empty( $workflow_type ) ) {
	foreach ( $json as $repo => $vars ) {
		foreach ( $vars as $group ) {
			$groups[ $group ][] = $repo;
		}
	}

	foreach ( $groups as $env_var => $value ) {
		set_action_env( $env_var, escape_multiple_line( implode( PHP_EOL, array_filter( $value ) ) ) );
	}
} else {
	die( '::error:: Invalid Type Provided' );
}