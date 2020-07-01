<?php
require_once APP_PATH . 'class/class-ignore-base.php';
require_once APP_PATH . 'class/class-ignore-envato.php';

$ignore = new Envato_Ignore();

set_action_env_not_exists( 'ENVATO_DIST_IGNORE', $ignore->run( 'ignore' ), true );
set_action_env_not_exists( 'ENVATO_ASSETS_DIST_IGNORE', $ignore->run( 'assets' ), true );
