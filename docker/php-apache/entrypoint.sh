#!/usr/bin/env bash

set -e

GROUP_ID=${GROUP_ID-1000}
USER_ID=${USER_ID-1000}

# Permissions
groupmod -g ${GROUP_ID} www-data
usermod -u ${USER_ID} www-data

# Forward commands
if [ "$1" = "" ]; then
    exec apache2 -DFOREGROUND
elif [ "$1" = "bash" ]; then
    su www-data
else
    su www-data -c "$*"
fi
