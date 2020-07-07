<?php
global $vs_args;
$vs_args = array();

/**
 * @param      $key
 * @param bool $default
 *
 * @return bool|mixed
 */
function option( $key, $default = false ) {
	global $vs_args;
	if ( empty( $vs_args ) ) {
		$vs_args = json_decode( file_get_contents( APP_PATH . 'config.json' ), true );
	}
	return ( isset( $vs_args[ $key ] ) ) ? $vs_args[ $key ] : $default;
}

/**
 * @param      $key
 * @param null $default
 *
 * @return \ENV_Not_Exists|mixed
 */
function get_env( $key, $default = null ) {
	return ( isset( $_ENV[ $key ] ) ) ? $_ENV[ $key ] : $default;
}

/**
 * Loads A File.
 *
 * @param $file
 */
function load_files( $file ) {
	if ( is_array( $file ) ) {
		foreach ( $file as $f ) {
			require_once $f;
		}
	} else {
		require_once $file;
	}
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
function set_action_env( $key, $value, $msg = false ) {
	_( "::set-env name=${key}::${value}" );
	$_ENV[ $key ] = $value;
	if ( $msg ) {
		_( "✔️ ENV  ${key} SET WITH VALUE ${value}" );
	}
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
		set_action_env( $key, $value, $msg );
		return true;
	}
	_( "ℹ️ENV ${key} ALREADY EXISTS WITH VALUE - {$_ENV[$key]}" );
	return false;
}

/**
 * Returns REPO File.
 *
 * @param string $file
 *
 * @return string
 */
function repo_file( $file = '' ) {
	return WORKSPACE . '/' . $file;
}

/**
 * Checks if file exists in repo.
 *
 * @param $file
 *
 * @return bool
 */
function repo_has_file( $file ) {
	return ( file_exists( WORKSPACE . '/' . $file ) );
}

/**
 * @param      $content
 */
function _( $content ) {
	echo $content . PHP_EOL;
}

/**
 * @param $content
 */
function _group_contents( $content ) {
	_( '------------------------------------' );
	_( $content );
	_( '------------------------------------' );
	_( ' ' );
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

/**
 * Fetches Repo Topics.
 *
 * @return array|mixed|string
 * @since {NEWVERSION}
 */
function repo_topics() {
	$topics = ( ! empty( REPO_TOPICS ) ) ? json_decode( REPO_TOPICS, true ) : '';
	return ( ! is_array( $topics ) ) ? array() : $topics;
}