#!/bin/bash

rsync -a --delete --delete --delete-excluded --exclude=".*" --exclude="tests*" --exclude="docs*" --exclude="bin*" --exclude="composer.lock*" --exclude="composer.json*" --exclude="README.md*" --exclude="storage/tmp/" --exclude="storage/install.zip" --exclude="zip.sh" . storage/tmp
cd storage/tmp
rm -f ../install.zip
zip -r ../install.zip . > /dev/null
cd ../
rm -rf tmp
echo "Archive created at storage/install.zip"