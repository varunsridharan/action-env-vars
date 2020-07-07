<?php
if ( 'twitter-post' === WORKFLOW_TYPE ) {
	_( '###[group] 🐦 Generating Tweet Message' );
}
$message = false;
if ( 'twitter-post' === WORKFLOW_TYPE ) {
	load_files( glob( APP_PATH . 'vendor/TwitterText/*.php' ) );
	$parser      = new \Twitter\Text\Parser();
	$topics      = repo_topics();
	$homeurl     = get_env( 'REPOSITORY_HOMEPAGE_URL', false );
	$hash_tags   = twitter_hash_tags();
	$defaulttags = array();

	if ( empty( $homeurl ) ) {
		$homeurl = get_env( 'REPOSITORY_GITHUB_URL', false );
	}

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
				//$defaulttags[] = '#css';
				//$defaulttags[] = '#csslibrary';
				//$defaulttags[] = '#cssutility';
				//$defaulttags[] = '#csslib';
				break;
			case 'javascript':
				//$defaulttags[] = '#javascript';
				//$defaulttags[] = '#js';
				//$defaulttags[] = '#javascriptlibrary';
				//$defaulttags[] = '#javascriptutility';
				//$defaulttags[] = '#javascriptlib';
				break;
			case 'php':
				//$defaulttags[] = '#php';
				//$defaulttags[] = '#phplibrary';
				//$defaulttags[] = '#phputility';
				//$defaulttags[] = '#phplib';
				break;
			case 'wp-library':
				//$defaulttags[] = '#wordpress';
				//$defaulttags[] = '#wplibrary';
				//$defaulttags[] = '#wputility';
				//$defaulttags[] = '#wplib';
				break;
			case 'wordpress-org':
				//$defaulttags[] = '#wordpress';
				//$defaulttags[] = '#wpplugin';
				break;
			case 'envato-plugin':
				//$defaulttags[] = '#envato';
				break;
			case 'github-action':
				$message = '📢 {repo_title} V {version} Released 🎉 {short_home_url}';
				//$defaulttags[] = '#githubactions';
				break;
		}
	}

	if ( empty( $message ) ) {
		$message = '📢 {repo_title} V {version} Released 🎉 Download Now 👉 ';
		$message .= ( 'yes' === get_env( 'REPOSITORY_IS_PRIVATE', false ) ) ? ' {short_home_url}' : ' {short_release_url}';
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
	$result = $parser->parseTweet( form_tweet_msg( $message, $hash_tags, $defaulttags ) );

	if ( ! $result->valid ) {
		$is_it_not_valid = true;
		while ( $is_worknot_done ) {
			$result = $parser->parseTweet( form_tweet_msg( $message, $hash_tags, $defaulttags ) );
			if ( $result->valid ) {
				$is_worknot_done = false;
			} else {
				if ( ! empty( $hash_tags ) ) {
					array_pop( $hash_tags );
				}

				if ( empty( $hash_tags ) && ! empty( $defaulttags ) ) {
					array_pop( $defaulttags );
				}
			}
		}
	}

	_( ' ' );
	_( '------------------------------------------------------------------------------------' );
	_( 'Tweet Message : ' . $message );
	_( 'Hashtags : ' . implode( ' ', $hash_tags ) );
	_( 'Default Hashtags : ' . implode( ' ', $defaulttags ) );
	_( 'Tweet Parse Info : ' . print_r( $result, true ) );
	_( '------------------------------------------------------------------------------------' );

	$message = form_tweet_msg( $message, $hash_tags, $defaulttags );
	set_action_env_not_exists( 'TWITTER_STATUS', escape_multiple_line( $message ), true );
}
if ( 'twitter-post' === WORKFLOW_TYPE ) {
	_( '###[endgroup]' );
}