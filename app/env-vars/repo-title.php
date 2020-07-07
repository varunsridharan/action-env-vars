<?php
global $envs;
_( ' ' );
_( 'Looking For Repository README File' );
$readme_file  = false;
$title        = '';
$readme_files = array( 'readme.md', 'README.md', 'readme.MD', 'README.MD' );

if ( empty( REPO_SLUG ) ) {
	_( '🛑 Repository SLUG Not Found !' );
	return;
}

if ( ! empty( WORKSPACE ) ) {
	foreach ( $readme_files as $file ) {
		_( 'Looking In : ' . $file );
		if ( repo_has_file( $file ) ) {
			_( '✔️  File Found.' );
			$readme_file = repo_file( $file );
			$readme_file = file_get_contents( $rmf );

			preg_match( '/^(#\s)(.*)/m', $rmf, $matches, 0, 0 );
			if ( isset( $matches[2] ) ) {
				$matches[2] = strip_tags( Slimdown::render( $matches[2] ) );
				if ( ! empty( $matches[2] ) ) {
					$title = $matches[2];
					_( '✔️ Repository Title Found In ' . $file );
				}
			}
			break;
		}
	}
} else {
	_( 'No Repository Content Found.' );
}

if ( empty( $title ) ) {
	$repo_titles = json_decode( file_get_contents( 'https://cdn.svarun.dev/json/repo-titles.json' ), true );
	_( '🎞️ Checking - Repository Title Database' );

	if ( isset( $repo_titles[ REPO_SLUG ] ) ) {
		$title = $repo_titles[ REPO_SLUG ];
		_( '✔️ Repository Title Found In Database' );
	}
}

if ( empty( $title ) ) {
	$title = REPO_NAME;
	_echo( '⚠️ Repository Title Not Found In Database | Using Slug is used as Title' );
}

$envs['GITHUB_REPOSITORY_TITLE'] = $title;
