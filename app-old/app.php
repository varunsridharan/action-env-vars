<?php
global $workflow_type, $workspace;
define( 'APP_PATH', __DIR__ . '/' );

try {
	require_once APP_PATH . 'class/class-env-not-eixsts.php';

	require_once APP_PATH . 'functions.php';

	$workspace     = get_env( 'GITHUB_WORKSPACE', false );
	$workflow_type = ( is_env_not_exists( get_env( 'VS_WORKFLOW_TYPE' ) ) ) ? false : get_env( 'VS_WORKFLOW_TYPE' );

	if ( 'workflow-sync' === $workflow_type || 'secrets-sync' === $workflow_type ) {
		require_once APP_PATH . 'workflow-secrets-sync.php';
	} else {
		require_once APP_PATH . 'set-env-vars.php';
		require_once APP_PATH . 'repo-info.php';

		if ( 'envato-release' === $workflow_type ) {
			require_once APP_PATH . 'envato.php';
		}

		if ( 'wordpress-org-release' === $workflow_type ) {
			require_once APP_PATH . 'wordpress.php';
		}

		if ( 'twitter-post' === $workflow_type ) {
			require_once APP_PATH . 'twitter.php';
		}
	}
} catch ( Exception $exception ) {
	die( '::error:: ' . $exception->getMessage() );
}