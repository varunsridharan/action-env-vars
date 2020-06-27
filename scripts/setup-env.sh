#!/bin/bash

declare -A EVN_VARS

##### General Use Vars ###
EVN_VARS[GITHUB_REPOSITORY_OWNER]=$(echo $GITHUB_REPOSITORY | cut -d'/' -f 1)
EVN_VARS[GITHUB_REPOSITORY_NAME]=$(echo $GITHUB_REPOSITORY | cut -d'/' -f 2)
EVN_VARS[GITHUB_REF_NAME]=$(echo $GITHUB_REF | cut -d'/' -f 3)
EVN_VARS[GITHUB_SHA_SHORT]=$(echo $GITHUB_SHA | cut -c1-8)

# Custom Vars Just For My Personal Work Flows
EVN_VARS[VS_BEFORE_HOOK_FILE]="before.sh"
EVN_VARS[VS_AFTER_HOOK_FILE]="after.sh"
EVN_VARS[VS_BEFORE_HOOK_FILE_LOCATION]="$GITHUB_WORKSPACE/.github/workflows/${EVN_VARS[VS_BEFORE_HOOK_FILE]}"
EVN_VARS[VS_AFTER_HOOK_FILE_LOCATION]="$GITHUB_WORKSPACE/.github/workflows/${EVN_VARS[VS_AFTER_HOOK_FILE]}"

# Custom Vars For  # gitbook-change-log-updater #
EVN_VARS[CHLOG_REPO_ORG_NAME]="vs-docs"
EVN_VARS[LOCAL_CHANGE_LOG_FILE]="CHANGELOG.md"
EVN_VARS[REMOTE_CHANGE_LOG_FILE]="change-log.md"

for key in "${!EVN_VARS[@]}"; do
  default_evn=$(echo ${!key})
  if [ -z "$default_evn" ]; then
    set_action_env ${key} ${ENV_VARS[$key]}
    echo "✔️ ENV  ${key} SET WITH VALUE ${EVN_VARS[$key]}"
  else
    echo ""
    echo "ℹ️ ENV ${key} ALREADY EXISTS WITH VALUE - $default_evn"
    echo ""
  fi
done
