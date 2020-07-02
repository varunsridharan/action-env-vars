<?php

$token = get_env( 'GITHUB_TOKEN' );
$repo  = get_env( 'GITHUB_REPOSITORY' );


set_time_limit( 0 );

use Milo\Github\Api;
use Milo\Github\OAuth\Token;

$gh_api = new Api();
$gh_api->setToken( new Token( $token ) );
$data = $gh_api->decode( $gh_api->get( 'repos/' . $repo ) );
_echo( ' ' );
_echo( json_encode( $data ) );
_echo( '' );
_echo( var_export( $data, true ) );
