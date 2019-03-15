#!/usr/bin/env bash

if [ ! -d laradock ]; then
    git clone --branch "v7.14" https://github.com/Laradock/laradock.git
else
    cd laradock
    git pull
    cd ..
fi

cp local/env-laradock laradock/.env

echo "Laradock installed"

