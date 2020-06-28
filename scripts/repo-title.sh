#!/bin/bash

REPO_TITLE_DB="https://cdn.svarun.dev/json/repo-titles.json"

echo "🎞️ Checking If REPO Database Has Any"
echo "    --> Download Repo Title Database"
wget "$REPO_TITLE_DB"

echo "DB Value"
echo $(jq  "'.\"$GITHUB_REPOSITORY_SLUG\"'" repo-titles.json)
