<?php
if ( 'github-package-registry-npm-releases' === WORKFLOW_TYPE ) {
	if ( repo_has_file( 'package.json' ) ) {
		$contents = file_get_contents( repo_file( 'package.json' ) );
		$contents = json_decode( $contents, true );
		_( '###[group] 🗃️ 	Existing package.json' );
		_( print_r( $contents, true ) );
		_( '###[endgroup]' );

		if ( ! ( preg_match( '#^' . '@' . REPO_OWNER . '#', $contents['name'] ) === 1 ) ) {
			$contents['name'] = '@' . REPO_OWNER . '/' . $contents['name'];
		}
		$contents['publishConfig'] = array( 'registry' => 'https://npm.pkg.github.com/' );
		file_put_contents( repo_file( 'package.json' ), json_encode( $contents, JSON_PRETTY_PRINT ) );

		_( '###[group] 🗃️ 	Updated package.json' );
		_( print_r( $contents, true ) );
		_( '###[endgroup]' );


/*		if ( ! repo_has_file( '.npmrc' ) ) {
			$contents = '//npm.pkg.github.com/:_authToken=${GITHUB_TOKEN}' . PHP_EOL;
			$contents .= 'registry=https://npm.pkg.github.com/OWNER';
			file_put_contents( repo_file( '.npmrc' ), $contents );
		}*/

	} else {
		_( '🛑 Unable To Find Package.json' );
	}
}