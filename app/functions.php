<?php

/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 */
function vs_set_action_env( $key, $value ) {
	exec( "echo \"::set-env name=$key::$value\"" );
}