<?php
global $vs_args;
$vs_args = array();

/**
 * @param      $key
 * @param bool $default
 *
 * @return bool|mixed
 */
function option( $key, $default = false ) {
	global $vs_args;
	if ( empty( $vs_args ) ) {
		$vs_args = json_decode( file_get_contents( APP_PATH . 'config.json' ), true );
	}
	return ( isset( $vs_args[ $key ] ) ) ? $vs_args[ $key ] : $default;
}

/**
 * @param      $key
 * @param null $default
 *
 * @return \ENV_Not_Exists|mixed
 */
function get_env( $key, $default = null ) {
	return ( isset( $_ENV[ $key ] ) ) ? $_ENV[ $key ] : $default;
}

/**
 * Loads A File.
 *
 * @param $file
 */
function load_files( $file ) {
	if ( is_array( $file ) ) {
		foreach ( $file as $f ) {
			require_once $f;
		}
	} else {
		require_once $file;
	}
}

/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 * @param $msg
 * @param $multiline
 *
 * @return true
 */
function set_action_env( $key, $value, $msg = false, $multiline = false ) {
	if ( $multiline ) {
		shell_exec( 'echo "' . $key . '<<<DATA"' );
		shell_exec( 'echo "' . addslashes( $value ) . '" >> $GITHUB_ENV' );
		shell_exec( 'echo "DATA" >> $GITHUB_ENV' );
	} else {
		shell_exec( 'echo "' . $key . '=' . addslashes( $value ) . '" >> $GITHUB_ENV' );
	}

	//_( "::set-env name=${key}::${value}" );
	$_ENV[ $key ] = $value;
	if ( $msg ) {
		_( "✔️ ENV  ${key} SET WITH VALUE ${value}" );
	}
	return true;
}

/**
 * Sets ENV If not exists.
 *
 * @param $key
 * @param $value
 * @param $msg
 * @param $multiline
 *
 * @return bool
 */
function set_action_env_not_exists( $key, $value, $msg = false, $multiline = false ) {
	if ( ! isset( $_ENV[ $key ] ) ) {
		set_action_env( $key, $value, $msg, $multiline );
		return true;
	}
	_( "ℹ️ENV ${key} ALREADY EXISTS WITH VALUE - {$_ENV[$key]}" );
	return false;
}

/**
 * Returns REPO File.
 *
 * @param string $file
 *
 * @return string
 */
function repo_file( $file = '' ) {
	return WORKSPACE . '/' . $file;
}

/**
 * Checks if file exists in repo.
 *
 * @param $file
 *
 * @return bool
 */
function repo_has_file( $file ) {
	return ( file_exists( WORKSPACE . '/' . $file ) );
}

/**
 * @param      $content
 */
function _( $content ) {
	echo $content . PHP_EOL;
}

/**
 * @param $content
 */
function _group_contents( $content ) {
	_( '------------------------------------' );
	_( $content );
	_( '------------------------------------' );
	_( ' ' );
}

/**
 * @param $content
 *
 * @return string|string[]
 * @since {NEWVERSION}
 * @example |
 * multi_line="Line 01
 * Line 02
 * Line 03"
 *
 * # escape the characters '%', '\n' and '\r'
 * multi_line="${multi_line//'%'/'%25'}"
 * multi_line="${multi_line//$'\n'/'%0A'}"
 * multi_line="${multi_line//$'\r'/'%0D'}"
 * @see https://github.community/t/set-env-variable-using-github-action-workflow-cmd/120536/2
 */
function escape_multiple_line( $content ) {
	$content = str_replace( '%', '%25', $content );
	$content = str_replace( PHP_EOL, '%0A', $content );
	return str_replace( '\r', '%0D', $content );
}

/**
 * Fetches Repo Topics.
 *
 * @return array|mixed|string
 * @since {NEWVERSION}
 */
function repo_topics() {
	$topics = ( ! empty( REPO_TOPICS ) ) ? json_decode( REPO_TOPICS, true ) : '';
	return ( ! is_array( $topics ) ) ? array() : $topics;
}

/**
 * @param bool $token
 * @param null $url
 * @param null $custom
 *
 * @return mixed
 * @since {NEWVERSION}
 */
function sva_shorturl( $token = false, $url = null, $custom = null ) {
	$api_url = 'https://sva.onl/api/?key=' . $token . '&url=' . urlencode( filter_var( $url, FILTER_SANITIZE_URL ) );

	if ( ! empty( $custom ) ) {
		$api_url .= '&custom=' . strip_tags( $custom );
	}

	$curl = curl_init();
	curl_setopt_array( $curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL            => $api_url,
	) );
	$response = curl_exec( $curl );
	curl_close( $curl );
	return json_decode( $response, true );
}

/**
 * @param $url
 *
 * @return mixed
 * @since {NEWVERSION}
 */
function getsh_url( $url ) {
	if ( empty( SHORT_URL_TOKEN ) ) {
		_( 'https://sva.onl API Token Missing !' );
		return $url;
	}
	$shurl = sva_shorturl( SHORT_URL_TOKEN, $url );
	if ( isset( $shurl['short'] ) && isset( $shurl['error'] ) && 0 === $shurl['error'] ) {
		_( 'Short URL : ' . $shurl['short'] );
		return $shurl['short'];
	}
	_( 'Unable To Short URL !!' );
	return $url;
}

/**
 * converts github topics to hashtags.
 *
 * @return string[]
 * @since {NEWVERSION}
 */
function twitter_hash_tags() {
	$topics    = repo_topics();
	$hash_tags = array();
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

	return array_map( function ( $value ) {
		return '#' . str_replace( '-', '', $value );
	}, $hash_tags );

}

/**
 * Generates Twitter Message
 *
 * @param $msg
 * @param $tags
 * @param $default_tags
 *
 * @return string
 * @since {NEWVERSION}
 */
function form_tweet_msg( $msg, $tags, $default_tags ) {
	$tags         = ( is_array( $tags ) ) ? implode( ' ', $tags ) : $tags;
	$default_tags = ( is_array( $default_tags ) ) ? implode( ' ', $default_tags ) : $default_tags;
	$msg          = trim( $msg );
	$tags         = trim( $tags );
	$default_tags = trim( $default_tags );
	return $msg . '
' . $tags . $default_tags;
}