<?php
global $envs;
$topics = repo_topics();
$type   = 'unknown';

if ( in_array( 'css-library', $topics ) || in_array( 'vs-css-library', $topics ) ) {
	$type = 'css';
}

if ( in_array( 'javascript-library', $topics ) || in_array( 'vs-javascript-library', $topics ) ) {
	$type = 'javascript';
}

if ( in_array( 'php-library', $topics ) || in_array( 'vs-php-library', $topics ) ) {
	$type = 'php';
}

if ( in_array( 'wp-library', $topics ) || in_array( 'vs-wp-library', $topics ) ) {
	$type = 'wp-library';
}

if ( in_array( 'wp-plugin', $topics ) || in_array( 'vs-wp-plugin', $topics ) ) {
	$type = 'wordpress-org';
}

if ( in_array( 'envato-plugin', $topics ) || in_array( 'vs-envato-plugin', $topics ) ) {
	$type = 'codecanyon';
}

if ( in_array( 'github-action', $topics ) || in_array( 'vs-github-action', $topics ) ) {
	$type = 'github-actions';
}


$envs['VS_REPOSITORY_TYPE'] = $type;
