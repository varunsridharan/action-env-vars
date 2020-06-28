<?php

var_dump( vs_set_action_evn_ifnot_exists( 'GH_LOCAL_KEY', 'Here Is Your KEY 1' ) );
var_dump( vs_set_action_evn_ifnot_exists( 'GH_LOCAL_KEYE', 'Here Is Your KEY 2' ) );
var_dump( getenv( 'GH_LOCAL_KEY ' ) );