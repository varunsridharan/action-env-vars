#!/bin/bash

set_action_env () {
  echo "::set-env name=$1::$2"
}

echo "###[group] 🛠️  Setting Required ENV Variables"
bash /vs-action-utility/setup-env.sh
echo "###[endgroup]"
