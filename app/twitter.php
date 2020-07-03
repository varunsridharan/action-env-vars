<?php
$topics = get_env( 'REPOSITORY_TOPICS' );

var_dump( $topics );

var_dump( json_decode( $topics, true ) );