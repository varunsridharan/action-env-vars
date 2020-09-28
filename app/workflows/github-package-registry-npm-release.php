<?php
if ( 'github-package-registry-npm-release' === WORKFLOW_TYPE ) {
	if ( repo_has_file( 'package.json' ) ) {
		$contents = file_get_contents( repo_file( 'package.json' ) );
		$contents = json_decode( $contents, true );
		print_r( $contents );

		if ( ! ( preg_match( '#^' . '@' . REPO_OWNER . '#', $contents['name'] ) === 1 ) ) {
			$contents['name'] = '@' . REPO_OWNER . '/' . $contents['name'];
		}
		$contents['publishConfig'] = array( 'registry' => 'https://npm.pkg.github.com/' );
		print_r( $contents );
		file_put_contents( repo_file( 'package.json' ), json_encode( $contents, JSON_PRETTY_PRINT ) );
		$contents = file_get_contents( repo_file( 'package.json' ) );
		echo $contents;
	} else {
		__( '🛑 Unable To Find Package.json' );
	}
}