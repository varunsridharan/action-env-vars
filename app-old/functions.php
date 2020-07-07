<?php
global $vs_args;
$vs_args = array();
function option( $key, $default = false ) {
	global $vs_args;
	if ( empty( $vs_args ) ) {
		$vs_args = json_decode( file_get_contents( APP_PATH . 'config.json' ), true );
	}
	return ( isset( $vs_args[ $key ] ) ) ? $vs_args[ $key ] : $default;
}

/**
 * Sets Global ENV Variable For Github Action
 *
 * @param $key
 * @param $value
 * @param $msg
 *
 * @return true
 */
function set_action_env( $key, $value, $msg = false ) {
	_echo( "::set-env name=${key}::${value}" );
	$_ENV[ $key ] = $value;
	if ( $msg ) {
		_echo( "✔️ ENV  ${key} SET WITH VALUE ${value}" );
	}
	return true;
}

/**
 * Sets ENV If not exists.
 *
 * @param $key
 * @param $value
 * @param $msg
 *
 * @return bool
 */
function set_action_env_not_exists( $key, $value, $msg = false ) {
	if ( ! isset( $_ENV[ $key ] ) ) {
		set_action_env( $key, $value, $msg );
		return true;
	}
	_echo( "ℹ️ ENV ${key} ALREADY EXISTS WITH VALUE - {$_ENV[$key]}" );
	return false;
}

/**
 * @param      $key
 * @param null $default
 *
 * @return \ENV_Not_Exists|mixed
 */
function get_env( $key, $default = null ) {
	$default = ( null === $default ) ? new ENV_Not_Exists() : $default;
	return ( isset( $_ENV[ $key ] ) ) ? $_ENV[ $key ] : $default;
}

/**
 * @param $instance
 *
 * @return bool
 */
function is_env_not_exists( $instance ) {
	return ( $instance instanceof \ENV_Not_Exists );
}

/**
 * @param      $content
 */
function _echo( $content ) {
	echo $content . PHP_EOL;
}

/**
 * @param $content
 */
function echo_group_contents( $content ) {
	_echo( '------------------------------------' );
	_echo( $content );
	_echo( '------------------------------------' );
	_echo( ' ' );
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
	$token = get_env( 'SVA_ONL_TOKEN', false );

	if ( empty( $token ) ) {
		_echo( 'https://sva.onl API Token Missing !' );
	}
	$shurl = sva_shorturl( get_env( 'SVA_ONL_TOKEN', false ), $url );
	if ( isset( $shurl['short'] ) && isset( $shurl['error'] ) && 0 === $shurl['error'] ) {
		_echo( 'Short URL : ' . $shurl['short'] );
		return $shurl['short'];
	}
	_echo( 'Unable To Short URL !!' );
	return $url;
}

function form_tweet_msg( $msg, $tags, $default_tags ) {
	$tags         = ( is_array( $tags ) ) ? implode( ' ', $tags ) : $tags;
	$default_tags = ( is_array( $default_tags ) ) ? implode( ' ', $default_tags ) : $default_tags;
	$msg          = trim( $msg );
	$tags         = trim( $tags );
	$default_tags = trim( $default_tags );
	return $msg . '
' . $tags . $default_tags;
}