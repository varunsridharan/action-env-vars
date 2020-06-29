<?php

if ( ! file_exists( get_env( 'GITHUB_WORKSPACE' ) . '/.github/repos1.json' ) ) {
	throw new Error( 'EVN Repo JSON File Not Found !' );
}