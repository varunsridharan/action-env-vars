<?php
_echo( '' );
$repo_title = get_env( 'REPOSITORY_NAME', false );
$slug       = get_env( 'REPOSITORY_SLUG', false );
$workspace  = get_env( 'GITHUB_WORKSPACE', false );
$title      = '';
$rmf        = false;

if ( ! is_env_not_exists( $slug ) ) {
	if ( file_exists( $workspace . '/readme.md' ) ) {
		$rmf = 'readme.md';
	}

	if ( file_exists( $workspace . '/README.md' ) ) {
		$rmf = 'README.md';
	}

	if ( file_exists( $workspace . '/readme.MD' ) ) {
		$rmf = 'readme.MD';
	}

	if ( file_exists( $workspace . '/README.MD' ) ) {
		$rmf = 'README.MD';
	}

	if ( ! empty( $rmf ) ) {
		_echo( '🎞️ README.md Found - Extracting Title' );
		$rmf = file_get_contents( $workspace . '/' . $rmf );
		preg_match( '/^(#\s)(.*)/m', $rmf, $matches, 0, 0 );
		if ( isset( $matches[2] ) ) {
			$matches[2] = strip_tags( Slimdown::render( $matches[2] ) );
			if ( ! empty( $matches[2] ) ) {
				$title = $matches[2];
				_echo( '✔️ Repository Title Found In README.md' );
			}
		}
	}

	if ( empty( $title ) ) {
		$repo_titles = json_decode( file_get_contents( 'https://cdn.svarun.dev/json/repo-titles.json' ), true );
		_echo( '🎞️ Checking - Repository Title Database' );

		if ( isset( $repo_titles[ $slug ] ) ) {
			$title = $repo_titles[ $slug ];
			_echo( '✔️ Repository Title Found In Database' );
		}
	}

	if ( empty( $title ) ) {
		$title = $repo_title;
		_echo( '⚠️ Repository Title Not Found In Database | Using Slug is used as Title' );
	}

	set_action_env_not_exists( 'GITHUB_REPOSITORY_TITLE', $title, true );
} else {
	_echo( '🛑 Repository SLUG Not Found !' );
}

_echo( '' );
