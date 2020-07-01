<?php

class WordPress_Ignore extends Ignore_Base {

	protected function default_assets_ignore() {
		return array( '*.psd', '*.zip' );
	}

	protected function default_ignore() {
		return array(
			'vendor/*/*/README.md',
			'vendor/*/*/readme.md',
			'vendor/*/*/LICENSE',
			'vendor/*/*/composer.json',
			'vendor/*/*/.editorconfig',
			'vendor/*/*/CHANGELOG.md',
			'vendor/*/*/CODE_OF_CONDUCT.md',
			'vendor/*/*/composer.lock',
			'vendor/*/*/bin',
			'vendor/*/*/.gitignore',
			'vendor/*/*/.gitattributes',
			'vendor/*/*/.all-contributorsrc',
			'vendor/*/*/package-lock.json',
			'vendor/*/*/package.json',
			'vendor/*/*/wp-pot.json',
			'vendor/composer/LICENSE',
			'vendor/composer/installed.json',
			'.all-contributorsrc',
			'.editorconfig',
			'.gitattributes',
			'.gitignore',
			'.git',
			'.github',
			'CHANGELOG.md',
			'readme.md',
			'LICENSE',
			'composer.json',
			'composer.lock',
			'vendor/bin',
			'config.js',
			'gulp-custom.js',
			'gulpfile.js',
			'package.json',
			'package-lock.json',
			'wp-pot.json',
			'.wordpress-org',
			'.wporgassetsignore',
			'.wporgignore',
			'/src/',
		);
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