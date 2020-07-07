<?php

/**
 * Class Ignore_Base
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Ignore_Base {
	/**
	 * @var string
	 */
	protected $type = 'ignore';

	/**
	 * @var string
	 */
	protected $prefix = 'ENVATO';

	/**
	 * Ignore_Base constructor.
	 *
	 * @param bool $prefix
	 */
	public function __construct( $prefix = false ) {
		$this->prefix = $prefix;
	}

	/**
	 * @param $type
	 *
	 * @return bool|mixed
	 */
	public function run( $type ) {
		$this->type      = $type;
		$files_to_check  = ( 'ignore' === $this->type ) ? $this->possible_ignore_locations() : $this->possible_assets_ignore_locations();
		$exists_location = false;

		if ( ! empty( $files_to_check ) && is_array( $files_to_check ) ) {
			foreach ( $files_to_check as $file ) {
				_echo( 'Checking In : ' . $this->workspace() . '/' . $file );
				if ( file_exists( $this->workspace() . '/' . $file ) ) {
					$exists_location = $file;
					break;
				}
			}
		}

		_echo( ' ' );

		if ( ! empty( $exists_location ) ) {
			return $this->handle_file_exists( $exists_location );
		} else {
			return $this->handle_file_not_exits( $exists_location );
		}
	}

	/**
	 * @param $path
	 *
	 * @return mixed
	 */
	protected function handle_file_exists( $path ) {
		$ignore_file = $this->workspace() . '/' . $path;
		if ( 'ignore' === $this->type ) {
			_echo( '✔️ DISTIGNORE File Found : ' . $ignore_file );
			_echo( 'Added Predefined DISTIGNORE' );
		} else {
			_echo( '✔️ Assets DISTIGNORE File Found : ' . $ignore_file );
			_echo( 'Added Predefined Assets DISTIGNORE' );
		}
		$ignorec = trim( @file_get_contents( $ignore_file ) );
		$ignorec = array_map( 'trim', explode( PHP_EOL, $ignorec ) );
		$ignorec = array_merge( $this->default_content(), $ignorec );
		$ignorec = implode( PHP_EOL, array_filter( array_unique( $ignorec ) ) );
		$ignorec = trim( $ignorec ) . PHP_EOL;
		@file_put_contents( $ignore_file, $ignorec );
		echo_group_contents( $ignorec );
		return $path;
	}

	/**
	 * @param $path
	 *
	 * @return bool|mixed
	 */
	protected function handle_file_not_exits( $path ) {
		if ( 'ignore' === $this->type ) {
			_echo( '⚠️ DISTIGNORE File Not Found ! | Creating Default ' );
		} else {
			_echo( '⚠️ Assets DISTIGNORE File Not Found ! | Creating Default ' );
		}

		$ignore_file    = $this->workspace() . '/' . $this->default_location();
		$ignore_content = trim( implode( PHP_EOL, $this->default_content() ) );
		@file_put_contents( $ignore_file, $ignore_content );
		echo_group_contents( $ignore_content );
		return $this->default_location();
	}

	/**
	 * @return bool|mixed
	 */
	protected function default_location() {
		return ( 'ignore' === $this->type ) ? $this->default_ignore_location() : $this->default_assets_ignore_location();
	}

	/**
	 * @return array|bool|mixed
	 */
	protected function default_content() {
		return ( 'ignore' === $this->type ) ? $this->default_ignore() : $this->default_assets_ignore();
	}

	/**
	 * @return bool|\ENV_Not_Exists|mixed
	 */
	protected function workspace() {
		return get_env( 'GITHUB_WORKSPACE', '' );
	}

	/**
	 * @return bool|mixed
	 */
	protected function default_ignore_location() {
		return option( $this->prefix . '_DEFAULT_IGNORE_LOCATION', array() );

	}

	/**
	 * @return array
	 */
	protected function default_ignore() {
		return array_merge( option( $this->prefix . '_IGNORE', array() ), option( 'DEFAULT_IGNORE', array() ) );
	}

	/**
	 * @return bool|mixed
	 */
	protected function possible_ignore_locations() {
		$data   = option( $this->prefix . '_POSSIBLE_IGNORE_LOCATION', array() );
		$data[] = $this->default_ignore_location();
		return $data;
	}


	/**
	 * @return bool|mixed
	 */
	protected function default_assets_ignore() {
		return option( $this->prefix . '_ASSETS_IGNORE', array() );
	}

	/**
	 * @return bool|mixed
	 */
	protected function default_assets_ignore_location() {
		return option( $this->prefix . '_DEFAULT_ASSETS_IGNORE_LOCATION', array() );
	}

	/**
	 * @return bool|mixed
	 */
	protected function possible_assets_ignore_locations() {
		$data   = option( $this->prefix . '_POSSIBLE_ASSETS_IGNORE_LOCATION', array() );
		$data[] = $this->default_assets_ignore_location();
		return $data;
	}
}