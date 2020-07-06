<?php
global $workflow_type;
$workspace = get_env( 'GITHUB_WORKSPACE', false );

if ( ! empty( $workflow_type ) ) {
	$cat        = json_decode( file_get_contents( $workspace . '/.github/repo-config.json' ), true );
	$json_files = glob( $workspace . '/.github/repos/*.json' );
	$final_var  = array();
	foreach ( $json_files as $file ) {
		$filename = basename( $file );
		$file     = json_decode( file_get_contents( $file ), true );
		if ( ! empty( $file ) ) {
			foreach ( $file as $key => $value ) {
				$vars = ( isset( $cat[ $filename ] ) ) ? $cat[ $filename ] : array();
				$vars = ( ! is_array( $vars ) ) ? array() : $vars;
				if ( is_numeric( $key ) ) {
					$repo = $value;
				} else {
					$repo = $key;
					$vars = array_unique( array_filter( array_merge( $value, $vars ) ) );
				}

				if ( ! empty( $vars ) ) {
					foreach ( $vars as $var ) {
						if ( ! isset( $final_var[ $var ] ) ) {
							$final_var[ $var ] = array();
						}
						$final_var[ $var ][] = $repo;
					}
				}
			}
		}
	}

	foreach ( $final_var as $env_var => $value ) {
		set_action_env( $env_var, escape_multiple_line( implode( PHP_EOL, array_filter( $value ) ) ), true );
	}
} else {
	die( '::error:: Invalid Type Provided' );
}