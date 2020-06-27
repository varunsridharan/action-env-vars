#!/bin/bash

set_action_env () {
  echo "::set-env name=$1::$2"
}

set_action_env_ifnot_exists(){
  default_evn=$(echo ${!$1})
  if [ -z "$default_evn" ]; then
    set_action_env $1 $2
    echo "✔️ ENV $1 SET WITH VALUE $2"
  else
    echo ""
    echo "ℹ️ ENV $1 ALREADY EXISTS WITH VALUE - $default_evn"
    echo ""
  fi
}