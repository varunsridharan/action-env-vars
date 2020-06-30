<?php
global $workflow_type;
define( 'APP_PATH', __DIR__ . '/' );

try {
	require_once APP_PATH . 'functions.php';

	require_once APP_PATH . 'class-env-not-eixsts.php';

	$workflow_type = ( is_env_not_exists( get_env( 'VS_WORKFLOW_TYPE' ) ) ) ? false : get_env( 'VS_WORKFLOW_TYPE' );

	set_action_env_not_exists( 'MY_LARGE_VAR', ' | VALUE1 VALUE2', true );
	exit;

	if ( in_array( $workflow_type, array( 'workflow-sync', 'secrets-sync' ) ) ) {
		require_once APP_PATH . 'workflow-secrets-sync.php';
	} else {
		require_once APP_PATH . 'set-env-vars.php';

		require_once APP_PATH . 'repo-title.php';

		if ( 'envato-release' === $workflow_type ) {
			require_once APP_PATH . 'envato.php';
		}
	}

} catch ( Exception $exception ) {
	die( '::error:: ' . $exception->getMessage() );
}
