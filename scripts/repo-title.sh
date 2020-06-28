#!/bin/bash

REPO_TITLE_DB="https://cdn.svarun.dev/json/repo-titles.json"

echo "🎞️ Checking If REPO Database Has Any"
echo "    --> Download Repo Title Database"
wget "$REPO_TITLE_DB"

echo "DB Value"
echo "ENV VAR : $GITHUB_REPOSITORY_SLUG"
JSON_KEY=".'$GITHUB_REPOSITORY_SLUG'"
echo $(jq  "$JSON_KEY" repo-titles.json)
