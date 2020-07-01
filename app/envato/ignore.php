<?php
$workspace                     = get_env( 'GITHUB_WORKSPACE', '' );
$default_ignore_content        = default_ignore_content( 'envato' );
$default_assets_ignore_content = default_assets_ignore( 'envato' );

$default     = array(
	'ignore' => '.github/distignore.txt',
	'assets' => '.github/assets-distignore.txt',
);
$files_check = array(
	'ignore' => array( 'envato-distignore.txt', '.github/envato-distignore.txt', 'distignore.txt', $default['ignore'] ),
	'assets' => array( 'assets-distignore.txt', 'envato_assets_exclude_list.txt', $default['assets'] ),
);

$ignore_file        = false;
$assets_ignore_file = false;

foreach ( $files_check['ignore'] as $loc ) {
	if ( file_exists( $workspace . '/' . $loc ) ) {
		$ignore_file = $loc;
	}
}

foreach ( $files_check['assets'] as $loc ) {
	if ( file_exists( $workspace . '/' . $loc ) ) {
		$assets_ignore_file = $loc;
	}
}

if ( empty( $ignore_file ) ) {
	_echo( '⚠️ DISTIGNORE File Not Found ! | Creating Default ' );
	$ignore_file = $workspace . '/' . $default['ignore'];
	@file_put_contents( $ignore_file, implode( PHP_EOL, $default_ignore_content ) );
	_echo( 'File Contents :' . implode( PHP_EOL, $default_ignore_content ) );
} else {
	$ignore_file = $workspace . '/' . $ignore_file;
	_echo( "✔️ DISTIGNORE File Found : ${workspace}/${ignore_file}" );
	_echo( 'Added Predefined DISTIGNORE' );
	$ignore_file_user_content = explode( PHP_EOL, @file_get_contents( $ignore_file ) );
	$ignore_file_user_content = implode( PHP_EOL, array_filter( array_unique( array_merge( $default_ignore_content, $ignore_file_user_content ) ) ) );
	@file_get_contents( $ignore_file, $ignore_file_user_content );
	_echo( 'File Contents :' . $ignore_file_user_content );
}
_echo( '' );

if ( empty( $assets_ignore_file ) ) {
	_echo( '⚠️ Assets DISTIGNORE File Not Found ! | Creating Default ' );
	$assets_ignore_file = $workspace . '/' . $default['assets'];
	@file_put_contents( $assets_ignore_file, implode( PHP_EOL, $default_assets_ignore_content ) );
	_echo( 'File Contents :' . implode( PHP_EOL, $default_assets_ignore_content ) );
} else {
	$assets_ignore_file = $workspace . '/' . $assets_ignore_file;
	_echo( "✔️ Assets DISTIGNORE File Found : ${workspace}/${ignore_file}" );
	_echo( 'Added Predefined Assets DISTIGNORE' );
	$assets_ignore_file_content = explode( PHP_EOL, @file_get_contents( $assets_ignore_file ) );
	$assets_ignore_file_content = implode( PHP_EOL, array_filter( array_unique( array_merge( $default_assets_ignore_content, $assets_ignore_file_content ) ) ) );
	@file_get_contents( $ignore_file, $assets_ignore_file_content );
	_echo( 'File Contents :' . $assets_ignore_file_content );
}
_echo( '' );

set_action_env_not_exists( 'ENVATO_DIST_IGNORE', $ignore_file, true );
set_action_env_not_exists( 'ENVATO_ASSETS_DIST_IGNORE', $assets_ignore_file, true );
