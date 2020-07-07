<?php
if ( 'wordpress-org-release' === WORKFLOW_TYPE ) {
	$ignore = new Ignore_Base( 'WP' );
	_( '###[group] ⚒️  Handle WordPress Workflow' );

	_( ' ' );
	set_action_env_not_exists( 'WORDPRESS_DIST_IGNORE', $ignore->run( 'ignore' ), true );
	_( ' ' );
	_( '------------------------------------------------------------------------------------' );
	_( ' ' );
	set_action_env_not_exists( 'WORDPRESS_ASSETS_DIST_IGNORE', $ignore->run( 'assets' ), true );
	_( ' ' );

	_( '###[endgroup]' );
}