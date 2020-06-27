#!/bin/bash

set_action_env () {
  echo "::set-env name=$1::$2"
}

set_action_env_ifnot_exists(){
  default_evn=$(echo ${!$1})
  if [ -z "$default_evn" ]; then
    set_action_env $1 $2
    echo "✔️ ENV  ${key} SET WITH VALUE ${EVN_VARS[$key]}"
  else
    echo ""
    echo "ℹ️ ENV ${key} ALREADY EXISTS WITH VALUE - $default_evn"
    echo ""
  fi
}