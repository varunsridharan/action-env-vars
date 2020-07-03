<?php
$topics     = get_env( 'REPOSITORY_TOPICS', false );
$event      = get_env( 'GITHUB_EVENT_PATH', false );
$repo_title = get_env( 'GITHUB_REPOSITORY_TITLE', false );
$homeurl    = get_env( 'REPOSITORY_HOMEPAGE_URL', false );
$message    = false;

if ( file_exists( $event ) ) {
	$event = file_get_contents( $event );
	$event = json_decode( $event, true );
} else {
	$event = false;
}

$release_tag_name = ( isset( $event['release']['tag_name'] ) ) ? $event['release']['tag_name'] : false;
$release_url      = ( isset( $event['release']['html_url'] ) ) ? $event['release']['html_url'] : false;

if ( ! empty( $topics ) ) {
	$topics = json_decode( $topics, true );
}

if ( in_array( 'vs-envato-plugin', $topics ) ) {

}

if ( in_array( 'vs-wp-plugin', $topics ) ) {

}

if ( in_array( 'wp-library', $topics ) ) {

}

if ( in_array( 'php-library', $topics ) ) {

}

if ( empty( $message ) ) {
	$message = <<<TEXT
📢 ${repo_title} V ${release_tag_name}  Released 🎉 
Download Now 👉 ${release_url}
TEXT;
}

set_action_env_not_exists( 'TWITTER_STATUS', $message, true );
