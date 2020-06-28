<?php
define( 'APP_PATH', __DIR__ . '/' );

try {
	require_once APP_PATH . 'functions.php';

	require_once APP_PATH . 'class-env-not-eixsts.php';

	require_once APP_PATH . 'set-env-vars.php';

	require_once APP_PATH . 'repo-title.php';

	require_once APP_PATH . 'envato.php';

} catch ( Exception $exception ) {
	die( '::error:: ' . $exception->getMessage() );
}
