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
