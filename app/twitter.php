<?php
$topics     = get_env( 'REPOSITORY_TOPICS', false );
$event      = get_env( 'GITHUB_EVENT_PATH', false );
$repo_title = get_env( 'GITHUB_REPOSITORY_TITLE', false );
$homeurl    = get_env( 'REPOSITORY_HOMEPAGE_URL', false );
$shomeurl   = $homeurl;
$message    = false;

if ( file_exists( $event ) ) {
	$event = file_get_contents( $event );
	$event = json_decode( $event, true );
} else {
	$event = false;
}

$release_tag_name = ( isset( $event['release']['tag_name'] ) ) ? $event['release']['tag_name'] : false;
$release_url      = ( isset( $event['release']['html_url'] ) ) ? $event['release']['html_url'] : false;

$shomeurl     = getsh_url( $homeurl );
$srelease_url = getsh_url( $release_url );
if ( ! empty( $topics ) ) {
	$topics = json_decode( $topics, true );
}

if ( in_array( 'css-library', $topics ) || in_array( 'vs-css-library', $topics ) ) {
}

if ( in_array( 'javascript-library', $topics ) || in_array( 'vs-javascript-library', $topics ) ) {
}

if ( in_array( 'php-library', $topics ) || in_array( 'vs-php-library', $topics ) ) {
}

if ( in_array( 'wp-library', $topics ) || in_array( 'vs-wp-library', $topics ) ) {
}

if ( in_array( 'wp-plugin', $topics ) || in_array( 'vs-wp-plugin', $topics ) ) {
}

if ( in_array( 'envato-plugin', $topics ) || in_array( 'vs-envato-plugin', $topics ) ) {
}

if ( in_array( 'github-action', $topics ) || in_array( 'vs-github-action', $topics ) ) {
	$message = "📢 ${repo_title} V ${release_tag_name} Released 🎉 ${homeurl}
	#github #githubaction #actions";
}

if ( empty( $message ) ) {
	$message = "📢 ${repo_title} V ${release_tag_name} Released 🎉 
Download Now 👉 ${srelease_url}";
}

set_action_env_not_exists( 'TWITTER_STATUS', escape_multiple_line( $message ), true );
