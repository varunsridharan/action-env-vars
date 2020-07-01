<?php

class WordPress_Ignore extends Ignore_Base {

	protected function default_assets_ignore() {
		return array( '*.psd', '*.zip' );
	}

	protected function default_ignore() {
		return array_merge( array(
			'CHANGELOG.md',
			'readme.md',
			'.wordpress-org',
			'.wporgassetsignore',
			'.wporgignore',
		), parent::default_ignore() );
	}

	protected function default_assets_ignore_location() {
		return '.github/.wporgassetsignore';
	}

	protected function default_ignore_location() {
		return '.github/.wporgignore';
	}

	protected function possible_ignore_locations() {
		return array( '.wporgignore', $this->default_ignore_location() );
	}

	protected function possible_assets_ignore_locations() {
		return array( '.wporgassetsignore', $this->default_assets_ignore_location() );
	}
}