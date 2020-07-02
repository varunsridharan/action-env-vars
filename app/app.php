<?php
global $workflow_type;
define( 'APP_PATH', __DIR__ . '/' );

try {
	require_once APP_PATH . 'functions.php';

	require_once APP_PATH . 'class-env-not-eixsts.php';

	$workflow_type = ( is_env_not_exists( get_env( 'VS_WORKFLOW_TYPE' ) ) ) ? false : get_env( 'VS_WORKFLOW_TYPE' );

	require_once APP_PATH . 'set-env-vars.php';

	require_once APP_PATH . 'repo-info.php';

	if ( 'envato-release' === $workflow_type ) {
		require_once APP_PATH . 'envato.php';
	}

	if ( 'wordpress-org-release' === $workflow_type ) {
		require_once APP_PATH . 'wordpress.php';
	}
} catch ( Exception $exception ) {
	die( '::error:: ' . $exception->getMessage() );
}
