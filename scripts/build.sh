#!/bin/bash

if [ -z "$domain" ]; then
    echo 'domain not defined' > /dev/stderr
    exit 1
fi

cd "$(dirname "$0")"/..
ROOT=`pwd`

# build assets
( cd "$ROOT"/src/ui && npm install && DOMAIN="$domain" npm run build )
