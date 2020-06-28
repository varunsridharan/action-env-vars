<?php
_echo( '###[group] 🛠️  Setting Required ENV Variables' );

var_dump( vs_set_action_evn_ifnot_exists( 'GH_LOCAL_KEY', 'Here Is Your KEY 1' ) );
var_dump( vs_set_action_evn_ifnot_exists( 'GH_LOCAL_KEYE', 'Here Is Your KEY 2' ) );

_echo( '' );

_echo( 'Getting : GH_LOCAL_KEY' );

var_dump( getenv( 'GH_LOCAL_KEY ' ) );

_echo( '' );

_echo( '###[endgroup]' );
