<?php

/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 */
function vs_set_action_env( $key, $value ) {
	echo shell_exec( 'echo "::set-env name=' . $key . '::' . $value . '"' );
	$_ENV[ $key ] = $value;
}

function vs_set_action_evn_ifnot_exists( $key, $value ) {
	if ( ! isset( $_ENV[ $key ] ) ) {
		vs_set_action_env( $key, $value );
		return true;
	}
	return false;
}
