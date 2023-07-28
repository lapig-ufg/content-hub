#!/bin/bash
FOLDER=~/.ssh

if [ -d "$FOLDER" ]; then
    cp -rvp ~/.ssh ssh/
else
    echo "Directory ./ssh does not exist!"
fi

docker-compose build 

docker-compose up -d 