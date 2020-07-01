<?php
/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 * @param $msg
 *
 * @return true
 */
function set_action_env( $key, $value ) {
	_echo( "::set-env name=${key}::${value}", true );
	$_ENV[ $key ] = $value;
	return true;
}

/**
 * Sets ENV If not exists.
 *
 * @param $key
 * @param $value
 * @param $msg
 *
 * @return bool
 */
function set_action_env_not_exists( $key, $value, $msg = false ) {
	if ( ! isset( $_ENV[ $key ] ) ) {
		set_action_env( $key, $value );
		if ( $msg ) {
			_echo( "✔️ ENV  ${key} SET WITH VALUE ${value}" );
		}
		return true;
	}
	_echo( "ℹ️ ENV ${key} ALREADY EXISTS WITH VALUE - {$_ENV[$key]}" );
	return false;
}

/**
 * @param      $key
 * @param null $default
 *
 * @return \ENV_Not_Exists|mixed
 */
function get_env( $key, $default = null ) {
	$default = ( null === $default ) ? new ENV_Not_Exists() : $default;
	return ( isset( $_ENV[ $key ] ) ) ? $_ENV[ $key ] : $default;
}

/**
 * @param $instance
 *
 * @return bool
 */
function is_env_not_exists( $instance ) {
	return ( $instance instanceof \ENV_Not_Exists );
}

/**
 * @param      $content
 * @param bool $is_cmd
 */
function _echo( $content, $is_cmd = false ) {
	if ( $is_cmd ) {
		echo PHP_EOL . $content . PHP_EOL;
	} else {
		echo $content . PHP_EOL;
	}
}

/**
 * @param string $type
 *
 * @return array
 */
function default_ignore_content( $type = 'wp' ) {
	return ( 'wp' === $type ) ? array(
		'vendor/*/*/README.md',
		'vendor/*/*/readme.md',
		'vendor/*/*/LICENSE',
		'vendor/*/*/composer.json',
		'vendor/*/*/.editorconfig',
		'vendor/*/*/CHANGELOG.md',
		'vendor/*/*/CODE_OF_CONDUCT.md',
		'vendor/*/*/composer.lock',
		'vendor/*/*/bin',
		'vendor/*/*/.gitignore',
		'vendor/*/*/.gitattributes',
		'vendor/*/*/.all-contributorsrc',
		'vendor/*/*/package-lock.json',
		'vendor/*/*/package.json',
		'vendor/*/*/wp-pot.json',
		'vendor/composer/LICENSE',
		'vendor/composer/installed.json',
		'.all-contributorsrc',
		'.editorconfig',
		'.gitattributes',
		'.gitignore',
		'.git',
		'.github',
		'CHANGELOG.md',
		'readme.md',
		'LICENSE',
		'composer.json',
		'composer.lock',
		'vendor/bin',
		'config.js',
		'gulp-custom.js',
		'gulpfile.js',
		'package.json',
		'package-lock.json',
		'wp-pot.json',
		'.wordpress-org',
		'.wporgassetsignore',
		'.wporgignore',
		'/src/',
	) : array(
		'/src/',
		'gulpfile.js',
		'gulp-config.js',
		'composer.lock',
		'composer.json',
		'wp-pot.json',
		'envato_assets_exclude_list.txt',
		'.envatoassets',
		'.gitignore',
		'.editorconfig',
		'vendor/*/*/README.md',
		'vendor/*/*/.gitignore',
	);
}

function default_assets_ignore( $type = 'wp' ) {
	return ( 'wp' === $type ) ? array( '*.psd', '*.zip' ) : array( 'screenshots/*', 'psd/*.zip' );
}

function echo_group_contents( $content ) {
	_echo( '------------------------------------' );
	_echo( $content );
	_echo( '------------------------------------' );
	_echo( ' ' );
}