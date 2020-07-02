<?php
require_once APP_PATH . 'class/class-ignore-base.php';

_echo( '###[group] ⚒️  Handle Envato Workflow' );
_echo( ' ' );


$ignore = new Ignore_Base( 'ENVATO' );
set_action_env_not_exists( 'ENVATO_DIST_IGNORE', $ignore->run( 'ignore' ), true );
_echo( ' ' );
_echo( '------------------------------------------------------------------------------------' );
_echo( ' ' );
set_action_env_not_exists( 'ENVATO_ASSETS_DIST_IGNORE', $ignore->run( 'assets' ), true );

_echo( '###[endgroup]' );
