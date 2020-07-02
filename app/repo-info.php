<?php
_echo( '###[group] 🔧  Setup Repository Information' );

require_once APP_PATH . 'repo-info/title.php';

if ( ! is_env_not_exists( get_env( 'GITHUB_TOKEN' ) ) ) {
	require_once APP_PATH . 'repo-info/type.php';
}


_echo( '###[endgroup]' );
