<?php
_( '###[group] 🐦 Generating Tweet Message' );
if ( 'twitter-post' === WORKFLOW_TYPE ) {
	load_files( glob( APP_PATH . 'vendor/TwitterText/*.php' ) );
	$parser      = new \Twitter\Text\Parser();
	$topics      = repo_topics();
	$homeurl     = get_env( 'REPOSITORY_HOMEPAGE_URL', false );
	$message     = false;
	$hash_tags   = twitter_hash_tags();
	$defaulttags = array();

	/**
	 * Fetches Event Data.
	 */
	$event = get_env( 'GITHUB_EVENT_PATH', false );
	$event = ( file_exists( $event ) ) ? json_decode( file_get_contents( $event ), true ) : false;

	_( 'Home URL : ' . $homeurl );
	$shomeurl = getsh_url( $homeurl );
}

if ( 'twitter-post' === WORKFLOW_TYPE ) {
	$release_tag_name = ( isset( $event['release']['tag_name'] ) ) ? $event['release']['tag_name'] : false;
	$release_url      = ( isset( $event['release']['html_url'] ) ) ? $event['release']['html_url'] : false;
	_( 'Release URL : ' . $release_url );
	$srelease_url = getsh_url( $release_url );

	if ( repo_has_file( '.github/release.tweet' ) ) {
		$message = trim( file_get_contents( repo_file( '.github/release.tweet' ) ) );
		if ( ! empty( $message ) ) {
			_( '✔️ Tweet Content File Found @ :' . repo_file( '.github/release.tweet' ) );
		} else {
			$message = false;
		}
	}

	if ( empty( $message ) ) {
		switch ( get_env( 'VS_REPOSITORY_TYPE' ) ) {
			case 'css':
				//$default_hashtags[] = '#css';
				//$default_hashtags[] = '#csslibrary';
				//$default_hashtags[] = '#cssutility';
				//$default_hashtags[] = '#csslib';
				break;
			case 'javascript':
				//$default_hashtags[] = '#javascript';
				//$default_hashtags[] = '#js';
				//$default_hashtags[] = '#javascriptlibrary';
				//$default_hashtags[] = '#javascriptutility';
				//$default_hashtags[] = '#javascriptlib';
				break;
			case 'php':
				//$default_hashtags[] = '#php';
				//$default_hashtags[] = '#phplibrary';
				//$default_hashtags[] = '#phputility';
				//$default_hashtags[] = '#phplib';
				break;
			case 'wp-library':
				//$default_hashtags[] = '#wordpress';
				//$default_hashtags[] = '#wplibrary';
				//$default_hashtags[] = '#wputility';
				//$default_hashtags[] = '#wplib';
				break;
			case 'wordpress-org':
				//$default_hashtags[] = '#wordpress';
				//$default_hashtags[] = '#wpplugin';
				break;
			case 'envato-plugin':
				//$default_hashtags[] = '#envato';
				break;
			case 'github-action':
				$message            = '📢 {repo_title} V {version} Released 🎉 {short_home_url}';
				//$default_hashtags[] = '#githubactions';
				break;
			default:
				$message = '📢 {repo_title} V {version} Released 🎉 Download Now 👉 ';
				$message .= ( 'yes' === get_env( 'REPOSITORY_IS_PRIVATE', false ) ) ? ' {short_home_url}' : ' {short_release_url}';
				break;
		}
	}

	$sr      = array(
		'{repo_title}'        => get_env( 'GITHUB_REPOSITORY_TITLE', false ),
		'{version}'           => $release_tag_name,
		'{home_url}'          => $homeurl,
		'{release_url}'       => $release_url,
		'{short_release_url}' => $srelease_url,
		'{short_home_url}'    => $shomeurl,
	);
	$message = str_replace( array_keys( $sr ), array_values( $sr ), $message );
	$message = trim( $message );
}

if ( 'twitter-post' === WORKFLOW_TYPE ) {
	$result = $parser->parseTweet( form_tweet_msg( $message, $hash_tags, $default_hashtags ) );

	if ( ! $result->valid ) {
		$is_it_not_valid = true;
		while ( $is_worknot_done ) {
			$result = $parser->parseTweet( form_tweet_msg( $message, $hash_tags, $default_hashtags ) );
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

	$message = form_tweet_msg( $message, $hash_tags, $default_hashtags );
	set_action_env_not_exists( 'TWITTER_STATUS', escape_multiple_line( $message ), true );
}
_( '###[endgroup]' );
