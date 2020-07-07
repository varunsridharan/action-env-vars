<?php
if ( 'envato-release' === WORKFLOW_TYPE ) {
	$ignore = new Ignore_Base( 'ENVATO' );
	_( '###[group] ⚒️  Handle Envato Workflow' );

	_( ' ' );
	set_action_env_not_exists( 'ENVATO_DIST_IGNORE', $ignore->run( 'ignore' ), true );
	_( ' ' );
	_( '------------------------------------------------------------------------------------' );
	_( ' ' );
	set_action_env_not_exists( 'ENVATO_ASSETS_DIST_IGNORE', $ignore->run( 'assets' ), true );
	_( ' ' );

	_( '###[endgroup]' );
}