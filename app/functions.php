<?php

/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 */
function vs_set_action_env( $key, $value ) {
	$output = '';
	echo shell_exec( 'echo "::set-env name=' . $key . '::' . $value . '"' );
	//var_dump( shell_exec( "echo \"::set-env name=$key::$value\"" ) );
	//var_dump( $output );
}