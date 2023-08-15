#!/bin/bash
FOLDER=~/.ssh

if [ -d "$FOLDER" ]; then
    cp -rvp ~/.ssh ssh/
else
    echo "Directory ./ssh does not exist!"
fi

cd ../../server
composer install
cd ../docker/development

docker compose build 

docker compose up -d 