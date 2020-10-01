#!/bin/sh
WORKFLOW_TYPE="$INPUT_VS_WORKFLOW_TYPE"

if [ "$VS_WORKFLOW_TYPE" === "twitters-post" ]; then
  /usr/local/bin/install-php-extensions intl mbstring
fi

php /vs-utility-app/index.php
