<?php
_echo( '###[group] 🔧 Setup Repository Title' );

$repo_titles = json_decode( file_get_contents( 'https://cdn.svarun.dev/json/repo-titles.json' ), true );

_echo( '🎞️ Checking - Repository Title Database' );

var_dump( get_env( 'GITHUB_REPOSITORY_SLUG' ) );
_echo( '::error:: Unknown Error 1' );
_echo( '::error :: Unknown Error 2' );
_echo( '::warning:: Unknown Warning 1' );
_echo( '::warning :: Unknown Error 2' );

_echo( '###[group]' );