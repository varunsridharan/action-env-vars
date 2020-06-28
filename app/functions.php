<?php
/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
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
 *
 * @return bool
 */
function set_action_env_not_exists( $key, $value ) {
	return ( ! isset( $_ENV[ $key ] ) ) ? set_action_env( $key, $value ) : false;
}

function get_env( $key ) {
	return ( isset( $_ENV[ $key ] ) ) ? $_ENV[ $key ] : new ENV_Not_Exists();
}

function is_env_not_exists( $instance ) {
	return ( $instance instanceof \ENV_Not_Exists );
}

function _echo( $content, $is_cmd = false ) {
	if ( $is_cmd ) {
		echo PHP_EOL . $content . PHP_EOL;
	} else {
		echo $content . PHP_EOL;
	}

}