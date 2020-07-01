<?php

class Envato_Ignore extends Ignore_Base {

	protected function default_assets_ignore() {
		return array( 'screenshots/*', 'psd/*.zip' );
	}

	protected function default_ignore() {
		return array_merge( array(
			'gulp-config.js',
			'envato_assets_exclude_list.txt',
			'.envatoassets',
		), parent::default_ignore() );
	}

	protected function default_assets_ignore_location() {
		return '.github/assets-distignore.txt';
	}

	protected function default_ignore_location() {
		return '.github/distignore.txt';
	}

	protected function possible_ignore_locations() {
		return array(
			'envato-distignore.txt',
			'.github/envato-distignore.txt',
			'distignore.txt',
			$this->default_ignore_location(),
		);
	}

	protected function possible_assets_ignore_locations() {
		return array(
			'assets-distignore.txt',
			'envato_assets_exclude_list.txt',
			$this->default_assets_ignore_location(),
		);
	}
}