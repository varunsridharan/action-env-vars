<?php

define( 'APP_PATH', __DIR__ . '/' );

require_once APP_PATH . 'functions.php';

echo '###[group] 🛠️  Setting Required ENV Variables';
require_once APP_PATH . 'set-env-vars.php';
echo '###[endgroup]';
