<?php
global $vs_args;
$vs_args = array();
function option( $key, $default = false ) {
	global $vs_args;
	if ( empty( $vs_args ) ) {
		$vs_args = json_decode( file_get_contents( APP_PATH . 'config.json' ), true );
	}
	return ( isset( $vs_args[ $key ] ) ) ? $vs_args[ $key ] : $default;
}

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
	_echo( "::set-env name=${key}::${value}" );
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
 */
function _echo( $content ) {
	echo $content . PHP_EOL;
}

/**
 * @param $content
 */
function echo_group_contents( $content ) {
	_echo( '------------------------------------' );
	_echo( $content );
	_echo( '------------------------------------' );
	_echo( ' ' );
}

/**
 * @param $content
 *
 * @return string|string[]
 * @since {NEWVERSION}
 * @example |
 * multi_line="Line 01
 * Line 02
 * Line 03"
 *
 * # escape the characters '%', '\n' and '\r'
 * multi_line="${multi_line//'%'/'%25'}"
 * multi_line="${multi_line//$'\n'/'%0A'}"
 * multi_line="${multi_line//$'\r'/'%0D'}"
 * @see https://github.community/t/set-env-variable-using-github-action-workflow-cmd/120536/2
 */
function escape_multiple_line( $content ) {
	$content = str_replace( '%', '%25', $content );
	$content = str_replace( PHP_EOL, '%0A', $content );
	return str_replace( '\r', '%0D', $content );
}