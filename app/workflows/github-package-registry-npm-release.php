<?php
if ( 'github-package-registry-npm-release' === WORKFLOW_TYPE ) {
	if ( repo_has_file( 'package.json' ) ) {
		$contents = file_get_contents( repo_file( 'package.json' ) );
		$contents = json_decode( $contents, true );
		print_r( $contents );

		if ( preg_match( '#^' . '@varunsridharan' . '#', $contents['name'] ) === 1 ) {

		} else {
			$contents['name'] = '@' . REPO_OWNER . '/' . $contents['name'];
		}
		print_r( $contents );

	} else {
		__( '🛑 Unable To Find Package.json' );
	}
}