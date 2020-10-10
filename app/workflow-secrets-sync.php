<?php
$cat        = json_decode( file_get_contents( repo_file( '.github/repo-config.json' ) ), true );
$json_files = glob( repo_file( '.github/repos/*.json' ) );
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
	set_action_env( $env_var, implode( PHP_EOL, array_filter( $value ) ), true, true );
}