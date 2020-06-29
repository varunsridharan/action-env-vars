<?php

if ( ! file_exists( get_env( 'GITHUB_WORKSPACE' ) . '/.github/repos.json' ) ) {
	throw new Error( 'EVN Repo JSON File Not Found !' );
}

$json = json_decode( file_get_contents( get_env( 'GITHUB_WORKSPACE' ) . '/.github/repos.json' ) );

$groups = array();

foreach ( $json as $repo => $vars ) {
	foreach ( $vars as $group ) {
		if ( ! isset( $groups[ $group ] ) ) {
			$groups[ $group ] = array();
		}
		$groups[ $group ][] = $vars;
	}
}

if ( ! empty( $groups ) ) {
	foreach ( $groups as $ENV_VAR => $value ) {
		if ( is_array( $value ) ) {
			$value = implode( PHP_EOL, $value );
		}
		set_action_env_not_exists( $ENV_VAR, $value, true );
	}
}