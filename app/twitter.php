<?php
global $workspace;

_echo( '###[group] 🐦 Generating Tweet Message' );

require_once __DIR__ . '/vendor/autoload.php';

use Twitter\Text\Parser;

$parser           = new Parser();
$topics           = get_env( 'REPOSITORY_TOPICS', false );
$topics           = ( ! empty( $topics ) ) ? json_decode( $topics, true ) : $topics;
$event            = get_env( 'GITHUB_EVENT_PATH', false );
$repo_title       = get_env( 'GITHUB_REPOSITORY_TITLE', false );
$homeurl          = get_env( 'REPOSITORY_HOMEPAGE_URL', false );
$shomeurl         = $homeurl;
$message          = false;
$event            = ( file_exists( $event ) ) ? json_decode( file_get_contents( $event ), true ) : false;
$release_tag_name = ( isset( $event['release']['tag_name'] ) ) ? $event['release']['tag_name'] : false;
$release_url      = ( isset( $event['release']['html_url'] ) ) ? $event['release']['html_url'] : false;
$hash_tags        = array();
$default_hashtags = array();

_echo( 'Home URL : ' . $homeurl );
$shomeurl = getsh_url( $homeurl );
_echo( 'Release URL : ' . $release_url );
$srelease_url = getsh_url( $release_url );

if ( ! empty( $topics ) ) {
	foreach ( $topics as $topic ) {
		if ( false !== strpos( $topic, 'vs-' ) ) {
			continue;
		}

		if ( false !== strpos( $topic, 'vsp-' ) ) {
			continue;
		}
		$hash_tags[] = $topic;
	}
}

if ( ! empty( $hash_tags ) ) {
	if ( count( $hash_tags ) > 3 ) {
		shuffle( $hash_tags );
		$hash_tags = array_slice( $hash_tags, 0, 3 );
	}

	$hash_tags = array_map( function ( $value ) {
		return '#' . str_replace( '-', '', $value );
	}, $hash_tags );
} else {
	$hash_tags = array();
}

if ( file_exists( $workspace . '/.github/release.tweet' ) ) {
	$message = trim( file_get_contents( $workspace . '/.github/release.tweet' ) );
	if ( empty( $message ) ) {
		$message = false;
	} else {
		_echo( '✔️ Tweet Content File Found @ :' . $workspace . '/.github/release.tweet' );
	}
}

if ( empty( $message ) ) {
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
		$message            = '📢 {repo_title} V {version} Released 🎉 {short_home_url}';
		$default_hashtags[] = '#githubactions';
	}
}

if ( empty( $message ) ) {
	$message = '📢 {repo_title} V {version} Released 🎉 Download Now 👉 {short_release_url}';
}

$sr      = array(
	'{repo_title}'        => $repo_title,
	'{version}'           => $release_tag_name,
	'{home_url}'          => $homeurl,
	'{release_url}'       => $release_url,
	'{short_release_url}' => $srelease_url,
	'{short_home_url}'    => $shomeurl,
);
$message = str_replace( array_keys( $sr ), array_values( $sr ), $message );
$message = trim( $message );
$result  = $parser->parseTweet( $message . ' ' . implode( ' ', $hash_tags ) . ' ' . implode( ' ', $default_hashtags ) );

if ( ! $result->valid ) {
	$is_it_not_valid = true;
	while ( $is_worknot_done ) {
		$result = $parser->parseTweet( $message . ' ' . implode( ' ', $hash_tags ) . ' ' . implode( ' ', $default_hashtags ) );
		if ( $result->valid ) {
			$is_worknot_done = false;
		} else {
			if ( ! empty( $hash_tags ) ) {
				array_pop( $hash_tags );
			}

			if ( empty( $hash_tags ) && ! empty( $default_hashtags ) ) {
				array_pop( $default_hashtags );
			}
		}
	}
}

_echo( ' ' );
_echo( '------------------------------------------------------------------------------------' );
_echo( 'Tweet Message : ' . $message );
_echo( 'Hashtags : ' . implode( ' ', $hash_tags ) );
_echo( 'Default Hashtags : ' . implode( ' ', $default_hashtags ) );
_echo( 'Tweet Parse Info : ' . print_r( $result, true ) );
_echo( '------------------------------------------------------------------------------------' );

$message = $message . ' ' . trim( implode( ' ', $hash_tags ) ) . ' ' . trim( implode( ' ', $default_hashtags ) );
set_action_env_not_exists( 'TWITTER_STATUS', escape_multiple_line( $message ), true );

_echo( '###[endgroup]' );
