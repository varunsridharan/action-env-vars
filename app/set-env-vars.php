<?php
echo '###[group] 🛠️  Setting Required ENV Variables';

echo 'Setting UP : GH_LOCAL_KEY';
var_dump( vs_set_action_evn_ifnot_exists( 'GH_LOCAL_KEY', 'Here Is Your KEY 1' ) );

echo 'Setting UP : GH_LOCAL_KEYE';
var_dump( vs_set_action_evn_ifnot_exists( 'GH_LOCAL_KEYE', 'Here Is Your KEY 2' ) );

echo " ";

echo 'Getting : GH_LOCAL_KEY';
var_dump( getenv( 'GH_LOCAL_KEY ' ) );


echo '###[endgroup]';
