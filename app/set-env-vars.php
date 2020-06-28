<?php
_echo( '###[group] 🛠️  Setting Required ENV Variables' );

var_dump( set_action_env_not_exists( 'GH_LOCAL_KEY', 'Here Is Your KEY 1' ) );
var_dump( set_action_env_not_exists( 'GH_LOCAL_KEYE', 'Here Is Your KEY 2' ) );

_echo( '' );

_echo( 'Getting : GH_LOCAL_KEY' );

var_dump( get_env( 'GH_LOCAL_KEY' ) );

_echo( '' );

_echo( '###[endgroup]' );
