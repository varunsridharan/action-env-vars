<?php
global $workspace;

define( 'APP_PATH', __DIR__ . '/' );

require_once APP_PATH . 'functions.php';

define( 'WORKSPACE', get_env( 'GITHUB_WORKSPACE', false ) );
define( 'WORKFLOW_TYPE', get_env( 'VS_WORKFLOW_TYPE', false ) );
define( 'SHORT_URL_TOKEN', get_env( 'SVA_ONL_TOKEN', false ) );
define( 'REPO_NAME', get_env( 'REPOSITORY_NAME', false ) );
define( 'REPO_SLUG', get_env( 'REPOSITORY_SLUG', false ) );
define( 'REPO_OWNER', get_env( 'GITHUB_REPOSITORY_OWNER', false ) );
define( 'REPO_TOPICS', get_env( 'REPOSITORY_TOPICS', false ) );

if ( 'workflow-sync' === WORKFLOW_TYPE || 'secrets-sync' === WORKFLOW_TYPE ) {
	require_once APP_PATH . 'workflow-secrets-sync.php';
} else {
	require_once APP_PATH . 'vendor/slim-markdown.php';
	require_once APP_PATH . 'env-vars/index.php';
	load_files( glob( APP_PATH . 'class/*.php' ) );
	load_files( glob( APP_PATH . 'workflows/*.php' ) );
}

