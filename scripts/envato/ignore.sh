#!/bin/bash

# Loads Common Funtion
. /vs-action-utility/functions.sh

DIST_IGNORE_LOCATION=""
DIST_ASSETS_IGNORE_LOCATION=""
DEFAULT_DIST_IGNORE_LOCATION="$GITHUB_WORKSPACE/.github/distignore.txt"
DEFAULT_DIST_ASSETS_IGNORE_LOCATION="$GITHUB_WORKSPACE/.github/assets-distignore.txt"

if [ -f "$GITHUB_WORKSPACE/envato-distignore.txt" ]; then
  DIST_IGNORE_LOCATION="$GITHUB_WORKSPACE/envato-distignore.txt"
elif [ -f "$GITHUB_WORKSPACE/.github/envato-distignore.txt" ]; then
  DIST_IGNORE_LOCATION="$GITHUB_WORKSPACE/.github/envato-distignore.txt"
elif [ -f "$GITHUB_WORKSPACE/distignore.txt" ]; then
  DIST_IGNORE_LOCATION="$GITHUB_WORKSPACE/.distignore.txt"
elif [ -f "$DEFAULT_DIST_IGNORE_LOCATION" ]; then
  DIST_IGNORE_LOCATION="$DEFAULT_DIST_IGNORE_LOCATION"
fi

if [ -f "$GITHUB_WORKSPACE/assets-distignore.txt" ]; then
  DIST_IGNORE_LOCATION="$GITHUB_WORKSPACE/assets-distignore.txt"
elif [ -f "$GITHUB_WORKSPACE/envato_assets_exclude_list.txt" ]; then
  DIST_IGNORE_LOCATION="$GITHUB_WORKSPACE/envato_assets_exclude_list.txt"
elif [ -f "$DEFAULT_DIST_ASSETS_IGNORE_LOCATION" ]; then
  DIST_IGNORE_LOCATION="$DEFAULT_DIST_ASSETS_IGNORE_LOCATION"
fi

if [ -z "$DIST_IGNORE_LOCATION" ]; then
  echo "⚠️ DISTIGNORE File Not Found ! | Creating Default "
  DIST_IGNORE_LOCATION="$DEFAULT_DIST_IGNORE_LOCATION"
  echo "/src/ gulpfile.js gulp-config.js composer.lock composer.json wp-pot.json envato_assets_exclude_list.txt" | tr " " "\n" >>"$DIST_IGNORE_LOCATION"
  echo ".envatoassets .gitignore .editorconfig vendor/*/*/README.md vendor/*/*/.gitignore" | tr " " "\n" >>"$DIST_IGNORE_LOCATION"
else
  echo "✔️ DISTIGNORE File Found : $DIST_IGNORE_LOCATION"
fi

if [ -z "$DIST_ASSETS_IGNORE_LOCATION" ]; then
  echo "⚠️ Assets DISTIGNORE File Not Found ! | Creating Default "
  DIST_ASSETS_IGNORE_LOCATION="$DEFAULT_DIST_ASSETS_IGNORE_LOCATION"
  echo "screenshots/* psd/*.zip" | tr " " "\n" >>"$DIST_ASSETS_IGNORE_LOCATION"
else
  echo "✔️ Assets DISTIGNORE File Found : $DIST_ASSETS_IGNORE_LOCATION"
fi

set_action_env_ifnot_exists "ENVATO_ASSETS_DIST_IGNORE" "$DIST_ASSETS_IGNORE_LOCATION"