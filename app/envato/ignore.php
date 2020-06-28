<?php
$workspace                     = get_env( 'GITHUB_WORKSPACE' );
$default_ignore_content        = <<<TEXT
/src/ 
gulpfile.js 
gulp-config.js 
composer.lock 
composer.json 
wp-pot.json 
envato_assets_exclude_list.txt
TEXT;
$default_assets_ignore_content = <<<TEXT
screenshots/* 
psd/*.zip
TEXT;
$default                       = array(
	'ignore' => '.github/distignore.txt',
	'assets' => '.github/assets-distignore.txt',
);
$files_check                   = array(
	'ignore' => array( 'envato-distignore.txt', '.github/envato-distignore.txt', 'distignore.txt', $default['ignore'] ),
	'assets' => array( 'assets-distignore.txt', 'envato_assets_exclude_list.txt', $default['assets'] ),
);
$ignore_file                   = false;
$assets_ignore_file            = false;

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
	_echo( '::warning:: ⚠️ DISTIGNORE File Not Found ! | Creating Default ' );
	$ignore_file = $workspace . '/' . $default['ignore'];
	@file_put_contents( $ignore_file, $default_ignore_content );
} else {
	$ignore_file = $workspace . '/' . $ignore_file;
	_echo( "✔️ DISTIGNORE File Found : ${workspace}/${ignore_file}" );
}

if ( empty( $assets_ignore_file ) ) {
	_echo( '::warning:: ⚠️ Assets DISTIGNORE File Not Found ! | Creating Default ' );
	$assets_ignore_file = $workspace . '/' . $default['assets'];
	@file_put_contents( $assets_ignore_file, $default_assets_ignore_content );
} else {
	$assets_ignore_file = $workspace . '/' . $assets_ignore_file;
	_echo( "✔️ Assets DISTIGNORE File Found : ${workspace}/${ignore_file}" );
}

set_action_env_not_exists( 'ENVATO_DIST_IGNORE', $ignore_file, true );
set_action_env_not_exists( 'ENVATO_ASSETS_DIST_IGNORE', $assets_ignore_file, true );
