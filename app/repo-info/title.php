<?php
_echo( '' );

$repo_title = get_env( 'GITHUB_REPOSITORY_TITLE' );
if ( ! is_env_not_exists( $repo_title ) || ! empty( $repo_title ) ) {
	if ( ! is_env_not_exists( get_env( 'REPOSITORY_SLUG' ) ) ) {
		$slug        = get_env( 'REPOSITORY_SLUG' );
		$repo_titles = json_decode( file_get_contents( 'https://cdn.svarun.dev/json/repo-titles.json' ), true );
		$title       = '';
		_echo( '🎞️ Checking - Repository Title Database' );

		if ( isset( $repo_titles[ $slug ] ) ) {
			$title = $repo_titles[ $slug ];
			_echo( '✔️ Repository Title Found In Database' );
		} else {
			$title = ucwords( str_replace( '-', ' ', trim( $slug ) ) );
			_echo( '⚠️ Repository Title Not Found In Database | Using Slug is used as Title' );
		}
		set_action_env_not_exists( 'GITHUB_REPOSITORY_TITLE', $title, true );
	} else {
		_echo( '🛑 Repository SLUG Not Found !' );
	}
} else {
	_echo( "✔️ Repository Title Already Set - ${repo_title}" );
}
_echo( '' );
