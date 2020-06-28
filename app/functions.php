<?php

/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 */
function vs_set_action_env( $key, $value ) {
	$output = '';
	exec( "::set-env name=$key::$value", $output );
	var_dump( $output );
}