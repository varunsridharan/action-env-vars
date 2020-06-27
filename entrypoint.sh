#!/bin/bash

echo " "

echo "###[group] 🛠️  Setting Required ENV Variables"
bash /vs-action-utility/setup-env.sh
echo "###[endgroup]"

echo " "

echo "###[group] Handle Envato Workflow"
bash /vs-action-utility/envato/ignore.sh
echo "###[endgroup]"

echo " "
