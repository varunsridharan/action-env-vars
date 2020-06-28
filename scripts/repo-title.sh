#!/bin/bash

REPO_TITLE_DB="https://cdn.svarun.dev/json/repo-titles.json"

echo "🎞️ Checking If REPO Database Has Any"
echo "    --> Download Repo Title Database"
wget "$REPO_TITLE_DB"

if [ jq "has('$GITHUB_REPOSITORY_SLUG')" repo-titles.json ]; then
  echo $(jq ".$GITHUB_REPOSITORY_SLUG" repo-titles.json)
fi
