<?php
/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 */
function vs_set_action_env( $key, $value ) {
	echo "::set-env name=${key}::${value}";
	echo PHP_EOL;
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
function vs_set_action_evn_ifnot_exists( $key, $value ) {
	return ( ! isset( $_ENV[ $key ] ) ) ? vs_set_action_env( $key, $value ) : false;
}

function _echo( $content ) {
	echo $content . PHP_EOL;
}